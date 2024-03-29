<?php

namespace app\controllers;

use app\models\User;
use app\models\Log;
use app\models\Order;
use app\models\OrderSearch;
use app\models\CrewPak;
use app\models\Product;
use app\models\Customer;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use app\models\Transfer;
use app\models\Notify;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use Yii;
use yii\web\NotFoundHttpException;

require_once __DIR__  . '/../utils/utils.php';
require_once __DIR__  . '/../utils/enum.php';
require_once __DIR__  . '/../utils/ship_download.php';
require '../../mail/PHPMailer/PHPMailerAutoload.php';

class OrderController extends \yii\web\Controller
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
		
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$model = new Order;
		$customer = new Customer();
		$crewpak = new CrewPak();
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){

			$content = $this->get_content($post_param);
			$post_param['Order']['content'] = json_encode($content, JSON_FORCE_OBJECT);
			$post_param['Order']['date'] = date("Y-m-d", strtotime($post_param['Order']['date']));

			//get ship type by estimate weight (XM)
			if(isset($content['estimate_w']) && (0 == strcmp($post_param['Order']['warehouse'], 'xm')) && \ShippingType::T_DPN != $post_param['Order']['ship_type']){
				$post_param['Order']['ship_type'] = get_ship_type_xm($post_param['Order']['region'], $content['estimate_w']);
			}


			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = Order::STATUS_NEW;
			$model->ctime = date("Y-m-d H:i:s", strtotime('now'));

			//FIXME error handle
			$model->insert();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Add order ['.$model->id.']';
			$log->insert();

			return $this->redirect(['list', 'sort' => '-date']);

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

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

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
			$model->ctime = date("Y-m-d H:i:s", strtotime('now'));


			//FIXME error handle
			$model->update();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Modify order ['.$model->id.']';
			$log->insert();

			return $this->redirect(['list', 'sort' => '-date']);

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
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$this->findModel($id)->delete();

		$log = new Log();
		$log->username = Yii::$app->user->identity->username;
		$log->action = 'Delete order ['.$id.']';
		$log->insert();

		return $this->redirect(['list', 'sort' => '-date']);
	}

	public function actionForce($id)
	{
		if(Yii::$app->user->identity->group > User::GROUP_MGR){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$model = $this->findModel($id);

		$model->status = Order::STATUS_DONE;
		$model->update();

		$log = new Log();
		$log->username = Yii::$app->user->identity->username;
		$log->action = 'Force Done order ['.$model->id.']';
		$log->insert();

		return $this->redirect(['list', 'sort' => '-date']);
	}


	public function actionList($status='', $detail = true, $sort='-date')
	{

//		if(Yii::$app->user->identity->group > User::GROUP_KL){
//			throw new NotFoundHttpException('The requested page does not exist.');
//		}


		$searchModel = new OrderSearch();
		if(0 == strcmp($status, 'done')){
			$search_param['OrderSearch'] = array('status' => Order::STATUS_DONE);
			if(Yii::$app->user->identity->group == User::GROUP_XM){
				$search_param['OrderSearch']['warehouse'] = 'xm';
			}
			$dataProvider = $searchModel->search($search_param);
		} else {
			$query = Order::find();
			$query->Where('status != '.Order::STATUS_DONE);
			if(Yii::$app->user->identity->group == User::GROUP_XM){
				$query->andWhere('warehouse = "xm"');
			}
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

	public function actionSearch(){

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$post_param = Yii::$app->request->post();
		$searchModel = new OrderSearch();

		if(isset($post_param['search'])){

			$dataProvider = $searchModel->mysearch($post_param['OrderSearch']);

			return $this->render('search', [
				'search_param' => $post_param['OrderSearch'],
				'dataProvider' => $dataProvider,
			]);

		}

		return $this->render('search');
	}


	public function actionReview($id)
	{

		if(Yii::$app->user->identity->group > User::GROUP_MGR){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$post_param = Yii::$app->request->post();
		$model = $this->findModel($id);

		if(isset($post_param['review'])){

			$model->status = Order::STATUS_PROCESSING;
			$model->update();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Review order ['.$model->id.']';
			$log->insert();

			return $this->redirect(['list', 'sort' => '-date']);

		} else {

			return $this->render('review', [
				'model' => $model,
			]);
		}

	}

	public function actionView($id)
	{

//		if(Yii::$app->user->identity->group > User::GROUP_KL){
//			throw new NotFoundHttpException('The requested page does not exist.');
//		}

		$model = $this->findModel($id);

		return $this->render('view', [
			'model' => $model,
		]);
	}

	public function actionDownload($id)
	{
//		if(Yii::$app->user->identity->group > User::GROUP_KL){
//			throw new NotFoundHttpException('The requested page does not exist.');
//		}

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
//		if(Yii::$app->user->identity->group > User::GROUP_KL){
//			throw new NotFoundHttpException('The requested page does not exist.');
//		}

		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();
		$content = json_decode($model->content);
		$old_content = json_decode($model->content, true);
		$now = strtotime('now');
		$query = new Query;

		if(isset($post_param['done'])){
			$warehouse = $post_param['Order']['warehouse'];
			$warning_cnt_wh = 'warning_cnt_'.$warehouse;

			$warning_cntxxx = $query->select('id,'.$warning_cnt_wh)
					->from('product')
					->all();
			$warning_cnt_array = array();
			foreach ($warning_cntxxx as $value) {
				$warning_cnt_array[$value['id']] = $value[$warning_cnt_wh];
			}

			$padi_balance_model = new Balance1($warehouse, 'padi');
			$padi_transaction_model = new Transaction1($warehouse, 'padi');
			get_balance($padi_balance_model, $warehouse, 'padi');

			if(isset($post_param['product'])){
				foreach ($post_param['product'] as $product => $done) {
					$old_cnt = $old_content['product'][$product]['done'];
					$content->product->$product->done = true;
					$padi_transaction_model->$product -= ($content->product->$product->cnt - $old_cnt);
					$padi_balance_model->$product -= ($content->product->$product->cnt - $old_cnt);

					if($warning_cnt_array[$product] > 0 && $warning_cnt_array[$product] > $padi_balance_model->$product){
						$warning[$product]['warning_cnt'] = $warning_cnt_array[$product];
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
						$old_cnt = $old_content['crewpak'][$crewpak]['detail'][$product]['done'];
						$content->crewpak->$crewpak->detail->$product->done = true;
						$padi_transaction_model->$product -= ($content->crewpak->$crewpak->detail->$product->cnt - $old_cnt);
						$padi_balance_model->$product -= ($content->crewpak->$crewpak->detail->$product->cnt - $old_cnt);
						$complement_cnt[$product] += ($content->crewpak->$crewpak->detail->$product->cnt - $old_cnt);

						if($warning_cnt_array[$product] > 0 && $warning_cnt_array[$product] > $padi_balance_model->$product){
							$warning[$product]['warning_cnt'] = $warning_cnt_array[$product];
							$warning[$product]['balance'] = $padi_balance_model->$product;
						}
					}
				}
			}

			if(isset($post_param['cnt_product'])){
				foreach ($post_param['cnt_product'] as $product => $cnt) {
					$old_cnt = $old_content['product'][$product]['done'];
					if(0 == $cnt || $post_param['product'][$product]){
						continue;
					}
					if($old_cnt >= $cnt){
						continue;
					}
					$content->product->$product->done = $cnt;
					$padi_transaction_model->$product -= ($cnt - $old_cnt);
					$padi_balance_model->$product -= ($cnt - $old_cnt);

					if($warning_cnt_array[$product] > 0 && $warning_cnt_array[$product] > $padi_balance_model->$product){
						$warning[$product]['warning_cnt'] = $warning_cnt_array[$product];
						$warning[$product]['balance'] = $padi_balance_model->$product;
					}
				}
			}

			if(isset($post_param['cnt_detail'])){
				foreach ($post_param['cnt_detail'] as $crewpak => $detail) {
					if($post_param['crewpak'][$crewpak]){
						continue;
					}

					foreach ($detail as $product => $cnt) {
						$old_cnt = $old_content['crewpak'][$crewpak]['detail'][$product]['done'];
						if(0 == $cnt || $post_param['detail'][$crewpak][$product]){
							continue;
						}
						if($old_cnt >= $cnt){
							continue;
						}
						$content->crewpak->$crewpak->detail->$product->done = $cnt;
						$padi_transaction_model->$product -= ($cnt - $old_cnt);
						$padi_balance_model->$product -= ($cnt - $old_cnt);
						$complement_cnt[$product] += ($cnt - $old_cnt);

						if($warning_cnt_array[$product] > 0 && $warning_cnt_array[$product] > $padi_balance_model->$product){
							$warning[$product]['warning_cnt'] = $warning_cnt_array[$product];
							$warning[$product]['balance'] = $padi_balance_model->$product;
						}
					}
				}
			}

			$old_ship_array = json_decode($model->shipping_info);
			$new_ship_array = $this->get_ship($post_param, $now, $complement_cnt, (null != $model->done_date));

			$post_param['Order']['content'] = json_encode($content);
			$post_param['Order']['done_date'] = date("Y-m-d", strtotime($post_param['Order']['done_date']));
			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}

			if($old_ship_array){
				$model->shipping_info = json_encode(array_merge($old_ship_array, $new_ship_array));
			} else {
				$model->dtime = date("Y-m-d H:i:s", strtotime('now'));
				$model->shipping_info = json_encode($new_ship_array);
			}
			$model->status = Order::STATUS_DONE;

			foreach ($content->product as $product => $value) {
				if($value->done !== true){
					$model->status = Order::STATUS_PROCESSING;
					break;
				}
			}

			foreach ($content->crewpak as $crewpak => $value) {
				if($value->done !== true){
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

			if(isset($warning)){
				$body = $this->renderPartial('warning', [
							'warning' => $warning,
							'warehouse' => $warehouse,
							'order_id' => $post_param['Order']['id'],
						]);
				$subject = YII_ENV_DEV ? 'Inventory Warning (Test) - '.$post_param['Order']['done_date'] : 'Inventory Warning - '.$post_param['Order']['done_date'];
				$this->sendMail($body, $subject, $warehouse);
			}

			$body = $this->renderPartial('order_out', [
						'ship_array' => $new_ship_array,
						'content' => $content,
						'order_id' => $post_param['Order']['id'],
						'warehouse' => $warehouse,
						'customer_id' => $post_param['Order']['customer_id'],
						'customer_name' => $post_param['Order']['customer_name'],
						'ship_type' => \ShippingType::getShippingType($post_param['Order']['ship_type'], 'enu'),
						'region' => $post_param['Order']['region'],
						]);
			$subject = YII_ENV_DEV ? 'Freight Info (Test) - '.$post_param['Order']['id'] : 'Freight Info - '.$post_param['Order']['id'];
			$this->sendMail($body, $subject, $warehouse, $post_param['send_padi'], $post_param['send_justin_smile'], $post_param['send_gina'], $post_param['send_kim'], $post_param['send_young']);

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Delivery order ['.$model->id.']';
			$log->insert();

			return $this->redirect(['list', 'sort' => '-date']);

		} else {

			// FIXME avoid edit a done order

			return $this->render('edit', [
				'model' => $model,
			]);
		}
	}

	public function actionEdit_only($id)
	{

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();

		if(isset($post_param['save'])){
			foreach ($post_param['Order'] as $key => $value) {
				$model->$key = $value;
			}
			$model->update();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Edit order ['.$model->id.']';
			$log->insert();

			if($model->status == Order::STATUS_DONE){
				return $this->redirect(['list', 'status' => 'done', 'sort' => '-done_date']);
			} else {
				return $this->redirect(['list', 'sort' => '-date']);
			}

		} else {

			return $this->render('edit_only', [
				'model' => $model,
			]);
		}
	}

	public function actionInvoice()
	{
		
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$customer = new Customer();
		$crewpak = new CrewPak();
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if(isset($post_param['invoice'])){

			$inv_content = $this->get_inv_content($post_param);
			print_r($inv_content);

			if( (0 == strcmp($post_param['Order']['region'], 'Korea')) || 
				(0 == strcmp($post_param['Order']['region'], 'Philippines')) ||
				(0 == strcmp($post_param['Order']['region'], 'Malaysia'))
				){
				invoice_download_korea($post_param['Order'], $inv_content);
			} else {
				invoice_download($post_param['Order'], $inv_content);
			}

		} else {
			return $this->render('invoice', [
				'customer' => $customer->find()->column(),
				'crewpak' =>  $crewpak->find()->column(),
				'product' =>  $product->find()->column()
			]);
		}
	}

	public function actionShip_overview($warehouse='xm', $from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$post_param = Yii::$app->request->post();

		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		if($post_param['chose_from']){
			$from = $post_param['chose_from'];
		}
		if($post_param['chose_to']){
			$to = $post_param['chose_to'];
		}

		$orders = $query->select('*')
						->from('order')
						->where('warehouse = "'.$warehouse.'" AND status != 0 AND done_date IS NOT NULL AND (done_date BETWEEN  "'.$from.'" AND "'.$to.'" OR date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		return $this->render('ship_overview' ,[
			'warehouse' => $warehouse,
			'from' => $from,
			'to' => $to,
			'orders' => $orders,
		]);
	}

	public function actionStatistics($from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$orders = $query->select('*')
						->from('order')
						->where('date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		return $this->render('statistics' ,[
			'warehouse' => $warehouse,
			'from' => $from,
			'to' => $to,
			'orders' => $orders,
		]);
	}


	public function actionShip_download($warehouse='xm', $from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$query = new Query;
		$query2 = new Query;

		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$orders = $query->select('*')
						->from('order')
						->where('warehouse = "'.$warehouse.'" AND status != 0 AND done_date IS NOT NULL AND (done_date BETWEEN  "'.$from.'" AND "'.$to.'" OR date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		if($warehouse == 'tw'){
			$certcards = $query2->select('*')
								->from('certcard')
								->where(' t_send_date BETWEEN  "'.$from.'" AND "'.$to.'"')
								->orderBy('id ASC')
								->all();

			$query3 = new Query;
			$transfer_sf_send = $query3->select('id, send_date, dst_warehouse, content, shipping_info')
							->from('transfer')
							->where('src_warehouse = "tw_padi" AND ship_type = "sf" AND (send_date BETWEEN  "'.$from.'" AND "'.$to.'")')
							->orderBy('id ASC')
							->all();

		}

		ship_download($orders, $warehouse, $from, $to, $certcards, $transfer_sf_send);
	}


	public function actionStat_download($from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$orders = $query->select('*')
						->from('order')
						->where('date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		stat_download($orders, $from, $to);
	}

	public function actionShip_download_service($warehouse='xm', $from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$orders = $query->select('*')
						->from('order')
						->where('warehouse = "'.$warehouse.'" AND date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		ship_download_service($orders, $warehouse, $from, $to);
	}

	public function actionMatch($warehouse='tw', $from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$query = new Query;
		$orders = $query->select('id, chinese_addr, contact, ship_type, done_date, shipping_info')
						->from('order')
						->where('warehouse = "tw" AND done_date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$cert_cards = $query->select('t_send_date, tracking, orig_fee')
						->from('certcard')
						->where('t_send_date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$transfers_sfs = $query->select('id, send_date, status, ship_type, shipping_info')
						->from('transfer')
						->where('status != 0 AND ship_type = "sf" AND src_warehouse like "tw%" AND dst_warehouse like "xm%" AND send_date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		$hiyes = array();
		$sf = array();
		$globlas = array();
		$post = array();
		$other = array();

		foreach ($orders as $order) {
			$ship_info = json_decode($order['shipping_info'], true);
			foreach ($ship_info as $info) {
				$shipment['date'] = $info['date'];
				$shipment['tracking'] = '#'.substr($info['id'], 0, strpos($info['id'], '_'));
				$shipment['fee'] = $info['fee'];
				$shipment['addr'] = $order['chinese_addr'];
				$shipment['type'] = $info['type'];
				$shipment['type_chi'] = \ShippingType::getTWType()[$info['type']];
				if($shipment['type'] == 12){
					array_push($hiyes, $shipment);
				} else if ($shipment['type'] == 11){
					array_push($sf, $shipment);
				} else if ($shipment['type'] == 10){
					array_push($post, $shipment);
				} else if ($shipment['type'] == 18){
					array_push($globlas, $shipment);
				} else {
					array_push($other, $shipment);
				}
			}
		}

		foreach ($cert_cards as $cert_card) {
			$shipment['date'] = $cert_card['t_send_date'];
			$shipment['tracking'] = '#'.preg_replace('/\s(?=)|-/', '', $cert_card['tracking']);
			$shipment['fee'] = $cert_card['orig_fee'];
			$shipment['addr'] = '北京';
			$shipment['type'] = 11;
			$shipment['type_chi'] = \ShippingType::getTWType()[11];
			array_push($sf, $shipment);
		}		

		foreach ($transfers_sfs as $transfers_sf) {
			$ship_info = json_decode($transfers_sf['shipping_info'], true);
			if(is_array($ship_info)){
				foreach ($ship_info as $info) {
					$shipment['date'] = $transfers_sf['send_date'];
					$shipment['tracking'] = '#'.$info['id'];
					$shipment['fee'] = $info['fee'];
					$shipment['addr'] = '廈門';
					$shipment['type'] = 11;
					$shipment['type_chi'] = \ShippingType::getTWType()[11];
					array_push($sf, $shipment);
				}
			}
		}


		match_download($hiyes, $sf, $globlas, $post, $other, $to, $from);
	}

	public function actionDownload_customs($from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$query = new Query;
		$orders_export = $query->select('id, done_date, customer_id, customer_name, shipping_info')
						->from('order')
						->where('warehouse = "tw" AND ship_type = 24 AND (done_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$orders_dhl = $query->select('id, done_date, customer_id, customer_name, shipping_info')
						->from('order')
						->where('warehouse = "tw" AND ship_type = 16 AND (done_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$transfer_dhl_send = $query->select('id, send_date, dst_warehouse, content, shipping_info')
						->from('transfer')
						->where('src_warehouse like "tw%" AND ship_type = "dhl" AND (send_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$transfer_dhl_recv = $query->select('id, recv_date, src_warehouse, content, shipping_info')
						->from('transfer')
						->where('dst_warehouse like "tw%" AND ship_type = "dhl" AND (recv_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$transfer_seaair_send = $query->select('id, send_date, dst_warehouse, content, shipping_info')
						->from('transfer')
						->where('src_warehouse like "tw%" AND (ship_type = "sea" OR ship_type = "air") AND (send_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$transfer_seaair_recv = $query->select('id, recv_date, src_warehouse, content, shipping_info')
						->from('transfer')
						->where('dst_warehouse like "tw%" AND (ship_type = "sea" OR ship_type = "air") AND (recv_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		$query = new Query;
		$certcard_dhl_recv = $query->select('DHL, t_send_date')
						->from('certcard')
						->where('t_send_date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('id ASC')
						->all();

		custom_download($orders_export, $orders_dhl, $transfer_dhl_send, $transfer_dhl_recv, $transfer_seaair_send, $transfer_seaair_recv, $certcard_dhl_recv, $to, $from);
	}

	public function actionDownload_kpi($warehouse='xm', $from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		$kpis = array();

		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$to1 = str_replace('-', '/', $to);
		$to2 = date('Y-m-d',strtotime($to1 . "+1 days"));

		$query = new Query;
		$orders_kpi = $query->select('id, ctime, dtime')
						->from('order')
						->where('warehouse = "'.$warehouse.'" AND status != 0 AND done_date IS NOT NULL AND (dtime BETWEEN  "'.$from.'" AND "'.$to2.'" OR ctime BETWEEN  "'.$from.'" AND "'.$to2.'")')
						->orderBy('dtime ASC')
						->all();


		foreach ($orders_kpi as $order_kpi) {
			$hour_ = new \DateTime($order_kpi['ctime']);
			$hour = $hour_->format('H');

			$order_kpi['interval'] = $this->number_of_working_days($order_kpi['ctime'], $order_kpi['dtime']);
			if($hour < 12){
				$order_kpi['pass'] = $order_kpi['interval'] < 1;
			} else {
				$order_kpi['pass'] = $order_kpi['interval'] < 2;
			}
			array_push($kpis, $order_kpi);
		}		


		kpi_download($kpis, $warehouse, $to, $from);
	}

	public function actionAjaxFee()
	{
		$post_param = Yii::$app->request->post();

		$req_fee = \Fee::getShipFreightFee($post_param['org_fee'], $post_param['region'], $post_param['warehouse'], $post_param['type'], $post_param['weight'], $post_param['box']);

		return $req_fee;
	}

	protected function number_of_working_days($from, $to) {
		$workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)

		$from_ = new \DateTime($from);
		$to_ = new \DateTime($to);
		$from = new \DateTime($from_->format('Y-m-d'));
		$to = new \DateTime($to_->format('Y-m-d'));
		$interval = new \DateInterval('P1D');
		$periods = new \DatePeriod($from, $interval, $to);

		$days = 0;
		foreach ($periods as $period) {
			if (!in_array($period->format('N'), $workingDays)) continue;
			$days++;
		}
		return $days;
	}

	protected function sendMail($body, $subject, $warehouse, $azure = false, $justin_smile = false, $gina = false, $kim = false, $young = false){

		$notify = Notify::findOne(0);

		$mail = new \PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = $notify->name;
		$mail->Password = $notify->pw;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 465;
		$mail->setFrom($notify->name, 'Notification');
		if($warehouse == 'xm'){
			$mail->addAddress('jenny@lang-win.com.tw');
		} else {
			$mail->addAddress('kevin.cheng@lang-win.com.tw');
			$mail->addAddress('fenix@lang-win.com.tw');
		}
		$mail->addAddress('jack@lang-win.com.tw');
		$mail->addAddress('yiyin.chen@lang-win.com.tw');
		$mail->addAddress('Raelene.Jefferson@padi.com.au');
		$mail->addAddress('Stuart.Terrell@padi.com.au');
		$mail->addAddress('warehouse@padi.com.au');
		$mail->addAddress('Min.Wang@padi.com');
		$mail->addAddress('Rachel.Xu@padi.com');
		if(!YII_ENV_DEV && $azure){
			$mail->addAddress('Smile.Wang@padi.com');
		}
		if(!YII_ENV_DEV && $justin_smile){
			$mail->addAddress('Justin.He@padi.com.au');
			$mail->addAddress('Smile.Wang@padi.com');
		}
		if(!YII_ENV_DEV && $gina){
			$mail->addAddress('Gina.Park@padi.com.au');
		}
		if(!YII_ENV_DEV && $young){
			$mail->addAddress('younghee.simpson@padi.com.au');
		}
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
		if(!YII_ENV_DEV){
			if(!$mail->send()){
				$log = new Log();
				$log->username = Yii::$app->user->identity->username;
				$log->action = 'Send Mail Error ['.$subject.']'." Mailer Error: " . $mail->ErrorInfo;
				$log->insert();
			}
		}
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
			$estimate += $product_cnt * $weight;

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

				$estimate += $detail[$p_name]['cnt'] * $weight;

			}
			$crewpak_content[$crewpak_id]['detail'] = $detail;
			$crewpak_content[$crewpak_id]['done'] = false;

			$x++;
		}

		$content['product'] = $product_content;
		$content['crewpak'] = $crewpak_content;
		$content['estimate'] = ($estimate/1000).' kg';
		$content['estimate_w'] = $estimate/1000;

		return $content;
	}

	protected function get_ship($post_param, $now, $complement_cnt, $complement = false){

		$ship_array = array();

		$x = 0;
		while(1){

			$ship_idx = "shipping_".$x;
			$packing_cnt_idx = "packing_cnt_".$x;
			$packing_type_idx = "packing_type_".$x;
			$weight_idx = "weight_".$x;
			$fee_idx = "shipping_fee_".$x;
			$req_fee_idx = "req_fee_".$x;

			if(!isset($post_param[$ship_idx])){
				break;
			}

			if(0 == strcmp($post_param[$ship_idx], "")){
				$x++;
				continue;
			}

			$ship = preg_replace('/\s(?=)/', '', $post_param[$ship_idx]);
			$packing_cnt = $post_param[$packing_cnt_idx];
			$packing_type = $post_param[$packing_type_idx];
			$weight = $post_param[$weight_idx];
			$fee = $post_param[$fee_idx];
			$req_fee = $post_param[$req_fee_idx];

			$ship_content = array();
			$ship_content['id'] = $ship.'_'.$now;
			$ship_content[$packing_type] = $packing_cnt;
			$ship_content['weight'] = $weight;
			$ship_content['fee'] = $fee;
			$ship_content['req_fee'] = $req_fee;
			$ship_content['type'] = $post_param['Order']['ship_type'];
			$ship_content['date'] = date("Y-m-d", strtotime($post_param['Order']['done_date']));
			$ship_content['complement'] = $complement;

			if(0 == $x){
				if($complement){
					$ship_content['complement_cnt'] = $complement_cnt;
				}
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

	protected function get_inv_content($post_param){

		$product_content = array();

		$en = (0 == strcmp('Korea', $post_param['Order']['region'])) || (0 == strcmp('Philippines', $post_param['Order']['region'])) || (0 == strcmp('Malaysia', $post_param['Order']['region']));

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
			$product_content[$product_id]['cnt'] += $product_cnt;
			$product_content[$product_id]['inv_price'] = get_inv_price($product_id);
			$product_content[$product_id]['id'] = $product_id;
			if($en){
				$product_content[$product_id]['name'] = get_product_name_en($product_id);
			} else {
				$product_content[$product_id]['name'] = get_product_name($product_id);
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


			foreach ($crewpak->attributes() as $key => $p_name) {
				if($key < 4 || $crewpak->$p_name == 0){
					continue;
				}

				$product_content[$p_name]['cnt'] += $crewpak->$p_name * $crewpak_cnt;
				$product_content[$p_name]['inv_price'] = get_inv_price($p_name);
				$product_content[$p_name]['id'] = $p_name;
				if($en){
					$product_content[$p_name]['name'] = get_product_name_en($p_name);
				} else {
					$product_content[$p_name]['name'] = get_product_name($p_name);
				}

			}

			$x++;
		}

		return $product_content;
	}


	protected function download_xm($model){

		echo '<p style="text-align: center;"><span style="color: #808080; line-height:3pt;">'.chineseToUnicode('廈門卡樂兒商貿公司').'<br>';
		echo 'XIAMEN COLOR TRADE LIMITED<br>';
		echo chineseToUnicode('包裝打捆紀錄單').'<br><span style="font-size: small;">'.chineseToUnicode('日期').':'.$model->date.'</span></span></p>';
		echo '<p style="text-align: left;">';
		if($model->ship_type == \ShippingType::T_STD_EXPR){
			echo chineseToUnicode('送货方式：■顺丰标快(空运) □顺丰标快(陆运) □顺丰物流普运').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SF_SP){
			echo chineseToUnicode('送货方式：□顺丰标快(空运) ■顺丰标快(陆运) □顺丰物流普运').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SF_NORMAL){
			echo chineseToUnicode('送货方式：□顺丰标快(空运) □顺丰标快(陆运) ■顺丰物流普运').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SELFPICK){
			echo chineseToUnicode('送货方式：□顺丰标快(空运) □顺丰标快(陆运) □顺丰物流普运 ■客戶自取').'</p>';
		} else if ($model->ship_type == \ShippingType::T_DPN){
			echo chineseToUnicode('送货方式：■德邦物流').'</p>';
		} else {
			echo chineseToUnicode('送货方式：□顺丰标快(空运) □顺丰标快(陆运) □顺丰物流普运').'</p>';
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
		echo '<p>'.chineseToUnicode('备注：').chineseToUnicode($model->extra_info).'</p>';
	}

	protected function download_tw_header($model){

		echo '<div style="text-align: center;"><span style="line-height:3pt;">'.chineseToUnicode('光隆印刷廠股份有限公司').' -- ';
		echo chineseToUnicode('包裝打捆紀錄單').'<br><span style="font-size: 24px;">'.chineseToUnicode('日期').':'.$model->date.'</span></span></div>';
		if($model->ship_type == \ShippingType::T_CHI_MAIL){
			echo chineseToUnicode('送貨單位：').'<span style="font-size: 24px;">'.
					chineseToUnicode('■中華郵政').'</span>'.chineseToUnicode(' □順丰快遞 □新航快遞').'</p>';
		} else if ($model->ship_type == \ShippingType::T_SF){
			echo chineseToUnicode('送貨單位：□中華郵政 ').'<span style="font-size: 24px;">'.
					chineseToUnicode('■順丰快遞').'</span>'.chineseToUnicode(' □新航快遞').'</p>';
		} else if ($model->ship_type == \ShippingType::T_NEW){
			echo chineseToUnicode('送貨單位：□中華郵政 □順丰快遞 ').'<span style="font-size: 24px;">'.
					chineseToUnicode('■新航快遞').'</span></p>';
		} else if ($model->ship_type == \ShippingType::T_SELFPICK){
			echo chineseToUnicode('送貨單位：□中華郵政 □順丰快遞 □新航快遞 ').'<span style="font-size: 24px;">'.
					chineseToUnicode('■客戶自取').'</span></p>';
		} else {
			echo chineseToUnicode('送貨單位：■').'<span style="font-size: 24px;">'.chineseToUnicode(\ShippingType::getShippingType($model->ship_type)).'</p>';
		}

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 700px">';
		echo '<colgroup>';
		echo '<col style="width: 200px">';
		echo '<col style="width: 150px">';
		echo '<col style="width: 200px">';
		echo '<col style="width: 150px">';
		echo '</colgroup>';
		echo '<tr>';
		echo '<th class="tg-s6z2">'.chineseToUnicode('會員編號').'</th>';
		echo '<th class="tg-031e">'.$model->customer_id.'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('訂單號碼').'PO#</th>';
		echo '<th class="tg-031e">'.$model->id.'</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="tg-s6z2">'.chineseToUnicode('會員資訊').'<br></td>';
		$customer_name = get_customer_name($model->customer_id, true);
		echo '<td class="tg-031e" colspan="3"><span">'.chineseToUnicode('會員名稱(英)').': '.chineseToUnicode($customer_name['eng']).
						'<br><span">'.chineseToUnicode('會員名稱(中)').': '.chineseToUnicode($customer_name['chi']).
						'<br><span">'.chineseToUnicode('地址(英)').': '.chineseToUnicode($model->english_addr).
						'<br><span">'.chineseToUnicode('地址(中)').': '.chineseToUnicode($model->chinese_addr).
						'<br><span">'.chineseToUnicode('收件人').': '.chineseToUnicode($model->contact).
						'<br><span">'.chineseToUnicode('聯絡电话').': '.chineseToUnicode($model->tel).
						'</td>';
		echo '</tr>';
		echo '</table>';

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 700px">';
		echo '<colgroup>';
		echo '<col style="width: 100px">';
		echo '<col style="width: 600px">';
		echo '<col style="width: 100px">';
		echo '</colgroup>';
		echo '<tr>';
		echo '<th class="tg-s6z2">'.chineseToUnicode('產品編號').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('產品名稱').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('數量').'</th>';
		echo '</tr>';

	}
	protected function download_tw($model){

		echo '<style type="text/css">';
		echo '.tg  {border-collapse:collapse;border-spacing:0;}';
		echo '.tg td{font-family:Arial, sans-serif;font-size:17px;padding:3px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}';
		echo '.tg th{font-family:Arial, sans-serif;font-size:17px;font-weight:normal;padding:0px 0px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}';
		echo '.tg .tg-s6z2{text-align:center; padding:0px 0px;}';
		echo '</style>';

		echo '<style>';
		echo '@page WordSection1';
		echo '{size:595.3pt 841.9pt;';
		echo 'margin:36.0pt 36.0pt 36.0pt 36.0pt;';
		echo 'mso-header-margin:42.55pt;';
		echo 'mso-footer-margin:49.6pt;';
		echo 'mso-paper-source:0;}';
		echo 'div.WordSection1';
		echo '{page:WordSection1;}';
		echo '</style>';

		echo '<div class=WordSection1> ';


		$this->download_tw_header($model);
		order_content_to_download_table($model->content);
		echo '</table>';

/*

		$content_array = json_decode($model->content, true);
		$has_product = is_array($content_array['product']) && (count($content_array['product']) > 0);
		$page = count($content_array['crewpak']);
		if($has_product){
			$page++;
		}
		$p = 1;

		if(isset($content_array['crewpak'])){
			$crewpak_array = $content_array['crewpak'];
			foreach ($crewpak_array as $crewpak_name => $crewpak_detail) {
				$this->download_tw_header($model);
				crewpak_to_download_table($crewpak_name, $crewpak_detail);
				echo '</table>';

				if($has_product || ($crewpak_detail !== end($crewpak_array))){
					echo '<p style="text-align: center;"><span style="font-size: 24px;">'.$p.'/'.$page.'</span></p>';
					echo '<br style="page-break-before: always">';
					$p++;
				}
			}
		}

		if($has_product){
			$product_array = $content_array['product'];
			$this->download_tw_header($model);
			foreach ($product_array as $product_name => $product_detail) {
				product_detail_to_download_table($product_name, $product_detail);
			}
			echo '</table>';
		}
*/
		echo '<p>'.chineseToUnicode('執行者簽名：').'</p>';
		echo '<p>'.chineseToUnicode('覆核： □已確認語文版本皆正確 □已確認產品數量皆正確    簽名:').'</p>';
		$content = json_decode($model->content, true);
		if(isset($content['estimate'])){
			echo '<p>'.chineseToUnicode('預估重量： '.$content['estimate']).'</p>';
		}
		echo '<p>'.chineseToUnicode('覆核：').'</p>';
		echo '<p>'.chineseToUnicode('出貨：').'</p>';
		echo '<p>'.chineseToUnicode('運費：').'</p>';
		echo '<p>'.chineseToUnicode('備註：').chineseToUnicode($model->extra_info).'</p>';
		echo '<p style="text-align: center;"><span style="font-size: 24px;">'.$p.'/'.$page.'</span></p>';
		echo '</div> ';

	}
}
