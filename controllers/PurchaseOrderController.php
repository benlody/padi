<?php

namespace app\controllers;
use app\models\Product;
use app\models\PurchaseOrder;
use app\models\PurchaseOrderSearch;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;

require_once __DIR__  . '/../utils/utils.php';

class PurchaseOrderController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
	public function actionAdd()
	{
		$model = new PurchaseOrder;
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if($post_param["PurchaseOrder"]){

			$post_param['PurchaseOrder']['content'] = json_encode($this->get_content($post_param), JSON_FORCE_OBJECT);
			$post_param['PurchaseOrder']['date'] = date("Y-m-d", strtotime($post_param['PurchaseOrder']['date']));
			$post_param['PurchaseOrder']['id'] = $post_param['PurchaseOrder']['id'].'-'.$post_param['product'];

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

		if(isset($post_param['done'])){

			$done_date = date("Y-m-d", strtotime($post_param['PurchaseOrder']['done_date']));
			$warehouse = $post_param['PurchaseOrder']['warehouse'];

			$post_param['PurchaseOrder']['content'] = json_encode($content, JSON_FORCE_OBJECT);
			$post_param['PurchaseOrder']['done_date'] = $done_date;

			foreach ($post_param['PurchaseOrder'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = PurchaseOrder::STATUS_DONE;

			//FIXME error handle
			$model->update();

			$padi_balance_model = new Balance1($warehouse, 'padi');
			$self_balance_model = new Balance2($warehouse, 'self');
			$self_transaction_model = new Transaction1($warehouse, 'self');
			$padi_transaction_model = new Transaction2($warehouse, 'padi');
			get_balance($padi_balance_model, $warehouse, 'padi');
			get_balance($self_balance_model, $warehouse, 'self');

			$now = strtotime('now');
			$padi_transaction_model->serial = 'PO_'.$post_param['PurchaseOrder']['id'].'_'.$now;;
			$self_transaction_model->serial = 'PO_'.$post_param['PurchaseOrder']['id'].'_'.$now;;
			$padi_balance_model->serial = 'PO_'.$post_param['PurchaseOrder']['id'].'_'.$now;;
			$self_balance_model->serial = 'PO_'.$post_param['PurchaseOrder']['id'].'_'.$now;;
			$padi_transaction_model->date = $done_date;
			$self_transaction_model->date = $done_date;
			$padi_balance_model->date = $done_date;
			$self_balance_model->date = $done_date;

			foreach ($content as $key => $value) {
				$padi_transaction_model->$key = $value['padi_cnt'];
				$self_transaction_model->$key = $value['self_cnt'];
				$padi_balance_model->$key = $padi_balance_model->$key + $padi_transaction_model->$key;
				$self_balance_model->$key = $self_balance_model->$key + $self_transaction_model->$key;
			}

			$padi_transaction_model->insert();
			$self_transaction_model->insert();
			$padi_balance_model->insert();
			$self_balance_model->insert();

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

	public function actionList($status='', $detail = true, $sort='-date')
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
			'detail' => $detail,
			'sort' => $sort,
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

		if(!$post_param["product"]){
			return;
		}

		if(0 == strcmp($post_param["product"], "empty")){
			return;
		}

		$order_cnt = $post_param["order_cnt"];
		$print_cnt = $post_param["print_cnt"];
		$padi_cnt = $post_param["padi_cnt"];
		$self_cnt = $post_param["self_cnt"];
		$product_id =  $post_param["product"];

		$cnt = array();
		$cnt["order_cnt"] = intval($order_cnt);
		$cnt["print_cnt"] = intval($print_cnt);
		$cnt["padi_cnt"] = intval($padi_cnt);
		$cnt["self_cnt"] = intval($self_cnt);
		$content[$product_id] = $cnt;

		return $content;
	}
}
