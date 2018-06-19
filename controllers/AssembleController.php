<?php

namespace app\controllers;

use app\models\Log;
use app\models\User;
use app\models\Product;
use app\models\AssembleOrder;
use app\models\AssembleOrderSearch;
use app\models\Assemble;
use app\models\AssembleSearch;
use app\models\Balance1;
use app\models\Transaction1;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;


require_once __DIR__  . '/../utils/utils.php';
require_once __DIR__  . '/../utils/ship_download.php';
require '../../mail/PHPMailer/PHPMailerAutoload.php';

class AssembleController extends \yii\web\Controller
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

		$assemble_order_model = new AssembleOrder;
		$post_param = Yii::$app->request->post();

		if($post_param["AssembleOrder"]){

			$assemble = $post_param['AssembleOrder']['assemble'];
			$assemble_model = Assemble::findOne($post_param['AssembleOrder']['assemble']);
			$post_param['AssembleOrder']['date'] = date("Y-m-d", strtotime($post_param['AssembleOrder']['date']));
			$post_param['AssembleOrder']['id'] = $post_param['AssembleOrder']['id'].'-'.$post_param['AssembleOrder']['warehouse'].'-'.$post_param['AssembleOrder']['assemble'];
			$post_param['AssembleOrder']['done_date'] = $post_param['AssembleOrder']['date'];
			$done_date = $post_param['AssembleOrder']['done_date'];
			$warehouse = $post_param['AssembleOrder']['warehouse'];

			foreach ($post_param['AssembleOrder'] as $key => $value) {
				$assemble_order_model->$key = $value;
			}
			$assemble_order_model->status = AssembleOrder::STATUS_DONE;

			//FIXME error handle
			$assemble_order_model->insert();

			$padi_balance_model = new Balance1($warehouse, 'padi');
			$padi_transaction_model = new Transaction1($warehouse, 'padi');
			get_balance($padi_balance_model, $warehouse, 'padi');

			$now = strtotime('now');
			$padi_transaction_model->serial = 'AO_'.$post_param['AssembleOrder']['id'].'_'.$now;;
			$padi_balance_model->serial = 'AO_'.$post_param['AssembleOrder']['id'].'_'.$now;;
			$padi_transaction_model->date = $done_date;
			$padi_balance_model->date = $done_date;

			$content = json_decode($assemble_model->content,true);
			$qty = $assemble_order_model->qty;
			$padi_transaction_model->$assemble = $qty;
			$padi_balance_model->$assemble = $padi_balance_model->$assemble + $padi_transaction_model->$assemble;
			foreach ($content as $key => $value) {
				$padi_transaction_model->$key -= $value * $assemble_order_model->qty;
				$padi_balance_model->$key = $padi_balance_model->$key + $padi_transaction_model->$key;
			}

			$padi_transaction_model->insert();
			$padi_balance_model->insert();

			if($assemble == '60020C'){
				$a_id = str_replace("60020C","70120C",$post_param['AssembleOrder']['id']);
				$body = $this->renderPartial('done_mail', [
							'id' => $a_id,
							'warehouse' => $warehouse,
							'product' => '70120C',
							'qty' => $qty,
							]);
				$subject = YII_ENV_DEV ? 'Assemble Work Finished (Test) - '.$a_id : 'Assemble Work Finished - '.$a_id;
				$this->sendMail($body, $subject);
			}

			if($assemble == '60038C'){
				$a_id = str_replace("60038C","70513C",$post_param['AssembleOrder']['id']);
				$body = $this->renderPartial('done_mail', [
							'id' => $a_id,
							'warehouse' => $warehouse,
							'product' => '70513C',
							'qty' => $qty,
							]);
				$subject = YII_ENV_DEV ? 'Assemble Work Finished (Test) - '.$a_id : 'Assemble Work Finished - '.$a_id;
				$this->sendMail($body, $subject);
			}

			if($assemble == '60134C'){
				$a_id = str_replace("60134C","70513C",$post_param['AssembleOrder']['id']);
				$body = $this->renderPartial('done_mail', [
							'id' => $a_id,
							'warehouse' => $warehouse,
							'product' => '70513C',
							'qty' => $qty,
							]);
				$subject = YII_ENV_DEV ? 'Assemble Work Finished (Test) - '.$a_id : 'Assemble Work Finished - '.$a_id;
				$this->sendMail($body, $subject);
			}

			$body = $this->renderPartial('done_mail', [
						'id' => $post_param['AssembleOrder']['id'],
						'warehouse' => $warehouse,
						'product' => $assemble,
						'qty' => $qty,
						]);
			$subject = YII_ENV_DEV ? 'Assemble Work Finished (Test) - '.$post_param['AssembleOrder']['id'] : 'Assemble Work Finished - '.$post_param['AssembleOrder']['id'];
			$this->sendMail($body, $subject);

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Finish Assemble ['.$post_param['AssembleOrder']['id'].']';
			$log->insert();

			return $this->redirect(['list', 'status' => 'done', 'sort' => '-done_date']);



		} else {
			$assemble = new Assemble();
			return $this->render('add', [
				'assemble_order_model' => $assemble_order_model,
				'assemble' =>  $assemble->find()->column()
			]);	
		}
	}

	public function actionList($status='', $sort='-date')
	{

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$searchModel = new AssembleOrderSearch();
		if(0 == strcmp($status, 'done')){
			$search_param['AssembleOrderSearch'] = array('status' => AssembleOrder::STATUS_DONE);
			$dataProvider = $searchModel->search($search_param);
		} else {
			$query = AssembleOrder::find();
			$query->Where('status != '.AssembleOrder::STATUS_DONE);

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);
		}

		return $this->render('list', [
			'dataProvider' => $dataProvider,
			'status' => $status,
			'sort' => $sort,
		]);

	}


	public function actionContentAdd()
	{

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$model = new Assemble;
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if($post_param["Assemble"]){

			$post_param['Assemble']['content'] = json_encode($this->get_content($post_param), JSON_FORCE_OBJECT);

			foreach ($post_param['Assemble'] as $key => $value) {
				$model->$key = $value;
			}

			//FIXME error handle
			$model->insert();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Add Assemble Content ['.$model->id.']';
			$log->insert();

			return $this->redirect(['content-list']);

		} else {
			return $this->render('content-add', [
				'model' => $model,
				'product' =>  $product->find()->column()
			]);	
		}
	}

	public function actionContentList()
	{

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}


        $searchModel = new AssembleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


		return $this->render('content-list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);

	}
	public function actionOrderDelete($id)
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		AssembleOrder::findOne($id)->delete();

		$log = new Log();
		$log->username = Yii::$app->user->identity->username;
		$log->action = 'Delete Assemble ['.$id.']';
		$log->insert();

		return $this->redirect(['list']);
	}

	public function actionOrderModify($id)
	{

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$assemble_order_model = AssembleOrder::findOne($id);
		$assemble = new Assemble;
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if($post_param["AssembleOrder"]){

			$post_param['AssembleOrder']['date'] = date("Y-m-d", strtotime($post_param['AssembleOrder']['date']));

			foreach ($post_param['AssembleOrder'] as $key => $value) {
				$assemble_order_model->$key = $value;
			}
			$assemble_order_model->status = AssembleOrder::STATUS_NEW;

			//FIXME error handle
			$assemble_order_model->update();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Modify Assemble Order ['.$model->id.']';
			$log->insert();

			return $this->redirect(['list']);

		} else {
			return $this->render('modify', [
				'assemble_order_model' => $assemble_order_model,
				'assemble' =>  $assemble->find()->column()
			]);	
		}
	}


	public function actionOrderEdit($id)
	{

		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$assemble_order_model = AssembleOrder::findOne($id);
		$assemble_model = Assemble::findOne($assemble_order_model->assemble);
		$post_param = Yii::$app->request->post();
		$assemble = $assemble_order_model->assemble;

		if(isset($post_param['done'])){


			$done_date = date("Y-m-d", strtotime($post_param['AssembleOrder']['done_date']));
			$warehouse = $post_param['AssembleOrder']['warehouse'];

			$post_param['AssembleOrder']['done_date'] = $done_date;

			foreach ($post_param['AssembleOrder'] as $key => $value) {
				$assemble_order_model->$key = $value;
			}
			$assemble_order_model->status = AssembleOrder::STATUS_DONE;

			//FIXME error handle
			$assemble_order_model->update();

			$padi_balance_model = new Balance1($warehouse, 'padi');
			$padi_transaction_model = new Transaction1($warehouse, 'padi');
			get_balance($padi_balance_model, $warehouse, 'padi');

			$now = strtotime('now');
			$padi_transaction_model->serial = 'AO_'.$post_param['AssembleOrder']['id'].'_'.$now;;
			$padi_balance_model->serial = 'AO_'.$post_param['AssembleOrder']['id'].'_'.$now;;
			$padi_transaction_model->date = $done_date;
			$padi_balance_model->date = $done_date;

			$content = json_decode($assemble_model->content,true);
			$qty = $assemble_order_model->qty;
			$padi_transaction_model->$assemble = $qty;
			$padi_balance_model->$assemble = $padi_balance_model->$assemble + $padi_transaction_model->$assemble;
			foreach ($content as $key => $value) {
				$padi_transaction_model->$key -= $value * $assemble_order_model->qty;
				$padi_balance_model->$key = $padi_balance_model->$key + $padi_transaction_model->$key;
			}

			$padi_transaction_model->insert();
			$padi_balance_model->insert();


			$body = $this->renderPartial('done_mail', [
						'id' => $post_param['AssembleOrder']['id'],
						'warehouse' => $warehouse,
						'product' => $assemble,
						'qty' => $qty,
						]);
			$subject = YII_ENV_DEV ? 'Assemble Work Finished (Test) - '.$post_param['AssembleOrder']['id'] : 'Assemble Work Finished - '.$post_param['AssembleOrder']['id'];
			$this->sendMail($body, $subject);

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Finish Assemble ['.$post_param['AssembleOrder']['id'].']';
			$log->insert();

			return $this->redirect(['list', 'status' => 'done']);

		} else {

			// FIXME avoid edit a done PO

			return $this->render('edit', [
				'assemble_order_model' => $assemble_order_model,
			]);
		}
	}

	public function actionBill($warehouse='xm', $from='', $to='')
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

		$assemble_orders = $query->select('*')
						->from('assemble_order')
						->where('warehouse = "'.$warehouse.'" AND status = 1 AND done_date IS NOT NULL AND (done_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		return $this->render('bill' ,[
			'warehouse' => $warehouse,
			'from' => $from,
			'to' => $to,
			'assemble_orders' => $assemble_orders,
		]);
	}

	public function actionBill_download($warehouse='xm', $from='', $to='')
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

		$assemble_orders = $query->select('*')
						->from('assemble_order')
						->where('warehouse = "'.$warehouse.'" AND status = 1 AND done_date IS NOT NULL AND (done_date BETWEEN  "'.$from.'" AND "'.$to.'")')
						->orderBy('id ASC')
						->all();

		assemble_bill_download($assemble_orders, $warehouse, $from, $to);
	}


	public function actionOrderDownload($id)
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$assemble_order_model = AssembleOrder::findOne($id);
		$assemble_model = Assemble::findOne($assemble_order_model->assemble);
		header("Content-type: text/html; charset=utf-8");
		header("Content-Disposition: attachment;Filename=組裝單-".$assemble_order_model->warehouse."-".date_format(date_create($assemble_order_model->date), 'md')."-".$assemble_order_model->id.'.doc');

		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";

		$this->download_assemble_order($assemble_order_model, $assemble_model);

		echo "</body>";
		echo "</html>";

	}

	protected function download_assemble_order($assemble_order_model, $assemble_model){

		echo chineseToUnicode('產品組裝紀錄單').'<br><span style="font-size: small;">'.chineseToUnicode('日期').':'.$assemble_order_model->date.'</span></span></p>';
		echo '<p style="text-align: left;">';

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
		echo '<th class="tg-s6z2"><br>'.chineseToUnicode('組裝單编号').'<br><br></th>';
		echo '<th class="tg-031e">'.$assemble_order_model->id.'</th>';
		echo '</tr>';
		echo '<tr>';
		echo '</table>';

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 560px">';
		echo '<colgroup>';
		echo '<col style="width: 100px">';
		echo '<col style="width: 400px">';
		echo '<col style="width: 60px">';
		echo '</colgroup>';
		echo '<tr>';
		echo '<th class="tg-s6z2">'.chineseToUnicode('编号').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('組裝內容').'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('組裝数量').'</th>';
		echo '</tr>';
		
		assemble_content_to_download_table($assemble_model->id, $assemble_model->content, $assemble_order_model->qty);

		echo '</table>';

		echo '<p>'.chineseToUnicode('执行者签名：').'</p>';
		echo '<p>'.chineseToUnicode('复核： □已确认产品数量皆正确').'</p>';
		echo '<p>'.chineseToUnicode('备注：').chineseToUnicode($model->extra_info).'</p>';
	}

	protected function sendMail($body, $subject){
		$mail = new \PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'notify@lang-win.com.tw';
		$mail->Password = '29999099lang';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 465;
		$mail->setFrom('notify@lang-win.com.tw', 'Notification');
		$mail->addAddress('jack@lang-win.com.tw');
		$mail->addAddress('yiyin.chen@lang-win.com.tw');
		$mail->addAddress('Vivian.Li@padi.com.au');
		$mail->addAddress('Stuart.Terrell@padi.com.au');
		$mail->addAddress('mostafa.said@padi.com.au');
		$mail->addAddress('Nicole.Forster@padi.com.au');
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
		if(!YII_ENV_DEV){
			$mail->send();
		}
	}
	protected function get_content($post_param){

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
			$content[$product_id] = $product_cnt;

			$x++;
		}

		return $content;
	}
}
