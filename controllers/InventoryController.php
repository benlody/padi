<?php

namespace app\controllers;

use app\models\User;
use app\models\Log;
use app\models\PurchaseOrder;
use app\models\Order;
use app\models\Product;
use app\models\Transfer;
use yii\data\ArrayDataProvider;
use app\models\CrewPak;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use yii\db\Query;
use yii\filters\AccessControl;
use Yii;
use yii\web\NotFoundHttpException;

require_once __DIR__  . '/../utils/utils.php';

class InventoryController extends \yii\web\Controller
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

	public function actionAdjust()
	{
		if(Yii::$app->user->identity->group > User::GROUP_MGR){
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		$product = new Product();
		$post_param = Yii::$app->request->post();

		if(isset($post_param['adjust'])){

			$warehouse = $post_param['warehouse'];
			$warehouse_type = $post_param['warehouse_type'];
			$balance_model = new Balance1($warehouse, $warehouse_type);
			$transaction_model = new Transaction1($warehouse, $warehouse_type);
			get_balance($balance_model, $warehouse, $warehouse_type);

			$x = 0;
			while(1){

				$product_idx = "product_".$x;
				$product_cnt_idx = "product_cnt_".$x;
				$change_idx = "change_".$x;

				if(!isset($post_param[$product_idx])){
					break;
				}

				$product_id =  $post_param[$product_idx];
				$product_cnt = $post_param[$product_cnt_idx];

				$transaction_model->$product_id = $product_cnt - $balance_model->$product_id;
				$balance_model->$product_id = $product_cnt;

				if($transaction_model->$product_id != $post_param[$change_idx]){
					echo "<script type='text/javascript'>alert('庫存已被更動或輸入錯誤 請重新輸入');</script>";
					return $this->render('adjust', [
						'product' =>  $product->find()->column()
					]);
				}

				$x++;
			}

			$now = strtotime('now');
			$today = date("Y-m-d", strtotime('today'));

			$transaction_model->serial = 'adjust_'.date("Y-m-d H:i:s", $now).'_'.$now;
			$transaction_model->date = $today;
			$transaction_model->extra_info = $post_param['extra_info'];

			$balance_model->serial = 'adjust_'.date("Y-m-d H:i:s", $now).'_'.$now;
			$balance_model->date = $today;
			$balance_model->extra_info = $post_param['extra_info'];

			$transaction_model->insert();
			$balance_model->insert();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Adjust Inventory';
			$log->insert();

			return $this->redirect(['transaction',
				'warehouse' => $warehouse,
				'type' => $warehouse_type,
				]);

		} else {
			return $this->render('adjust', [
				'product' =>  $product->find()->column()
			]);
		}
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionOverview($warehouse='xm')
	{
		$query = new Query;
		$query2 = new Query;
		$product = new Product();
		$product_aray = $product->find()->column();
		$overview = array();
		$overview_crewpak = array();

		if(Yii::$app->user->identity->group == User::GROUP_XM && $warehouse != 'xm'){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$padi_balance = $query->select('*')
						->from($warehouse.'_padi_balance')
						->orderBy('ts DESC')
						->limit(1)
						->one();

		$self_balance = $query->select('*')
						->from($warehouse.'_self_balance')
						->orderBy('ts DESC')
						->limit(1)
						->one();

		$safety = $query2->select('id, warning_cnt_'.$warehouse)
						->from('product')
						->all();

		if('xm' == $warehouse){
			$crewpak_array = array("60020C", "60303C", "60303SC", "60304C", "60346SC", "61301C", "61301SC", "70149C", 
									"60134C", "60236SC", "60253SC");
		} else {
			$crewpak_array = array("60020C", "60020K", "60134C", "60134K", "60303C", "60330C", "60303K", "60304C", 
									"60304K", "60346C", "61301C", "61301K", "60330K", "70120K", "70149C", "70150K", "70513KX");
		}

		foreach ($safety as $value) {
			$safety_stock[$value['id']] = $value['warning_cnt_'.$warehouse];
		}

		foreach ($product_aray as $p) {
			if($padi_balance[$p] || $self_balance[$p] || $safety_stock[$p]){
				$overview[$p]['warehouse'] = $warehouse;
				$overview[$p]['id'] = $p;
				$overview[$p]['padi'] = $padi_balance[$p] ? $padi_balance[$p] : 0;
				$overview[$p]['self'] = $self_balance[$p] ? $self_balance[$p] : 0;
				$overview[$p]['safety'] = $safety_stock[$p] ? $safety_stock[$p] : 0;
				if (in_array($p, $crewpak_array)){
					$overview_crewpak[$p]['warehouse'] = $warehouse;
					$overview_crewpak[$p]['id'] = $p;
					$overview_crewpak[$p]['padi'] = $padi_balance[$p] ? $padi_balance[$p] : 0;
					$overview_crewpak[$p]['self'] = $self_balance[$p] ? $self_balance[$p] : 0;
					$overview_crewpak[$p]['safety'] = $safety_stock[$p] ? $safety_stock[$p] : 0;
				}
			}
		}

		$provider = new ArrayDataProvider([
				'allModels' => $overview,
				'pagination' => [
					'pageSize' => 500,
				],
		]);

		$provider_crewpak = new ArrayDataProvider([
				'allModels' => $overview_crewpak,
				'pagination' => [
					'pageSize' => 500,
				],
		]);


		return $this->render('overview', [
				'warehouse' => $warehouse,
				'provider' => $provider,
				'provider_crewpak' => $provider_crewpak,
		]);
	}

	public function actionLow_stock($warehouse='xm')
	{

		$query = new Query;
		$query2 = new Query;
		$query3 = new Query;
		$product = new Product();
		$product_aray = $product->find()->column();
		$lowstock = array();
		$lowstock_c = array();

		if(Yii::$app->user->identity->group == User::GROUP_XM && $warehouse != 'xm'){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$padi_balance = $query->select('*')
						->from($warehouse.'_padi_balance')
						->orderBy('ts DESC')
						->limit(1)
						->one();

		$safety = $query2->select('id, warning_cnt_'.$warehouse)
						->from('product')
						->all();

		$crewpak = $query3->select('*')
						->from('crew_pak')
						->all();

		foreach ($safety as $value) {
			$safety_stock[$value['id']] = $value['warning_cnt_'.$warehouse];
		}

		foreach ($product_aray as $p) {
			if($safety_stock[$p] > 0 && $padi_balance[$p] < $safety_stock[$p]){
				$lowstock[$p]['id'] = $p;
				$lowstock[$p]['padi'] = $padi_balance[$p] ? $padi_balance[$p] : 0;
				$lowstock[$p]['safety'] = $safety_stock[$p] ? $safety_stock[$p] : 0;
				foreach ($crewpak as $c) {
					$skip = false;
					if(0 != $c[$p]){
						$content = array();
						foreach ($product_aray as $pp) {
							if(0 != $c[$pp]){
								if($safety_stock[$pp] == 0){
									$skip = true;
									break;
								}
								$content[$pp] = $c[$pp];
							}
						}
						if($skip){
							break;
						}
						$lowstock_c[$c['id']]['id'] = $c['id'];
						$lowstock_c[$c['id']]['content'] = $content;
						if(!isset($lowstock_c[$c['id']]['low'])){
							$lowstock_c[$c['id']]['low'] = array();
						}
						array_push($lowstock_c[$c['id']]['low'], $p);
					}
				}
			}
		}

		$provider = new ArrayDataProvider([
				'allModels' => $lowstock,
				'pagination' => [
					'pageSize' => 500,
				],
		]);
		$provider_c = new ArrayDataProvider([
				'allModels' => $lowstock_c,
				'pagination' => [
					'pageSize' => 500,
				],
		]);

		return $this->render('low_stock', [
				'warehouse' => $warehouse,
				'provider' => $provider,
				'provider_c' => $provider_c,
		]);
	}


	public function actionTransaction($warehouse='xm', $type='padi', $from='', $to='', $single_product='')
	{
		$product = Product::find()->column();
		$query = new Query;
		$query2 = new Query;
		$post_param = Yii::$app->request->post();
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
		if($post_param['single_product']){
			$single_product = $post_param['single_product'];
		}

		if(Yii::$app->user->identity->group == User::GROUP_XM && $warehouse != 'xm'){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$transaction = $query->select('*')
						->from($warehouse.'_'.$type.'_transaction')
						->where('date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('ts DESC')
						->all();

		$start_balance = $query->select('*')
						->from($warehouse.'_'.$type.'_balance')
						->where('date < "'.$from.'"')
						->orderBy('ts DESC')
						->limit(1)
						->one();

		$end_balance = $query->select('*')
						->from($warehouse.'_'.$type.'_balance')
						->where('date <= "'.$to.'"')
						->orderBy('ts DESC')
						->limit(1)
						->one();


		foreach ($transaction as $key => $t) {
			$pos1 = strpos($t['serial'], '_');
			$pos2 = strrpos($t['serial'], '_');
			$t['id'] = substr($t['serial'], $pos1 + 1, $pos2 - $pos1 - 1);
			$t['desc'] = substr($t['serial'], 0, $pos1);
			$transaction[$key] = $t;
		}

		$product_show = array();
		foreach ($product as $p) {
			if ($start_balance[$p] != 0 || $end_balance[$p] != 0){
				array_push($product_show, $p);
			}
		}

		$crewpak = $query2->select('*')
						->from('crew_pak')
						->all();

		$crew_list = array();

		if($single_product){
			$crew_list[$single_product] = array();
			array_push($crew_list[$single_product], $single_product);
}
/*
		foreach ($crewpak as $c) {
			$crew_list[$c['id']] = array();
			foreach ($product as $p) {
				if(0 != $c[$p]){
					array_push($crew_list[$c['id']], $p);
				}
			}
		}
*/
		return $this->render('transaction',[
			'warehouse' => $warehouse,
			'type' => $type,
			'from' => $from,
			'to' => $to,
			'start_balance' => $start_balance,
			'end_balance' => $end_balance,
			'transaction' => $transaction,
			'product' => $product_show,
			'product_all' => $product,
			'single_product' => $single_product,
			'crew_list' => $crew_list
		]);
	}

	public function actionSummary()
	{

		$xm_provider = $this->get_summary_provider('xm');
		if(Yii::$app->user->identity->group == User::GROUP_XM){
			$tw_provider = new ArrayDataProvider;
		} else {
			$tw_provider = $this->get_summary_provider('tw');
		}

		return $this->render('summary', [
			'tw_provider' => $tw_provider,
			'xm_provider' => $xm_provider,
		]);
	}

	public function actionAjaxGet_balance()
	{
		$post_param = Yii::$app->request->post();
		$query = new Query;
		$balance = $query->select('`'.$post_param["id"].'`')
						->from($post_param["balance"])
						->orderBy('ts DESC')
						->limit(1)
						->one();

		return json_encode($balance,JSON_FORCE_OBJECT);
	}

	protected function get_summary_provider($wh){

		$order_query = new Query;
		$transfer_query = new Query;
		$balance_query = new Query;
		$po_query = new Query;
		$summary = array();


		$pos = $order_query->select('content')
							->from('purchase_order')
							->where('warehouse = "'.$wh.'" AND status != '.PurchaseOrder::STATUS_DONE)
							->all();
		foreach ($pos as $po) {
			$content = json_decode($po['content'], true);
			foreach ($content as $p => $cnt) {
				$summary[$p]['po_cnt'] += $cnt['order_cnt'];
			}
		}

		$orders = $order_query->select('content')
							->from('order')
							->where('warehouse = "'.$wh.'" AND status != '.Order::STATUS_DONE)
							->all();

		foreach ($orders as $order) {

			$content = json_decode($order['content'], true);

			foreach ($content['product'] as $p => $detail) {
				if($detail['done'] === true){
					continue;
				} else if($detail['done']){
					$summary[$p]['order_cnt'] += ($detail['cnt'] - $detail['done']);
				} else {
					$summary[$p]['order_cnt'] += $detail['cnt'];
				}
			}

			foreach ($content['crewpak'] as $c => $detail) {
				if($detail['done']){
					continue;
				}
				foreach ($detail['detail'] as $p => $p_detail) {
					if($p_detail['done'] === true){
						continue;
					} else if($p_detail['done']){
						$summary[$p]['order_cnt'] += ($p_detail['cnt'] - $p_detail['done']);
					} else {
						$summary[$p]['order_cnt'] += $p_detail['cnt'];
					}
				}
			}
		}

		$transfers_src = $transfer_query->select('content')
							->from('transfer')
							->where('src_warehouse LIKE "'.$wh.'%" AND status = '.Transfer::STATUS_NEW)
							->all();

		foreach ($transfers_src as $transfer) {
			$content = json_decode($transfer['content'], true);
			foreach ($content as $p => $cnt) {
				$summary[$p]['trans_src_cnt'] += $cnt;
			}
		}

		$transfers_dst = $transfer_query->select('content')
							->from('transfer')
							->where('dst_warehouse LIKE "'.$wh.'%" AND status != '.Transfer::STATUS_DONE)
							->all();

		foreach ($transfers_dst as $transfer) {
			$content = json_decode($transfer['content'], true);
			foreach ($content as $p => $cnt) {
				$summary[$p]['trans_dst_cnt'] += $cnt;
			}
		}


		$balance = $balance_query->select('*')
							->from($wh.'_padi_balance')
							->orderBy('ts DESC')
							->limit(1)
							->one();
		foreach ($summary as $p => $cnt) {
			$summary[$p]['balance'] = $balance[$p] ? $balance[$p] : 0;
			$summary[$p]['id'] = $p;
			$summary[$p]['order_cnt'] = $summary[$p]['order_cnt'] ? $summary[$p]['order_cnt'] : '';
			$summary[$p]['po_cnt'] = $summary[$p]['po_cnt'] ? $summary[$p]['po_cnt'] : '';
			$summary[$p]['trans_src_cnt'] = $summary[$p]['trans_src_cnt'] ? $summary[$p]['trans_src_cnt'] : '';
			$summary[$p]['trans_dst_cnt'] = $summary[$p]['trans_dst_cnt'] ? $summary[$p]['trans_dst_cnt'] : '';
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

}
