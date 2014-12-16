<?php

namespace app\controllers;
use app\models\Product;
use app\models\PurchaseOrder;
use Yii;

class PurchaseOrderController extends \yii\web\Controller
{
	public function actionAdd()
	{
		$model = new PurchaseOrder;
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if($post_param["PurchaseOrder"]){
			$x = 0;
			$content = array();

			while(1){

				$product_idx = "product_".$x;
				$order_cnt_idx = "order_cnt_".$x;
				$print_cnt_idx = "print_cnt_".$x;

				if(!$post_param[$product_idx]){
					break;
				}

				if(0 == strcmp($post_param[$product_idx], "empty")){
					$x++;
					continue;
				}

				$order_cnt = $post_param[$order_cnt_idx];
				$print_cnt = $post_param[$print_cnt_idx];
				$product_id =  $post_param[$product_idx];

				$cnt = array();
				$cnt["order_cnt"] = intval($order_cnt);
				$cnt["print_cnt"] = intval($print_cnt);
				$content[$product_id] = $cnt;

				$x++;
			}
			$post_param['PurchaseOrder']['content'] = json_encode($content,JSON_FORCE_OBJECT);
			$post_param['PurchaseOrder']['date'] = date("Y-m-d", strtotime($post_param['PurchaseOrder']['date']));

			foreach ($post_param['PurchaseOrder'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = 0;

			//FIXME error handle
			$model->insert();

			return $this->redirect(['list']);

		} else {
			return $this->render('add', [
				'model' => $model,
				'product' =>  $product->find()->column()
			]);			
		}
	}

	public function actionCancel()
	{
		return $this->render('cancel');
	}

	public function actionEdit()
	{
		return $this->render('edit');
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionList()
	{
		return $this->render('list');
	}

}
