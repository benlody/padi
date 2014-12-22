<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use app\models\CrewPak;
use app\models\Product;
use app\models\Customer;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use yii\db\Query;
use Yii;

require_once __DIR__  . '/../utils/utils.php';

class OrderController extends \yii\web\Controller
{
	public function actionAdd()
	{
		
		$model = new Order;
		$customer = new Customer();
		$crewpak = new CrewPak();
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){

			$post_param['Order']['content'] = json_encode($this->get_content($post_param), JSON_FORCE_OBJECT);
			$post_param['Order']['date'] = date("Y-m-d", strtotime($post_param['date']));
			$post_param['Order']['customer_id'] = $post_param['customer_id'];

			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = Order::STATUS_NEW;

			//FIXME error handle
			$model->insert();

			return $this->redirect(['list']);

		} else {
			return $this->render('add', [
				'model' => $model,
				'customer' => $customer->find()->column(),
				'crewpak' =>  $crewpak->find()->column(),
				'product' =>  $product->find()->column()
			]);
		}
	}

	public function actionList($status='')
	{

		$searchModel = new OrderSearch();
		if(0 == strcmp($status, 'done')){
			$search_param['OrderSearch'] = array('status' => Order::STATUS_DONE);
		} else {
			$search_param['OrderSearch'] = array('status' => Order::STATUS_NEW);
		}
		$dataProvider = $searchModel->search($search_param);

		return $this->render('list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'status' => $status,
		]);

	}

	public function actionEdit($id)
	{

		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();
		$old_content = json_decode($model->content);
		$content = $old_content;

		if(isset($post_param['done'])){
			$warehouse = $post_param['Order']['warehouse'];
			$padi_balance_model = new Balance1($warehouse, 'padi');
			$padi_transaction_model = new Transaction1($warehouse, 'padi');
			get_balance($padi_balance_model, $warehouse, 'padi');

			if(isset($post_param['product'])){
				foreach ($post_param['product'] as $product => $done) {
					$content->product->$product->done = true;
					$padi_transaction_model->$product -= $content->product->$product->cnt;
					$padi_balance_model->$product -= $content->product->$product->cnt;
				}
			}

			if(isset($post_param['crewpak'])){
				foreach ($post_param['crewpak'] as $crewpak => $done) {
					$content->crewpak->$crewpak->done = true;
				}
			}

			if(isset($post_param['detail'])){
				foreach ($post_param['detail'] as $crewpak => $detail) {
					foreach ($detail as $product => $done) {
						$content->crewpak->$crewpak->detail->$product->done = true;
						$padi_transaction_model->$product -= $content->crewpak->$crewpak->detail->$product->cnt;
						$padi_balance_model->$product -= $content->crewpak->$crewpak->detail->$product->cnt;
					}
				}
			}

			$post_param['Order']['content'] = json_encode($content);
			$post_param['Order']['done_date'] = date("Y-m-d", strtotime($post_param['Order']['done_date']));
			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = Order::STATUS_DONE;

			foreach ($content->product as $product => $value) {
				if($value->done == false){
					$model->status = Order::STATUS_NEW;
					break;
				}
			}

			foreach ($content->crewpak as $crewpak => $value) {
				if($value->done == false){
					$model->status = Order::STATUS_NEW;
					break;
				}
			}

			$padi_transaction_model->serial = 'order_'.$post_param['Order']['id'];
			$padi_transaction_model->date = $post_param['Order']['done_date'];
			$padi_balance_model->serial = 'order_'.$post_param['Order']['id'];
			$padi_balance_model->date = $post_param['Order']['done_date'];

			$model->update();
			$padi_transaction_model->insert();
			$padi_balance_model->insert();

			if($model->status == Order::STATUS_DONE){
				return $this->redirect(['list', 'status' => 'done']);
			} else {
				return $this->redirect(['list']);
			}

		} else {

			// FIXME avoid edit a done order

			return $this->render('edit', [
				'model' => $model,
			]);
		}
	}


	public function actionDelete()
	{
		return $this->render('delete');
	}

	public function actionGet()
	{
		return $this->render('get');
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Finds the Order model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return Order the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Order::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	protected function get_content($post_param){

		$product_content = array();
		$crewpak_content = array();

		$x = 0;
		while(1){

			$product_idx = "product_".$x;
			$product_cnt_idx = "product_cnt_".$x;

			if(!isset($post_param[$product_idx])){
				break;
			}

			if(0 == strcmp($post_param[$product_idx], "")){
				$x++;
				continue;
			}

			$product_cnt = $post_param[$product_cnt_idx];

			if(0 >= $product_cnt){
				$x++;
				continue;
			}

			$product_id =  $post_param[$product_idx];
			$product_content[$product_id]['cnt'] = $product_cnt;
			$product_content[$product_id]['done'] = false;

			$x++;
		}

		$x = 0;

		while(1){

			$crewpak_idx = "crew_pak_".$x;
			$crewpak_cnt_idx = "crew_pak_cnt_".$x;

			if(!isset($post_param[$crewpak_idx])){
				break;
			}

			if(0 == strcmp($post_param[$crewpak_idx], "")){
				$x++;
				continue;
			}

			$crewpak_cnt = $post_param[$crewpak_cnt_idx];

			if(0 >= $crewpak_cnt){
				$x++;
				continue;
			}

			$crewpak_id =  $post_param[$crewpak_idx];
			$crewpak = CrewPak::find()
				->where(['id' => $crewpak_id])
				->one();

			$crewpak_content[$crewpak_id]['cnt'] = $crewpak_cnt;
			$detail = array();
			foreach ($crewpak->attributes() as $key => $p_name) {
				if($key < 4 || $crewpak->$p_name == 0){
					continue;
				}
				$detail[$p_name]['cnt'] = $crewpak->$p_name * $crewpak_cnt;
				$detail[$p_name]['done'] = false;
			}
			$crewpak_content[$crewpak_id]['detail'] = $detail;
			$crewpak_content[$crewpak_id]['done'] = false;

			$x++;
		}

		$content['product'] = $product_content;
		$content['crewpak'] = $crewpak_content;

		return $content;
	}
}
