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
use Yii;

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
		$content = $this->get_content($post_param);

		if(isset($post_param['done'])){

			$post_param['Order']['content'] = json_encode($content);
			$post_param['Order']['done_date'] = date("Y-m-d", strtotime($post_param['Order']['done_date']));
			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = Order::STATUS_DONE;

			$model->update();

			$padi_balance_model = new Balance1($post_param['Order']['warehouse'], 'padi');
			$padi_transaction_model = new Transaction1($post_param['Order']['warehouse'], 'padi');
			$padi_balance = $padi_balance_model->find()
				->orderBy('ts DESC')
				->one();

			$padi_transaction_model->serial = 'order_'.$post_param['Order']['id'];
			$padi_transaction_model->date = $post_param['Order']['done_date'];
			$padi_balance->serial = 'order_'.$post_param['Order']['id'];
			$padi_balance->date = $post_param['Order']['done_date'];

			foreach ($content['product'] as $key => $value) {
				$padi_transaction_model->$key -= $value;
				$padi_balance->$key -= $value;
			}

			foreach ($content['crewpak'] as $key1 => $value1) {
				$crewpak = CrewPak::find()
					->where(['id' => $key1])
					->one();

				foreach ($crewpak->attributes() as $key2 => $value2) {
					if($key2 < 4){
						continue;
					}
					$padi_transaction_model->$value2 -= ($crewpak->$value2) * $value1;
					$padi_balance->$value2 -= ($crewpak->$value2) * $value1;
				}
			}

			$padi_transaction_model->insert();
			$padi_balance->insert();

			return $this->redirect(['list', 'status' => 'done']);

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
			$product_content[$product_id] = $product_cnt;

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
			$crewpak_content[$crewpak_id] = $crewpak_cnt;

			$x++;
		}

		$content['product'] = $product_content;
		$content['crewpak'] = $crewpak_content;


		return $content;
	}
}
