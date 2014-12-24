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

	public function actionList($status='', $detail = true)
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
			'detail' => $detail,
		]);

	}

	public function actionDownload($id)
	{
		$model = $this->findModel($id);
		header("Content-type: text/html; charset=utf-8");
		header("Content-Disposition: attachment;Filename=XDC".date_format(date_create($model->date), 'md')."-".$model->id.'.doc');

		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";

		echo '<p style="text-align: center;"><span style="color: #808080; line-height:3pt;">'.chineseToUnicode('廈門卡樂兒商貿公司').'<br>';
		echo 'XIAMEN COLOR TRADE LIMITED<br>';
		echo chineseToUnicode('包裝打捆紀錄單').'<br><span style="font-size: small;">'.chineseToUnicode('日期').':'.$model->date.'</span></span></p>';
		echo '<p style="text-align: left;">'.chineseToUnicode('取货地点：厦门市火炬东路28号').'<br>';
		echo chineseToUnicode('送货单位：■顺丰标快 □顺丰特惠 □顺丰物流普运').'</p>';

		echo '<style type="text/css">';
		echo '.tg  {border-collapse:collapse;border-spacing:0;}';
		echo '.tg td{font-family:Arial, sans-serif;font-size:14px;padding:3px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}';
		echo '.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:0px 0px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}';
		echo '.tg .tg-s6z2{text-align:center; padding:0px 0px;}';
		echo '</style>';

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 560px">';
		echo '<colgroup>';
		echo '<col style="width: 100px">';
		echo '<col style="width: 140px">';
		echo '<col style="width: 100px">';
		echo '</colgroup>';
		echo '<tr>';
		echo '<th class="tg-s6z2">'.chineseToUnicode('会员编号').'<br>DC#</th>';
		echo '<th class="tg-031e">'.$model->customer_id.'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('订单号码').'<br>PO#</th>';
		echo '<th class="tg-031e">'.$model->id.'</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="tg-s6z2">'.chineseToUnicode('会员地址').'<br>ADDRESS</td>';
		echo '<td class="tg-031e" colspan="3"><span style="background-color: #d0d0d0;">'.chineseToUnicode('地址(英)').':</span><br>'.chineseToUnicode($model->english_addr).
						'<br><span style="background-color: #d0d0d0;">'.chineseToUnicode('地址(中)').':</span><br>'.chineseToUnicode($model->chinese_addr).
						'<br><span style="background-color: #d0d0d0;">'.chineseToUnicode('收件人').':</span><br>'.chineseToUnicode($model->contact).
						'<br><span style="background-color: #d0d0d0;">'.chineseToUnicode('连络电话').':</span><br>'.chineseToUnicode($model->tel).
						'</td>';
		echo '</tr>';
		echo '</table>';

		order_content_to_download_table($model->content);

		echo '</table>';

		echo '<p>'.chineseToUnicode('执行者签名：').'</p>';
		echo '<p>'.chineseToUnicode('复核： □已确认产品数量皆正确').'</p>';
		echo '<p>'.chineseToUnicode('总箱数：').'</p>';
		echo '<p>'.chineseToUnicode('总重：').'</p>';
		echo '<p>'.chineseToUnicode('运单号码：').'</p>';
		echo '<p>'.chineseToUnicode('备注：').'</p>';
		echo "</body>";
		echo "</html>";

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
