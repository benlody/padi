<?php

use app\models\Order;
use app\models\PurchaseOrder;
use app\models\Transfer;
use app\models\Product;
use app\models\CrewPak;
use app\models\Customer;
use yii\db\Query;


require_once __DIR__  . '/enum.php';
require_once __DIR__  . '/fee.php';

function get_puchase_order_status($status){
		switch($status){
		case PurchaseOrder::STATUS_NEW:
			$ret = '未完工';
			break;
		case PurchaseOrder::STATUS_DONE:
			$ret = '已完工';
			break;
		default:
			$ret = $status;
	}
	return $ret;
}



function get_warehouse_name($warehouse_id){
	switch($warehouse_id){
		case 'xm':
			$name = Yii::t('app', 'XDC');
			break;
		case 'xm_padi':
			$name = Yii::t('app', 'XDC PADI Balance');
			break;
		case 'xm_self':
			$name = Yii::t('app', 'XDC Self Balance');
			break;
		case 'tw':
			$name = Yii::t('app', 'Warehouse T');
			break;
		case 'tw_padi':
			$name = Yii::t('app', 'Warehouse T PADI Balance');
			break;
		case 'tw_self':
			$name = Yii::t('app', 'Warehouse T Self Balance');
			break;
		case 'padi_sydney':
			$name = 'PADI Asia Pacific';
			break;
		case 'padi_usa':
			$name = 'PADI America';
			break;
		default:
			$name = $warehouse_id;
	}
	return $name;
}

function product_content_to_table($content, $done = false){
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>品名</th><th>訂單數量</th><th>PADI已入庫</th><th>自有已入庫</th></tr></thead><tbody>';
	$content_array = json_decode($content);
	foreach ($content_array as $key => $value) {
		$table_out = $table_out.'<tr><td>'.$key.'</td><td>'.$value->order_cnt.'</td><td>'.$value->padi_cnt.'</td><td>'.$value->self_cnt.'</td></tr>';
	}
	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}

function transfer_content_to_table($content){
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>品名</th><th>名稱</th><th>數量</th></tr></thead><tbody>';
	$content_array = json_decode($content);
	foreach ($content_array as $key => $value) {

		$table_out = $table_out.'<tr><td>'.$key.'</td><td>'.get_product_name($key).'</td><td>'.$value.'</td></tr>';
	}
	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}

function order_content_to_table($content, $id){
	$table_out = '<a href="#" onclick=" return false;"><span class="glyphicon glyphicon glyphicon-eye-open" data-toggle="#'.$id.'"></span></a><div id="'.$id.'" class="grid-view" style="display: none;"><table class="table table-striped table-bordered table-tooltip"><thead><tr><th>產品編號</th><th>產品名稱</th><th>數量</th><th>出貨狀態</th></tr></thead><tbody>';

	$content_array = json_decode($content);

	$crewpak_array = $content_array->crewpak;
	foreach ($crewpak_array as $crewpak_name => $crewpak_detail) {
		$table_out = $table_out.crewpak_to_table($crewpak_name, $crewpak_detail);
	}

	$product_array = $content_array->product;
	foreach ($product_array as $product_name => $product_detail) {
		$table_out = $table_out.product_detail_to_table($product_name, $product_detail);
	}
	$table_out = $table_out.'</tbody></table></div>';


	return $table_out;
}


function crewpak_to_table($crewpak_name, $crewpak_detail){

	$table_out = '<tr><td>'.$crewpak_name.'</td><td>'.crewpak_detail_to_table($crewpak_name, $crewpak_detail->detail).'</td><td>'.$crewpak_detail->cnt.'</td><td>'.get_check_icon($crewpak_detail->done).'</td></tr>';
	return $table_out;
}

function crewpak_detail_to_table($crewpak_name, $crewpak_detail){
	$out = get_crewpk_name($crewpak_name).'<br>';
	$out = $out.'<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th width="100px">產品編號</th><th width="500px">產品名稱</th><th width="50px">數量</th><th width="50px">出貨狀態</th></tr></thead><tbody>';

	foreach ($crewpak_detail as $product_name => $product_detail) {
		$out = $out.product_detail_to_table($product_name, $product_detail);
	}

	$out = $out.'</tbody></table></div>';
	return $out;
}

function product_detail_to_table($product_name, $product_detail){

	$table_out = '<tr><td>'.$product_name.'</td><td>'.get_product_name($product_name).'</td><td>'.$product_detail->cnt.'</td><td>'.get_check_icon($product_detail->done).'</td></tr>';
	return $table_out;
}


function order_content_to_edit_table($content){
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>產品編號</th><th>產品名稱</th><th>數量</th><th>出貨狀態</th></tr></thead><tbody>';

	$content_array = json_decode($content);

	$crewpak_array = $content_array->crewpak;
	foreach ($crewpak_array as $crewpak_name => $crewpak_detail) {
		$table_out = $table_out.crewpak_to_edit_table($crewpak_name, $crewpak_detail);
	}

	$product_array = $content_array->product;
	foreach ($product_array as $product_name => $product_detail) {
		$table_out = $table_out.product_detail_to_edit_table($product_name, $product_detail, 'product['.$product_name.']', $product_name);
	}
	$table_out = $table_out.'</tbody></table></div>';


	return $table_out;
}

function crewpak_to_edit_table($crewpak_name, $crewpak_detail){

	$table_out = '<tr><td>'.$crewpak_name.'</td><td>'.crewpak_detail_to_edit_table($crewpak_name, $crewpak_detail->detail).'</td><td id="crewpak['.$crewpak_name.']">'.$crewpak_detail->cnt.'</td><td>'.get_checkbox($crewpak_detail->done, 'crewpak['.$crewpak_name.']', $crewpak_name, 'crewpak').'</td></tr>';
	return $table_out;
}

function crewpak_detail_to_edit_table($crewpak_name, $crewpak_detail){
	$out = get_crewpk_name($crewpak_name).'<br>';
	$out = $out.'<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th width="100px">產品編號</th><th width="500px">產品名稱</th><th width="50px">數量</th><th width="50px">出貨狀態</th></tr></thead><tbody>';

	foreach ($crewpak_detail as $product_name => $product_detail) {
		$out = $out.product_detail_to_edit_table($product_name, $product_detail, 'detail['.$crewpak_name.']['.$product_name.']', $crewpak_name);
	}

	$out = $out.'</tbody></table></div>';
	return $out;
}

function product_detail_to_edit_table($product_name, $product_detail, $name, $id){

	$table_out = '<tr><td>'.$product_name.'</td><td>'.get_product_name($product_name).'</td><td id="'.$name.'">'.$product_detail->cnt.'</td><td>'.get_checkbox($product_detail->done, $name, $id, 'product').'</td></tr>';
	return $table_out;
}

function transfer_content_to_download_table($content){

	$product_array = json_decode($content, true);

	foreach ($product_array as $product_name => $product_cnt) {
		echo '<tr><td>'.$product_name.'</td><td>'.chineseToUnicode(get_product_name($product_name)).'</td><td>'.$product_cnt.'</td></tr>';
	}

	return;
}


function order_content_to_download_table($content){

	$content_array = json_decode($content, true);

	if(isset($content_array['crewpak'])){
		$crewpak_array = $content_array['crewpak'];
		foreach ($crewpak_array as $crewpak_name => $crewpak_detail) {
			crewpak_to_download_table($crewpak_name, $crewpak_detail);
		}
	}

	if(isset($content_array['product'])){
		$product_array = $content_array['product'];
		foreach ($product_array as $product_name => $product_detail) {
			product_detail_to_download_table($product_name, $product_detail);
		}
	}

	return;
}


function crewpak_to_download_table($crewpak_name, $crewpak_detail){

	echo '<tr><td valign="top" align="center">'.$crewpak_name.'</td><td>';
	crewpak_detail_to_download_table($crewpak_name, $crewpak_detail['detail']);
	echo '</td><td valign="top" align="center">'.$crewpak_detail['cnt'].'</td></tr>';
	return;
}

function crewpak_detail_to_download_table($crewpak_name, $crewpak_detail){
	echo chineseToUnicode(get_crewpk_name($crewpak_name)).'<br>';

		echo '<table class="tg" style="undefined;table-layout: fixed; width: 360px">';
		echo '<colgroup>';
		echo '<col style="width: 100px">';
		echo '<col style="width: 280px">';
		echo '</colgroup>';

	foreach ($crewpak_detail as $product_name => $product_detail) {
		echo product_detail_to_download_table($product_name, $product_detail, false);
	}

	echo '</table></div>';
	return;
}

function product_detail_to_download_table($product_name, $product_detail, $display_cnt = true){

	if($product_detail['done']){
		echo '<font color="gray">';
	} else {
		echo '<font color="black">';
	}

	if($display_cnt){
		echo '<tr><td>'.$product_name.'</td><td>'.chineseToUnicode(get_product_name($product_name)).'</td><td valign="top" align="center">'.$product_detail['cnt'].'</td></tr>';
	} else {
		echo '<tr><td>'.$product_name.'</td><td>'.chineseToUnicode(get_product_name($product_name)).'</td></tr>';		
	}
	echo '</font>';
	return;
}

function crewpak_index_to_table($id, $content){
	$out = '<b>'.get_crewpk_name($id).'</b><br>';
	$table_out = $out.'<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><tbody>';

	$product_array = $content_array->product;
	foreach ($content as $product_name => $product_cnt) {
		$table_out = $table_out.'<tr><td>'.$product_name.'</td><td>'.get_product_name($product_name).'</td><td>'.$product_cnt.'</td></tr>';
	}
	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}

function shipping_info_to_table($shipping_info){
	if(!$shipping_info){
		return '';
	}
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>Tracking Number</th><th>包裝</th><th>重量</th><th>運費</th></tr></thead><tbody>';
	$ship_array = json_decode($shipping_info, true);
	foreach ($ship_array as $info) {
		$table_out = $table_out.'<tr><td>'.substr($info['id'], 0, strpos($info['id'], '_')).'</td><td>'.(isset($info['box']) ? $info['box'].'箱' : $info['pack'].'包').'</td><td>'.$info['weight'].'</td><td>'.$info['fee'].'</td></tr>';
	}
	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}


function get_product_name($id){
	$product = Product::find()
		->where(['id' => $id])
		->one();

	return $product->chinese_name;
}

function get_weight($id){
	$product = Product::find()
		->where(['id' => $id])
		->one();

	return $product->weight;
}

function get_crewpk_name($id){
	$crewpak = CrewPak::find()
		->where(['id' => $id])
		->one();

	return $crewpak->chinese_name;
}

function get_customer_name($id, $array = false){
	$costomer = Customer::find()
		->where(['id' => $id])
		->one();


	if($array){
		$ret['chi'] = $costomer->chinese_name;
		$ret['eng'] = $costomer->english_name;
	} else {
		$ret = $costomer->english_name;
	}

	return $ret;
}

function get_check_icon($done){
	if($done === true){
		return '<span class="glyphicon glyphicon glyphicon-ok"></span>';
	} else if($done){
		return $done;
	} else {
		return '';
	}
}

function get_checkbox($done, $name, $id, $class){
	if($done === true){
		return '<span class="glyphicon glyphicon glyphicon-ok"></span>';
	} else if(0 == strcmp($class, 'product')){
		return '<input type="checkbox" name="'.$name.'" class="product_'.$id.' product" data-target=".crewpak_'.$id.'" data-sibling=".product_'.$id.'">'.
				'<input id="cnt_'.$name.'" name="cnt_'.$name.'" class="cnt_'.$id.' cnt" style="width:50px;" value='.($done === false ? 0 : $done).'>';
	} else {
		return '<input type="checkbox" name="'.$name.'" class="crewpak_'.$id.' crewpak" data-target=".product_'.$id.'" data-cnt=".cnt_'.$id.'">';
	}
}

function get_order_status($status){

		switch($status){
		case Order::STATUS_NEW:
			$ret = '新增 待覆核';
			break;
		case Order::STATUS_DONE:
			$ret = '已完成出貨';
			break;
		case Order::STATUS_PROCESSING:
			$ret = '已覆核 出貨處理中';
			break;
		default:
			$ret = $status;
	}
	return $ret;
}

function get_transfer_status($status){
		switch($status){
		case Transfer::STATUS_NEW:
			$ret = '尚未出貨';
			break;
		case Transfer::STATUS_ONTHEWAY:
			$ret = '已出貨 運送中';
			break;
		case Transfer::STATUS_DONE:
			$ret = '已完成寄送';
			break;
		default:
			$ret = $status;
	}
	return $ret;
}


function get_balance(&$balance_model, $warehouse, $warehouse_type){

	$query = new Query;
	$balance = $query->select('*')
					->from($warehouse.'_'.$warehouse_type.'_balance')
					->orderBy('ts DESC')
					->one();

	foreach ($balance_model->attributes() as $key => $p_name) {
		if($key < 4 ){
			continue;
		}
		$balance_model->$p_name = $balance[$p_name];
	}


}


function transaction_to_table($start_balance, $end_balance, $transaction, $product){
	$table_out = '<div><table class="overflow-y"><thead><tr><th>日期</th><th>描述</th><th>編號</th>';

	foreach ($product as $p_name) {
		$table_out = $table_out.'<th>'.$p_name.'</th>';
	}

	$table_out = $table_out.'<th>備註</th></tr></thead><tbody><tr><th></th><th>期初餘額</th><th></th>';
	foreach ($product as $p_name) {
		$table_out = $table_out.'<td>'.$start_balance[$p_name].'</td>';
	}

	$table_out = $table_out.'<td></td></tr><tr><th></th><th>期末餘額</th><th></th>';
	foreach ($product as $p_name) {
		$table_out = $table_out.'<td>'.$end_balance[$p_name].'</td>';
	}

	$table_out = $table_out.'<td></td></tr>';

	foreach ($transaction as $trans) {
		$show_this_row = false;
		$row = '<tr><th>'.$trans['date'].'</th><th>'.$trans['desc'].'</th><th>'.$trans['id'].'</th>';
		foreach ($product as $p_name) {
			if(0 != $trans[$p_name]){
				$show_this_row = true;
			}
			$row = $row.'<td>'.(0 == $trans[$p_name] ? '' : $trans[$p_name]).'</td>';
		}
		$row = $row.'<td>'.$trans['extra_info'].'</td></tr>';
		if($show_this_row){
			$table_out = $table_out.$row;
		}
	}

	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}

function orders_to_shipment_table($orders, $warehouse, $from, $to){

	$total_service_fee = 0;
	$total_ship_fee = 0;
	$total_orig_fee = 0;
	$total_c_qty = 0;
	$total_p_qty = 0;
	$table_out = '<div><table class="overflow-y"><thead><tr>'.
					'<th>PO#</th>'.
					'<th>DC#</th>'.
					'<th>Item#</th>'.
					'<th>C Qty</th>'.
					'<th>P Qty</th>'.
					'<th>Req Date</th>'.
					'<th>Shipping Type</th>'.
					'<th>Service Fee</th>'.
					'<th>Orig Fre. Fee</th>'.
					'<th>Fre. Fee</th>'.
					'<th>Tracking#</th>'.
					'<th>Date</th></tr></thead><tbody>';


	foreach ($orders as $order) {
		$content = json_decode($order['content'], true);
		$ship_info = json_decode($order['shipping_info'], true);

		$subtotal_service_fee = 0;
		$subtotal_ship_fee = 0;
		$subtotal_orig_fee = 0;
		$subtotal_c_qty = 0;
		$subtotal_p_qty = 0;

		$cnt_service = true;
		if(!isset($order['date']) || $order['date'] < $from || $order['date'] > $to){
			$cnt_service = false;
		}

		if($cnt_service){
			foreach ($content['crewpak'] as $crewpak => $info) {
				$service_fee = Fee::getCrewpackServiceFee($info['cnt'], $warehouse);
				$subtotal_service_fee += $service_fee;
				$subtotal_c_qty += $info['cnt'];
				$row = '<tr><td>'.$order['id'].'</td>'.
							'<td>'.$order['customer_id'].'</td>'.
							'<td>'.$crewpak.'</td>'.
							'<td>'.$info['cnt'].'</td>'.
							'<td></td>'.
							'<td>'.$order['date'].'</td>'.
							'<td></td>'.
							'<td>'.$service_fee.'</td>'.
							'<td></td>'.
							'<td></td>'.
							'<td></td>'.
							'<td>'.$order['done_date'].'</td></tr>';
				$table_out = $table_out.$row;
			}

			foreach ($content['product'] as $product => $info) {
				$service_fee = Fee::getProductServiceFee($info['cnt'], $warehouse);
				$subtotal_service_fee += $service_fee;
				$subtotal_p_qty += $info['cnt'];
				$row = '<tr><td>'.$order['id'].'</td>'.
							'<td>'.$order['customer_id'].'</td>'.
							'<td>'.$product.'</td>'.
							'<td></td>'.
							'<td>'.$info['cnt'].'</td>'.
							'<td>'.$order['date'].'</td>'.
							'<td></td>'.
							'<td>'.$service_fee.'</td>'.
							'<td></td>'.
							'<td></td>'.
							'<td></td>'.
							'<td>'.$order['done_date'].'</td></tr>';
				$table_out = $table_out.$row;
			}
		}

		foreach ($ship_info as $info) {
			if(!isset($info['date']) || $info['date'] < $from || $info['date'] > $to){
				continue;
			}

			if(isset($info['complement_cnt'])){
				foreach ($info['complement_cnt'] as $product => $cnt) {
					$service_fee = Fee::getProductServiceFee($cnt, $warehouse);
					$subtotal_service_fee += $service_fee;
					$subtotal_p_qty += $cnt;
					$row = '<tr><td>'.$order['id'].'</td>'.
								'<td>'.$order['customer_id'].'</td>'.
								'<td>'.$product.' - 補寄</td>'.
								'<td></td>'.
								'<td>'.$cnt.'</td>'.
								'<td>'.$order['date'].'</td>'.
								'<td></td>'.
								'<td>'.$service_fee.'</td>'.
								'<td></td>'.
								'<td></td>'.
								'<td></td>'.
								'<td>'.$order['done_date'].'</td></tr>';
					$table_out = $table_out.$row;
				}
			}

			$ship_fee = isset($info['req_fee']) ? $info['req_fee'] : Fee::getShipFreightFee($info['fee'], $region, $warehouse, $info['type'], $info['weight'], $info['box']);
			$subtotal_ship_fee += $ship_fee;
			$subtotal_orig_fee += $info['fee'];
			$row = '<tr><td>'.$order['id'].'</td>'.
						'<td>'.$order['customer_id'].'</td>'.
						'<td></td>'.
						'<td></td>'.
						'<td></td>'.
						'<td>'.$order['date'].'</td>'.
						'<td>'.ShippingType::getShippingType($info['type']).'</td>'.
						'<td></td>'.
						'<td>'.$info['fee'].'</td>'.
						'<td>'.$ship_fee.'</td>'.
						'<td>'.substr($info['id'], 0, strpos($info['id'], '_')).'</td>'.
						'<td>'.$order['done_date'].'</td></tr>';
			$table_out = $table_out.$row;
		}

		$row = '<tr><td bgcolor="#F0E68C" colspan="2"><b>'.$order['id'].' Subtotal</b></td>'.
					'<td bgcolor="#F0E68C"></td>'.
					'<td bgcolor="#F0E68C">'.$subtotal_c_qty.'</td>'.
					'<td bgcolor="#F0E68C">'.$subtotal_p_qty.'</td>'.
					'<td bgcolor="#F0E68C"></td>'.
					'<td bgcolor="#F0E68C"></td>'.
					'<td bgcolor="#F0E68C">'.$subtotal_service_fee.'</td>'.
					'<td bgcolor="#F0E68C">'.$subtotal_orig_fee.'</td>'.
					'<td bgcolor="#F0E68C">'.$subtotal_ship_fee.'</td>'.
					'<td bgcolor="#F0E68C"></td>'.
					'<td bgcolor="#F0E68C"></td></tr>';

		$table_out = $table_out.$row;
		$total_service_fee += $subtotal_service_fee;
		$total_ship_fee += $subtotal_ship_fee;
		$total_orig_fee += $subtotal_orig_fee;
		$total_p_qty += $subtotal_p_qty;
		$total_c_qty += $subtotal_c_qty;

	}

	$row = '<tr><td bgcolor="#FFA500" colspan="2"><b>Total</b></td>'.
				'<td bgcolor="#FFA500"></td>'.
				'<td bgcolor="#FFA500">'.$total_c_qty.'</td>'.
				'<td bgcolor="#FFA500">'.$total_p_qty.'</td>'.
				'<td bgcolor="#FFA500"></td>'.
				'<td bgcolor="#FFA500"></td>'.
				'<td bgcolor="#FFA500">'.$total_service_fee.'</td>'.
				'<td bgcolor="#FFA500">'.$total_orig_fee.'</td>'.
				'<td bgcolor="#FFA500">'.$total_ship_fee.'</td>'.
				'<td bgcolor="#FFA500"></td>'.
				'<td bgcolor="#FFA500"></td></tr>';
	$table_out = $table_out.$row;

//	if('tw' == $warehouse){
	if(false){
		$row = '<tr><td bgcolor="#FFA500" colspan="2"><b>Total in AUD</b></td>'.
					'<td bgcolor="#FFA500"></td>'.
					'<td bgcolor="#FFA500"></td>'.
					'<td bgcolor="#FFA500"></td>'.
					'<td bgcolor="#FFA500"></td>'.
					'<td bgcolor="#FFA500"></td>'.
					'<td bgcolor="#FFA500">'.sprintf("%01.2f", ($total_service_fee / 24)).'</td>'.
					'<td bgcolor="#FFA500">'.sprintf("%01.2f", ($total_orig_fee / 25.3)).'</td>'.
					'<td bgcolor="#FFA500">'.sprintf("%01.2f", ($total_ship_fee / 25.3)).'</td>'.
					'<td bgcolor="#FFA500"></td>'.
					'<td bgcolor="#FFA500"></td></tr>';
		$table_out = $table_out.$row;
	}


	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}

function orders_to_statistics_table($orders, $from, $to){


	$table_out = '<div><table class="overflow-y"><thead><tr>'.
					'<th>PO#</th>'.
					'<th>DC#</th>'.
					'<th>Date</th>'.
					'<th>Region</th>'.
					'<th>Chinese Addr</th>'.
					'<th>Weight</th>'.
					'</tr></thead><tbody>';


	foreach ($orders as $order) {
		$ship_info = json_decode($order['shipping_info'], true);

		$subtotal_weight = 0;

		if($ship_info !== null){
			foreach ($ship_info as $info) {
				$subtotal_weight += $info['weight'];
			}
			$row = '<tr><td>'.$order['id'].'</td>'.
						'<td>'.$order['customer_id'].'</td>'.
						'<td>'.$order['date'].'</td>'.
						'<td>'.ShippingRegion::getRegion($order['region']).'</td>'.
						'<td>'.$order['chinese_addr'].'</td>'.
						'<td>'.$subtotal_weight.'</td>'.
						'</tr>';
			$table_out = $table_out.$row;
		}
	}

	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}


function chineseToUnicode($str){
	//split word
	preg_match_all('/./u',$str,$matches);

	$c = "";
	foreach($matches[0] as $m){
			$c .= "&#".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
	}
	return $c;
}

?>