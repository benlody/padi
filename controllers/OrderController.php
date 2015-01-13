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
use app\models\Shipping;
use app\models\Transfer;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use Yii;

require_once __DIR__  . '/../utils/utils.php';
require_once __DIR__  . '/../utils/enum.php';
require_once __DIR__  . '/../utils/ship_download.php';
require '../../mail/PHPMailer/PHPMailerAutoload.php';

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
			$post_param['Order']['date'] = date("Y-m-d", strtotime($post_param['Order']['date']));

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

	public function actionModify($id)
	{

		$model = $this->findModel($id);
		$customer = new Customer();
		$crewpak = new CrewPak();
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){

			$post_param['Order']['content'] = json_encode($this->get_content($post_param), JSON_FORCE_OBJECT);
			$post_param['Order']['date'] = date("Y-m-d", strtotime($post_param['Order']['date']));

			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = Order::STATUS_NEW;

			//FIXME error handle
			$model->update();

			return $this->redirect(['list']);

		} else {
			return $this->render('modify', [
				'model' => $model,
				'customer' => $customer->find()->column(),
				'crewpak' =>  $crewpak->find()->column(),
				'product' =>  $product->find()->column()
			]);
		}
	}

	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['list']);
	}

	public function actionList($status='', $detail = true, $sort='-date')
	{

		$searchModel = new OrderSearch();
		if(0 == strcmp($status, 'done')){
			$search_param['OrderSearch'] = array('status' => Order::STATUS_DONE);
			if(0 == strcmp($sort, '-date')){
				$sort = '-done_date';
			}
			$dataProvider = $searchModel->search($search_param);
		} else {

			if(0 == strcmp($sort, '-done_date')){
				$sort = '-date';
			}

			$query = Order::find();
			$query->Where('status != '.Order::STATUS_DONE);

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);


		}

		return $this->render('list', [
			'dataProvider' => $dataProvider,
			'status' => $status,
			'detail' => $detail,
			'sort' => $sort,
		]);

	}

	public function actionReview($id)
	{

		$post_param = Yii::$app->request->post();
		$model = $this->findModel($id);

		if(isset($post_param['review'])){

			$model->status = Order::STATUS_PROCESSING;
			$model->update();
			return $this->redirect(['list']);

		} else {

			return $this->render('review', [
				'model' => $model,
			]);
		}

	}

	public function actionView($id)
	{

		$model = $this->findModel($id);

		return $this->render('view', [
			'model' => $model,
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

		if(0 == strcmp('xm', $model->warehouse)){
			$this->download_xm($model);
		} else {
			$this->download_tw($model);
		}

		echo "</body>";
		echo "</html>";

	}

	public function actionEdit($id)
	{

		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();
		$old_content = json_decode($model->content);
		$content = $old_content;
		$now = strtotime('now');
		$query = new Query;

		if(isset($post_param['done'])){

			$old_ship_array = json_decode($model->shipping_info);
			$new_ship_array = $this->get_ship($post_param, $now);

			$warehouse = $post_param['Order']['warehouse'];
			$padi_balance_model = new Balance1($warehouse, 'padi');
			$padi_transaction_model = new Transaction1($warehouse, 'padi');
			get_balance($padi_balance_model, $warehouse, 'padi');

			if(isset($post_param['product'])){
				foreach ($post_param['product'] as $product => $done) {
					$content->product->$product->done = true;
					$padi_transaction_model->$product -= $content->product->$product->cnt;
					$padi_balance_model->$product -= $content->product->$product->cnt;

					$warning_cnt = $query->select('*')
										->from('product')
										->where('id = "'.$product.'"')
										->one();
					$warning_cnt_wh = 'warning_cnt_'.$warehouse;
					if($warning_cnt[$warning_cnt_wh] > 0 && $warning_cnt[$warning_cnt_wh] > $padi_balance_model->$product){
						$warning[$product]['warning_cnt'] = $warning_cnt[$warning_cnt_wh];
						$warning[$product]['balance'] = $padi_balance_model->$product;
					}
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

						$warning_cnt = $query->select('*')
											->from('product')
											->where('id = "'.$product.'"')
											->one();
						$warning_cnt_wh = 'warning_cnt_'.$warehouse;
						if($warning_cnt[$warning_cnt_wh] > 0 && $warning_cnt[$warning_cnt_wh] > $padi_balance_model->$product){
							$warning[$product]['warning_cnt'] = $warning_cnt[$warning_cnt_wh];
							$warning[$product]['balance'] = $padi_balance_model->$product;
						}
					}
				}
			}

			$post_param['Order']['content'] = json_encode($content);
			$post_param['Order']['done_date'] = date("Y-m-d", strtotime($post_param['Order']['done_date']));
			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			if($old_ship_array){
				$model->shipping_info = json_encode(array_merge($old_ship_array, $new_ship_array));
			} else {
				$model->shipping_info = json_encode($new_ship_array);
			}
			$model->status = Order::STATUS_DONE;

			foreach ($content->product as $product => $value) {
				if($value->done == false){
					$model->status = Order::STATUS_PROCESSING;
					break;
				}
			}

			foreach ($content->crewpak as $crewpak => $value) {
				if($value->done == false){
					$model->status = Order::STATUS_PROCESSING;
					break;
				}
			}

			$padi_transaction_model->serial = 'order_'.$post_param['Order']['id'].'_'.$now;
			$padi_transaction_model->date = $post_param['Order']['done_date'];
			$padi_balance_model->serial = 'order_'.$post_param['Order']['id'].'_'.$now;
			$padi_balance_model->date = $post_param['Order']['done_date'];

			$model->update();
			$padi_transaction_model->insert();
			$padi_balance_model->insert();

			foreach ($new_ship_array as $ship_info) {
				$ship = new Shipping;
				$ship->id = $ship_info['id'];
				$ship->order_id = $model->id;
				$ship->content = json_encode($ship_info);
				$ship->send_date = $post_param['Order']['done_date'];
				$ship->ship_type = $model->ship_type;
				$ship->warehouse = $model->warehouse;
				$ship->shipping_fee = $ship_info['fee'];
				$ship->extra_info = $model->extra_info;
				$ship->insert();
			}

			if(isset($warning)){
				$body = $this->renderPartial('warning', [
							'warning' => $warning,
							'warehouse' => $warehouse,
							'order_id' => $post_param['Order']['id'],
						]);
				$subject = YII_ENV_DEV ? 'Inventory Warning (Test) - '.$post_param['Order']['done_date'] : 'Inventory Warning - '.$post_param['Order']['done_date'];
				$this->sendMail($body, $subject);
			}

			$body = $this->renderPartial('order_out', [
						'ship_array' => $new_ship_array,
						'content' => $content,
						'order_id' => $post_param['Order']['id'],
						'warehouse' => $warehouse,
						'region' => $post_param['Order']['region'],
						]);
			$subject = YII_ENV_DEV ? 'Freight Info (Test) - '.$post_param['Order']['id'] : 'Freight Info - '.$post_param['Order']['id'];
			$this->sendMail($body, $subject, true);

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

	public function actionEdit_only($id)
	{

		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();

		if(isset($post_param['save'])){
			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			$model->update();

			if($model->status == Order::STATUS_DONE){
				return $this->redirect(['list', 'status' => 'done']);
			} else {
				return $this->redirect(['list']);
			}

		} else {

			return $this->render('edit_only', [
				'model' => $model,
			]);
		}
	}


	public function actionSummary()
	{

		$xm_provider = $this->get_summary_provider('xm');
		$tw_provider = $this->get_summary_provider('tw');

		return $this->render('summary', [
			'tw_provider' => $tw_provider,
			'xm_provider' => $xm_provider,
		]);
	}


	public function actionShip_overview($warehouse='xm', $from='', $to='')
	{
		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$orders = $query->select('*')
						->from('order')
						->where('warehouse = "'.$warehouse.'" AND status = 1 AND done_date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		return $this->render('ship_overview' ,[
			'warehouse' => $warehouse,
			'from' => $from,
			'to' => $to,
			'orders' => $orders,
		]);
	}

	public function actionShip_download($warehouse='xm', $from='', $to='')
	{
		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$orders = $query->select('*')
						->from('order')
						->where('warehouse = "'.$warehouse.'" AND done_date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		ship_download($orders, $warehouse, $from, $to);
	}

	public function actionGet()
	{
		return $this->render('get');
	}

	public function actionIndex()
	{
		return $this->render('index');
	}


	protected function sendMail($body, $subject, $external = false){
		$mail = new \PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'notify@lang-win.com.tw';
		$mail->Password = '23314526';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->setFrom('notify@lang-win.com.tw', 'Notification');
		$mail->addAddress('jack@lang-win.com.tw');
		$mail->addAddress('pc-mippi@lang-win.com.tw');
		$mail->addAddress('yiyin.chen@lang-win.com.tw');
		$mail->addAddress('susan@lang-win.com.tw');
		$mail->addAddress('langchen@lang-win.com.tw');
		if(!YII_ENV_DEV && $external){
			$mail->addAddress('Azure.Ruan@padi.com.au');
			$mail->addAddress('Kitty.Hu@padi.com.au');
		}
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->send();
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
		$estimate = 0;
		$save = true;

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
			$weight = get_weight($product_id);
			if(0 == $weight){
				$save = false;
			} else {
				$estimate += $product_cnt * $weight;
			}

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
				$weight = get_weight($p_name);
				if(0 == $weight){
					$save = false;
				} else {
					$estimate += $detail[$p_name]['cnt'] * $weight;
				}

			}
			$crewpak_content[$crewpak_id]['detail'] = $detail;
			$crewpak_content[$crewpak_id]['done'] = false;

			$x++;
		}

		$content['product'] = $product_content;
		$content['crewpak'] = $crewpak_content;
		if($save){
			$content['estimate'] = ($estimate/1000).' kg';
		}

		return $content;
	}

	protected function get_ship($post_param, $now){

		$ship_array = array();

		$x = 0;
		while(1){

			$ship_idx = "shipping_".$x;
			$packing_cnt_idx = "packing_cnt_".$x;
			$packing_type_idx = "packing_type_".$x;
			$weight_idx = "weight_".$x;
			$fee_idx = "shipping_fee_".$x;

			if(!isset($post_param[$ship_idx])){
				break;
			}

			if(0 == strcmp($post_param[$ship_idx], "")){
				$x++;
				continue;
			}

			$ship = $post_param[$ship_idx];
			$packing_cnt = $post_param[$packing_cnt_idx];
			$packing_type = $post_param[$packing_type_idx];
			$weight = $post_param[$weight_idx];
			$fee = $post_param[$fee_idx];

			$ship_content = array();
			$ship_content['id'] = $ship.'_'.$now;
			$ship_content[$packing_type] = $packing_cnt;
			$ship_content['weight'] = $weight;
			$ship_content['fee'] = $fee;
			$ship_content['type'] = $post_param['Order']['ship_type'];

			if(0 == $x){
				$ship_content['content']['crewpak'] = $post_param['crewpak'];
				$ship_content['content']['product'] = $post_param['product'];
			} else {
				$ship_content['content']['crewpak'] = array();
				$ship_content['content']['product'] = array();
			}

			array_push($ship_array, $ship_content);

			$x++;
		}

		return $ship_array;
	}

	protected function get_summary_provider($wh){

		$order_query = new Query;
		$transfer_query = new Query;
		$balance_query = new Query;
		$summary = array();

		$orders = $order_query->select('content')
							->from('order')
							->where('warehouse = "'.$wh.'" AND status != '.Order::STATUS_DONE)
							->all();

		foreach ($orders as $order) {

			$content = json_decode($order['content'], true);

			foreach ($content['product'] as $p => $detail) {
				if($detail['done']){
					continue;
				}
				$summary[$p]['work_cnt'] += $detail['cnt'];
			}

			foreach ($content['crewpak'] as $c => $detail) {
				if($detail['done']){
					continue;
				}
				foreach ($detail['detail'] as $p => $p_detail) {
					if($p_detail['done']){
						continue;
					}
					$summary[$p]['work_cnt'] += $p_detail['cnt'];
				}
			}
		}

		$transfers = $transfer_query->select('content')
							->from('transfer')
							->where('src_warehouse LIKE "'.$wh.'%" AND status = '.Transfer::STATUS_NEW)
							->all();

		foreach ($transfers as $transfer) {

			$content = json_decode($transfer['content'], true);
			foreach ($content as $p => $cnt) {
				$summary[$p]['work_cnt'] += $cnt;
			}
		}


		foreach ($summary as $p => $cnt) {
			$balance = $balance_query->select($p)
								->from($wh.'_padi_balance')
								->orderBy('ts DESC')
								->one();
			$summary[$p]['balance'] = $balance[$p];
			$summary[$p]['id'] = $p;
		}

		$provider = new ArrayDataProvider([
				'allModels' => $summary,
				'sort' => [
					'attributes' => ['id'],
				],
				'pagination' => [
					'pageSize' => 50,
				],
		]);
		return $provider;

	}

	protected function download_xm($model){

		echo '<p style="text-align: center;"><span style="color: #808080; line-height:3pt;">'.chineseToUnicode('廈門卡樂兒商貿公司').'<br>';
		echo 'XIAMEN COLOR TRADE LIMITED<br>';
		echo chineseToUnicode('包裝打捆紀錄單').'<br><span style="font-size: small;">'.chineseToUnicode('日期').':'.$model->date.'</span></span></p>';
		echo '<p style="text-align: left;">'.chineseToUnicode('取货地点：厦门市火炬东路28号').'<br>';
		if($model->ship_type == \ShippingType::T_STD_EXPR){
			echo chineseToUnicode('送货单位：■顺丰标快 □顺丰特惠 □顺丰物流普运').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SF_SP){
			echo chineseToUnicode('送货单位：□顺丰标快 ■顺丰特惠 □顺丰物流普运').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SF_NORMAL){
			echo chineseToUnicode('送货单位：□顺丰标快 □顺丰特惠 ■顺丰物流普运').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SELFPICK){
			echo chineseToUnicode('送货单位：□顺丰标快 □顺丰特惠 □顺丰物流普运 ■客戶自取').'</p>';
		} else {
			echo chineseToUnicode('送货单位：□顺丰标快 □顺丰特惠 □顺丰物流普运').'</p>';
		}

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

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 560px">';
		echo '<colgroup>';
		echo '<col style="width: 100px">';
		echo '<col style="width: 400px">';
		echo '<col style="width: 60px">';
		echo '</colgroup>';
		echo '<tr>';
		echo '<th class="tg-s6z2">'.chineseToUnicode('产品编号').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('产品名称').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('数量').'</th>';
		echo '</tr>';
		
		order_content_to_download_table($model->content);

		echo '</table>';

		echo '<p>'.chineseToUnicode('执行者签名：').'</p>';
		echo '<p>'.chineseToUnicode('复核： □已确认产品数量皆正确').'</p>';
		echo '<p>'.chineseToUnicode('总箱数：').'</p>';
		$content = json_decode($model->content, true);
		if(isset($content['estimate'])){
			echo '<p>'.chineseToUnicode('預估重量： '.$content['estimate']).'</p>';
		}
		echo '<p>'.chineseToUnicode('总重：').'</p>';
		echo '<p>'.chineseToUnicode('运单号码：').'</p>';
		echo '<p>'.chineseToUnicode('备注：').'</p>';
	}

	protected function download_tw($model){

		echo '<p style="text-align: center;"><span style="color: #808080; line-height:3pt;">'.chineseToUnicode('光隆印刷廠股份有限公司').'<br>';
		echo 'Kuang Lung Printing Factory Co., Ltd.<br>';
		echo chineseToUnicode('包裝打捆紀錄單').'<br><span style="font-size: small;">'.chineseToUnicode('日期').':'.$model->date.'</span></span></p>';
		echo '<p style="text-align: left;">'.chineseToUnicode('公司地址：台北市漢口街一段61號2F TEL:02-23314526 FAX:02-23832251').'<br>';
		if($model->ship_type == \ShippingType::T_CHI_MAIL){
			echo chineseToUnicode('送貨單位：■中華郵政 □順丰快遞 □新航快遞').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SF){
			echo chineseToUnicode('送貨單位：□中華郵政 ■順丰快遞 □新航快遞').'</p>';
		} else if ($model->ship_type == \ShippingType::T_NEW){
			echo chineseToUnicode('送貨單位：□中華郵政 □順丰快遞 ■新航快遞').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SELFPICK){
			echo chineseToUnicode('送貨單位：□中華郵政 □順丰快遞 □新航快遞 ■客戶自取').'</p>';
		} else {
			echo chineseToUnicode('送貨單位：□中華郵政 □順丰快遞 □新航快遞').'</p>';
		}

		echo '<style type="text/css">';
		echo '.tg  {border-collapse:collapse;border-spacing:0;}';
		echo '.tg td{font-family:Arial, sans-serif;font-size:17px;padding:3px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}';
		echo '.tg th{font-family:Arial, sans-serif;font-size:17px;font-weight:normal;padding:0px 0px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}';
		echo '.tg .tg-s6z2{text-align:center; padding:0px 0px;}';
		echo '</style>';

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 560px">';
		echo '<colgroup>';
		echo '<col style="width: 100px">';
		echo '<col style="width: 140px">';
		echo '<col style="width: 100px">';
		echo '</colgroup>';
		echo '<tr>';
		echo '<th class="tg-s6z2">'.chineseToUnicode('會員編號').'<br>DC#</th>';
		echo '<th class="tg-031e">'.$model->customer_id.'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('訂單號碼').'<br>PO#</th>';
		echo '<th class="tg-031e">'.$model->id.'</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="tg-s6z2">'.chineseToUnicode('會員地址').'<br>ADDRESS</td>';
		echo '<td class="tg-031e" colspan="3"><span">'.chineseToUnicode('地址(英)').':</span><br>'.chineseToUnicode($model->english_addr).
						'<br><span">'.chineseToUnicode('地址(中)').':</span><br>'.chineseToUnicode($model->chinese_addr).
						'<br><span">'.chineseToUnicode('收件人').':</span><br>'.chineseToUnicode($model->contact).
						'<br><span">'.chineseToUnicode('聯絡电话').':</span><br>'.chineseToUnicode($model->tel).
						'</td>';
		echo '</tr>';
		echo '</table>';

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 560px">';
		echo '<colgroup>';
		echo '<col style="width: 100px">';
		echo '<col style="width: 400px">';
		echo '<col style="width: 60px">';
		echo '</colgroup>';
		echo '<tr>';
		echo '<th class="tg-s6z2">'.chineseToUnicode('產品編號').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('產品名稱').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('數量').'</th>';
		echo '</tr>';

		order_content_to_download_table($model->content);

		echo '</table>';

		echo '<p>'.chineseToUnicode('執行者簽名：').'</p>';
		echo '<p>'.chineseToUnicode('覆核： □已確認語文版本皆正確 □已確認產品數量皆正確    簽名:').'</p>';
		$content = json_decode($model->content, true);
		if(isset($content['estimate'])){
			echo '<p>'.chineseToUnicode('預估重量： '.$content['estimate']).'</p>';
		}
	}
}
