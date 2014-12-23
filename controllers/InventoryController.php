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

require_once __DIR__  . '/../utils/utils.php';

class InventoryController extends \yii\web\Controller
{
	public function actionAdjust()
	{
		$product = new Product();
		$post_param = Yii::$app->request->post();

		if(isset($post_param['adjust'])){

			$warehouse = $post_param['warehouse'];
			$warehouse_type = $post_param['warehouse_type'];
			$balance_model = new Balance1($warehouse, $warehouse_type);
			$transaction_model = new Transaction1($warehouse, $warehouse_type);
			get_balance($balance_model, $warehouse, $warehouse_type);

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

	public function actionTransaction($warehouse='xm', $type='padi', $from='', $to='')
	{
		$product = Product::find()->column();
		$query = new Query;
		$query2 = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}
		$start_balance = $query->select('*')
						->from($warehouse.'_'.$type.'_balance')
						->where('ts < "'.$from.'"')
						->orderBy('ts DESC')
						->one();

		$end_balance = $query->select('*')
						->from($warehouse.'_'.$type.'_balance')
						->where('ts <= "'.$to.'"')
						->orderBy('ts DESC')
						->one();

		$transaction = $query->select('*')
						->from($warehouse.'_'.$type.'_transaction')
						->where('ts BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('ts DESC')
						->all();

		foreach ($transaction as $key => $t) {
			$pos1 = strpos($t['serial'], '_');
			$pos2 = strrpos($t['serial'], '_');
			$t['id'] = substr($t['serial'], $pos1 + 1, $pos2 - $pos1 - 1);
			$t['desc'] = substr($t['serial'], 0, $pos1);
			$transaction[$key] = $t;
		}

		$crewpak = $query2->select('*')
						->from('crew_pak')
						->all();

		foreach ($crewpak as $c) {
			$crew_list[$c['id']] = array();
			foreach ($product as $p) {
				if(0 != $c[$p]){
					array_push($crew_list[$c['id']], $p);
				}
			}
		}

		return $this->render('transaction',[
			'warehouse' => $warehouse,
			'type' => $type,
			'from' => $from,
			'to' => $to,
			'start_balance' => $start_balance,
			'end_balance' => $end_balance,
			'transaction' => $transaction,
			'product' => $product,
			'crew_list' => $crew_list
		]);
	}

}
