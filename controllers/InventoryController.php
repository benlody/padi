<?php

namespace app\controllers;
use app\models\Product;
use app\models\CrewPak;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use yii\db\Query;
use Yii;

class InventoryController extends \yii\web\Controller
{
	public function actionAdjust()
	{
		$product = new Product();
		$post_param = Yii::$app->request->post();

		if(isset($post_param['adjust'])){

			print_r($post_param);

			$warehouse = $post_param['warehouse'];
			$warehouse_type = $post_param['warehouse_type'];
			$balance_model = new Balance1($warehouse, $warehouse_type);
			$transaction_model = new Transaction1($warehouse, $warehouse_type);
			$query = new Query;

			$balance = $query->select('*')
								->from($warehouse.'_'.$warehouse_type.'_balance')
								->orderBy('ts DESC')
								->one();


			foreach ($balance_model->attributes() as $key => $p_name) {
				if($key < 4 ){
					continue;
				}
				$balance_model->$p_name = $balance[$p_name];
			}

			$x = 0;
			while(1){

				$product_idx = "product_".$x;
				$product_cnt_idx = "product_cnt_".$x;

				if(!isset($post_param[$product_idx])){
					break;
				}

				$product_id =  $post_param[$product_idx];
				$product_cnt = $post_param[$product_cnt_idx];

				$balance_model->$product_id = $product_cnt;
				$transaction_model->$product_id = $product_cnt - $balance[$product_id];

				$x++;
			}

			$now = strtotime('now');
			$today = date("Y-m-d", strtotime('today'));

			$transaction_model->serial = 'adjust_'.$now;
			$transaction_model->date = $today;
			$transaction_model->extra_info = $post_param['extra_info'];

			$balance_model->serial = 'adjust_'.$now;
			$balance_model->date = $today;
			$balance_model->extra_info = $post_param['extra_info'];

			$transaction_model->insert();
			$balance_model->insert();

			return $this->redirect(['overview']);

		} else {
			return $this->render('adjust', [
				'product' =>  $product->find()->column()
			]);
		}
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionOverview()
	{
		return $this->render('overview');
	}

	public function actionTransfer()
	{
		return $this->render('transfer');
	}

}
