<?php

namespace app\controllers;
use app\models\Product;
use app\models\PurchaseOrder;
use app\models\PurchaseOrderSearch;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use Yii;

class PurchaseOrderController extends \yii\web\Controller
{
	public function actionAdd()
	{
		$model = new PurchaseOrder;
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if($post_param["PurchaseOrder"]){

			$post_param['PurchaseOrder']['content'] = json_encode($this->get_content($post_param), JSON_FORCE_OBJECT);
			$post_param['PurchaseOrder']['date'] = date("Y-m-d", strtotime($post_param['PurchaseOrder']['date']));

			foreach ($post_param['PurchaseOrder'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = PurchaseOrder::STATUS_NEW;

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

	public function actionEdit($id)
	{

		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();
		$content = $this->get_content($post_param);

		if(isset($post_param['save'])){

			$post_param['PurchaseOrder']['content'] = json_encode($content, JSON_FORCE_OBJECT);

			foreach ($post_param['PurchaseOrder'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = PurchaseOrder::STATUS_NEW;

			//FIXME error handle
			$model->update();

			return $this->redirect(['list']);


		} else if(isset($post_param['done'])){

			$done_date = date("Y-m-d", strtotime($post_param['done_date']));

			$post_param['PurchaseOrder']['content'] = json_encode($content, JSON_FORCE_OBJECT);
			$post_param['PurchaseOrder']['done_date'] = $done_date;

			foreach ($post_param['PurchaseOrder'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = PurchaseOrder::STATUS_DONE;

			//FIXME error handle
			$model->update();

			$padi_balance_model = new Balance1($post_param['PurchaseOrder']['warehouse'], 'padi');
			$self_balance_model = new Balance2($post_param['PurchaseOrder']['warehouse'], 'self');
			$self_transaction_model = new Transaction1($post_param['PurchaseOrder']['warehouse'], 'self');
			$padi_transaction_model = new Transaction2($post_param['PurchaseOrder']['warehouse'], 'padi');

			$padi_balance = $padi_balance_model->find()
				->orderBy('ts DESC')
				->one();

			$self_balance = $self_balance_model->find()
				->orderBy('ts DESC')
				->one();

			$padi_transaction_model->serial = 'PO_'.$post_param['PurchaseOrder']['id'];
			$self_transaction_model->serial = 'PO_'.$post_param['PurchaseOrder']['id'];
			$padi_balance->serial = 'PO_'.$post_param['PurchaseOrder']['id'];
			$self_balance->serial = 'PO_'.$post_param['PurchaseOrder']['id'];
			$padi_transaction_model->date = $done_date;
			$self_transaction_model->date = $done_date;
			$padi_balance->date = $done_date;
			$self_balance->date = $done_date;

			foreach ($content as $key => $value) {
				$padi_transaction_model->$key = $value['order_cnt'];
				$self_transaction_model->$key = $value['print_cnt'] - $value['order_cnt'];
				$padi_balance->$key = $padi_balance->$key + $padi_transaction_model->$key;
				$self_balance->$key = $self_balance->$key + $self_transaction_model->$key;
			}


			$padi_transaction_model->insert();
			$self_transaction_model->insert();
			$padi_balance->insert();
			$self_balance->insert();

			return $this->redirect(['list', 'status' => 'done']);

		} else {

			// FIXME avoid edit a done PO

			return $this->render('edit', [
				'model' => $model,
			]);
		}
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionList($status='')
	{

		$searchModel = new PurchaseOrderSearch();
		if(0 == strcmp($status, 'done')){
			$search_param['PurchaseOrderSearch'] = array('status' => PurchaseOrder::STATUS_DONE);
		} else {
			$search_param['PurchaseOrderSearch'] = array('status' => PurchaseOrder::STATUS_NEW);
		}
		$dataProvider = $searchModel->search($search_param);

		return $this->render('list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'status' => $status,
		]);

	}

	/**
	 * Finds the PurchaseOrder model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return PurchaseOrder the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = PurchaseOrder::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	protected function get_content($post_param){

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

		return $content;
	}
}
