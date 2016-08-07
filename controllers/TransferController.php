<?php

namespace app\controllers;

use app\models\Log;
use app\models\Product;
use app\models\Transfer;
use app\models\TransferSearch;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use Yii;
use yii\filters\AccessControl;
use app\models\User;
use yii\web\NotFoundHttpException;

require_once __DIR__  . '/../utils/utils.php';
require_once __DIR__  . '/../utils/enum.php';

class TransferController extends \yii\web\Controller
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

		$model = new Transfer;
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){

			$content = $this->get_content($post_param);
			$post_param['Transfer']['content'] = json_encode($content, JSON_FORCE_OBJECT);

			$src = $post_param['Transfer']['src_warehouse'];
			$dst = $post_param['Transfer']['dst_warehouse'];

			if(0 == strcmp($src, $dst)){
				echo "<script type='text/javascript'>alert('倉儲來源與目的相同 請重新輸入');</script>";
				return $this->render('add', [
					'model' => $model,
					'product' =>  $product->find()->column()
				]);

			} else if(0 == strncmp($dst, 'padi', 4)){

				$pos = strpos($src, '_');
				$warehouse = substr($src, 0, $pos);
				$warehouse_type = substr($src, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));

				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_NEW;

				$model->insert();

				$log = new Log();
				$log->username = Yii::$app->user->identity->username;
				$log->action = 'Add transfer ['.$model->id.']';
				$log->insert();

				return $this->redirect(['list']);

			} else if(0 == strncmp($src, 'padi', 4)){

				$pos = strpos($dst, '_');
				$warehouse = substr($dst, 0, $pos);
				$warehouse_type = substr($dst, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));

				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_ONTHEWAY;

				$model->insert();
				
				$log = new Log();
				$log->username = Yii::$app->user->identity->username;
				$log->action = 'Add transfer ['.$model->id.']';
				$log->insert();

				return $this->redirect(['list']);

			} else if(0 == strncmp($src, $dst, strpos($dst, '_'))){

				$pos = strpos($dst, '_');
				$warehouse = substr($dst, 0, $pos);
				$dst_warehouse_type = substr($dst, $pos + 1);
				$src_warehouse_type = substr($src, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));
				$post_param['Transfer']['recv_date'] = date("Y-m-d", strtotime($post_param['date']));
				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_DONE;

				$dst_transaction_model =  new Transaction1($warehouse, $dst_warehouse_type);
				$src_transaction_model =  new Transaction2($warehouse, $src_warehouse_type);
				$dst_balance_model =  new Balance1($warehouse, $dst_warehouse_type);
				$src_balance_model =  new Balance2($warehouse, $src_warehouse_type);
				get_balance($dst_balance_model, $warehouse, $dst_warehouse_type);
				get_balance($src_balance_model, $warehouse, $src_warehouse_type);
				foreach ($content as $p_name => $cnt) {
					$dst_transaction_model->$p_name += $cnt;
					$src_transaction_model->$p_name -= $cnt;
					$dst_balance_model->$p_name += $cnt;
					$src_balance_model->$p_name -= $cnt;
				}

				$now = strtotime('now');
				$dst_transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$dst_transaction_model->date = date("Y-m-d", strtotime($post_param['date']));
				$dst_transaction_model->extra_info = $post_param['Transfer']['extra_info'];
				$src_transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$src_transaction_model->date = date("Y-m-d", strtotime($post_param['date']));
				$src_transaction_model->extra_info = $post_param['Transfer']['extra_info'];

				$dst_balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$dst_balance_model->date = date("Y-m-d", strtotime($post_param['date']));
				$dst_balance_model->extra_info = $post_param['Transfer']['extra_info'];
				$src_balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$src_balance_model->date = date("Y-m-d", strtotime($post_param['date']));
				$src_balance_model->extra_info = $post_param['Transfer']['extra_info'];

				$model->insert();
				$dst_transaction_model->insert();
				$src_transaction_model->insert();
				$dst_balance_model->insert();
				$src_balance_model->insert();

				$log = new Log();
				$log->username = Yii::$app->user->identity->username;
				$log->action = 'Add transfer ['.$model->id.']';
				$log->insert();

				return $this->redirect(['list', 'status' => 'done']);

			} else {
				$pos = strpos($dst, '_');
				$warehouse = substr($src, 0, $pos);
				$warehouse_type = substr($src, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));
				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_NEW;

				$model->insert();

				$log = new Log();
				$log->username = Yii::$app->user->identity->username;
				$log->action = 'Add transfer ['.$model->id.']';
				$log->insert();

				return $this->redirect(['list']);
			}

			return $this->render('add', [
				'model' => $model,
				'product' =>  $product->find()->column()
			]);

		} else {
			return $this->render('add', [
				'model' => $model,
				'product' =>  $product->find()->column()
			]);
		}
	}

	public function actionEdit($id)
	{
        if(Yii::$app->user->identity->group > User::GROUP_KL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();

		if(isset($post_param['send_done'])){
			$content = $this->get_content($post_param);
			$ship_array = $this->get_ship($post_param, $now);

			$post_param['Transfer']['shipping_info'] = json_encode($ship_array);
			$post_param['Transfer']['content'] = json_encode($content, JSON_FORCE_OBJECT);
			$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));

			$src = $post_param['Transfer']['src_warehouse'];
			$dst = $post_param['Transfer']['dst_warehouse'];

			$pos = strpos($src, '_');
			$warehouse = substr($src, 0, $pos);
			$warehouse_type = substr($src, $pos + 1);

			foreach ($post_param['Transfer'] as $key => $value) {
				$model->$key = $value;
			}
			if(0 == strncmp('padi', $dst, 4)){
				$model->status = Transfer::STATUS_DONE;
				$model->recv_date = $model->send_date;
			} else {
				$model->status = Transfer::STATUS_ONTHEWAY;
			}

			$transaction_model =  new Transaction1($warehouse, $warehouse_type);
			$balance_model =  new Balance1($warehouse, $warehouse_type);
			get_balance($balance_model, $warehouse, $warehouse_type);
			foreach ($content as $p_name => $cnt) {
				$transaction_model->$p_name -= $cnt;
				$balance_model->$p_name -= $cnt;
			}

			$now = strtotime('now');
			$transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
			$transaction_model->date = $post_param['Transfer']['send_date'];
			$transaction_model->extra_info = $post_param['Transfer']['extra_info'];

			$balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
			$balance_model->date = $post_param['Transfer']['send_date'];
			$balance_model->extra_info = $post_param['Transfer']['extra_info'];

			$model->update();
			$transaction_model->insert();
			$balance_model->insert();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Send transfer ['.$model->id.']';
			$log->insert();

			return $this->redirect(['list']);

		} else if(isset($post_param['recv_done'])){
			$content = $this->get_content($post_param);
			$post_param['Transfer']['content'] = json_encode($content, JSON_FORCE_OBJECT);
			$post_param['Transfer']['recv_date'] = date("Y-m-d", strtotime($post_param['date']));

			$src = $post_param['Transfer']['src_warehouse'];
			$dst = $post_param['Transfer']['dst_warehouse'];

			$pos = strpos($dst, '_');
			$warehouse = substr($dst, 0, $pos);
			$warehouse_type = substr($dst, $pos + 1);

			foreach ($post_param['Transfer'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = Transfer::STATUS_DONE;

			$transaction_model =  new Transaction1($warehouse, $warehouse_type);
			$balance_model =  new Balance1($warehouse, $warehouse_type);
			get_balance($balance_model, $warehouse, $warehouse_type);
			foreach ($content as $p_name => $cnt) {
				$transaction_model->$p_name += $cnt;
				$balance_model->$p_name += $cnt;
			}

			$now = strtotime('now');
			$transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
			$transaction_model->date = $post_param['Transfer']['recv_date'];
			$transaction_model->extra_info = $post_param['Transfer']['extra_info'];

			$balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
			$balance_model->date = $post_param['Transfer']['recv_date'];
			$balance_model->extra_info = $post_param['Transfer']['extra_info'];

			$model->update();
			$transaction_model->insert();
			$balance_model->insert();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Receive transfer ['.$model->id.']';
			$log->insert();

			return $this->redirect(['list', 'status' => 'done']);

		} else {

			return $this->render('edit', [
				'model' => $model,
			]);
		}
	}

	public function actionList($status='', $detail = true, $sort='-send_date')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$searchModel = new TransferSearch();
		if(0 == strcmp($status, 'done')){
			$search_param['TransferSearch'] = array('status' => Transfer::STATUS_DONE);
			$dataProvider = $searchModel->search($search_param);
		} else {
			$query = Transfer::find();
			$query->Where('status != '.Transfer::STATUS_DONE);

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);
		}

		return $this->render('list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'status' => $status,
			'detail' => $detail,
			'sort' => $sort,
		]);
	}

	public function actionDelete($id)
	{
        if(Yii::$app->user->identity->group > User::GROUP_KL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
		$this->findModel($id)->delete();

		$log = new Log();
		$log->username = Yii::$app->user->identity->username;
		$log->action = 'Delete transfer ['.$id.']';
		$log->insert();

		return $this->redirect(['list']);
	}

	public function actionDownload($id)
	{
        if(Yii::$app->user->identity->group > User::GROUP_KL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
		$model = $this->findModel($id);
		header("Content-type: text/html; charset=utf-8");
		header("Content-Disposition: attachment;Filename=XDC".date_format(date_create($model->send_date), 'md')."-".$model->id.'.doc');

		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";

		if(0 == strncmp('xm', $model->src_warehouse, 2)){
			$this->download_xm($model);
		} else {
			$this->download_tw($model);
		}

		echo "</body>";
		echo "</html>";

	}

	public function actionCheckExist(){
		$post_param = Yii::$app->request->post();
		return (Transfer::findOne($post_param['id']) !== null) ? 0 : -1;
	}

	protected function findModel($id)
	{
		if (($model = Transfer::findOne($id)) !== null) {
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
			$cnt_idx = "product_cnt_".$x;

			if(!isset($post_param[$product_idx])){
				break;
			}

			$cnt = $post_param[$cnt_idx];
			$product_id =  $post_param[$product_idx];

			if(0 == strcmp($product_id, "") || 0 == $cnt ){
				$x++;
				continue;
			}

			$content[$product_id] = $cnt;

			$x++;
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

			array_push($ship_array, $ship_content);

			$x++;
		}

		return $ship_array;
	}

	protected function download_xm($model){

		echo '<p style="text-align: center;"><span style="color: #808080; line-height:3pt;">'.chineseToUnicode('廈門卡樂兒商貿公司').'<br>';
		echo 'XIAMEN COLOR TRADE LIMITED<br>';
		echo chineseToUnicode('包裝打捆紀錄單').'<br><span style="font-size: small;">'.chineseToUnicode('日期').':'.$model->send_date.'</span></span></p>';
		echo '<p style="text-align: left;">'.chineseToUnicode('取货地点：厦门市火炬东路28号').'<br>';
		echo chineseToUnicode('送貨方式：■'.\ShippingType::getTransferShippingType($model->ship_type)).'</p>';

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
		echo '<th class="tg-s6z2"><br>DC#</th>';
		echo '<th class="tg-031e"></th>';
		echo '<th class="tg-031e">'.chineseToUnicode('订单号码').'<br>PO#</th>';
		echo '<th class="tg-031e">'.$model->id.'</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="tg-s6z2">'.chineseToUnicode('地址').'<br>ADDRESS</td>';
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
		echo '<th class="tg-031e">'.chineseToUnicode('产品名称'
			).'</th>';
		echo '<th class="tg-031e">'.chineseToUnicode('数量').'</th>';
		echo '</tr>';
		
		transfer_content_to_download_table($model->content);

		echo '</table>';

		echo '<p>'.chineseToUnicode('执行者签名：').'</p>';
		echo '<p>'.chineseToUnicode('复核： □已确认产品数量皆正确').'</p>';
		echo '<p>'.chineseToUnicode('总箱数：').'</p>';
		echo '<p>'.chineseToUnicode('总重：').'</p>';
		echo '<p>'.chineseToUnicode('运单号码：').'</p>';
		echo '<p>'.chineseToUnicode('备注：').chineseToUnicode($model->extra_info).'</p>';
	}

	protected function download_tw($model){

		echo '<p style="text-align: center;"><span style="color: #808080; line-height:3pt;">'.chineseToUnicode('光隆印刷廠股份有限公司').'<br>';
		echo 'Kuang Lung Printing Factory Co., Ltd.<br>';
		echo chineseToUnicode('包裝打捆紀錄單').'<br><span style="font-size: small;">'.chineseToUnicode('日期').':'.$model->send_date.'</span></span></p>';
		echo '<p style="text-align: left;">'.chineseToUnicode('公司地址：新北市三重區光復路一段83巷8號2F TEL:02-2999-9099 FAX:02-2999-1967').'<br>';
		echo chineseToUnicode('送貨方式：■'.\ShippingType::getTransferShippingType($model->ship_type)).'</p>';

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
		echo '<th class="tg-s6z2"><br>DC#</th>';
		echo '<th class="tg-031e"></th>';
		echo '<th class="tg-031e">'.chineseToUnicode('訂單號碼').'<br>PO#</th>';
		echo '<th class="tg-031e">'.$model->id.'</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="tg-s6z2">'.chineseToUnicode('地址').'<br>ADDRESS</td>';
		echo '<td class="tg-031e" colspan="3"><span style="background-color: #d0d0d0;">'.chineseToUnicode('地址(英)').':</span><br>'.chineseToUnicode($model->english_addr).
						'<br><span style="background-color: #d0d0d0;">'.chineseToUnicode('地址(中)').':</span><br>'.chineseToUnicode($model->chinese_addr).
						'<br><span style="background-color: #d0d0d0;">'.chineseToUnicode('收件人').':</span><br>'.chineseToUnicode($model->contact).
						'<br><span style="background-color: #d0d0d0;">'.chineseToUnicode('聯絡电话').':</span><br>'.chineseToUnicode($model->tel).
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

		transfer_content_to_download_table($model->content);

		echo '</table>';

		echo '<p>'.chineseToUnicode('備註：').chineseToUnicode($model->extra_info).'</p>';
		echo '<p>'.chineseToUnicode('執行者簽名：').'</p>';
		echo '<p>'.chineseToUnicode('覆核： □已確認語文版本皆正確 □已確認產品數量皆正確    簽名:').'</p>';
	}
}
