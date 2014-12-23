<?php

use app\models\Order;
use app\models\PurchaseOrder;
use app\models\Transfer;
use app\models\Product;
use app\models\CrewPak;
use yii\db\Query;

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
			$name = '廈門卡樂兒';
			break;
		case 'xm_padi':
			$name = '廈門卡樂兒PADI庫存';
			break;
		case 'xm_self':
			$name = '廈門卡樂兒自有庫存';
			break;
		case 'tw':
			$name = '台灣光隆';
			break;
		case 'tw_padi':
			$name = '台灣光隆PADI庫存';
			break;
		case 'tw_self':
			$name = '台灣光隆自有庫存';
			break;
		case 'sydney':
			$name = '雪梨PADI';
			break;
		default:
			$name = $warehouse_id;
	}
	return $name;
}

function product_content_to_table($content){
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>品名</th><th>訂單數量</th><th>實印數量</th></tr></thead><tbody>';
	$content_array = json_decode($content);
	foreach ($content_array as $key => $value) {
		$table_out = $table_out.'<tr><td>'.$key.'</td><td>'.$value->order_cnt.'</td><td>'.$value->print_cnt.'</td></tr>';
	}
	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}

function transfer_content_to_table($content){
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>品名</th><th>數量</th></tr></thead><tbody>';
	$content_array = json_decode($content);
	foreach ($content_array as $key => $value) {
		$table_out = $table_out.'<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
	}
	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}

function order_content_to_table($content){
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>產品編號</th><th>產品名稱</th><th>數量</th><th>出貨狀態</th></tr></thead><tbody>';

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

	$table_out = '<tr><td>'.$crewpak_name.'</td><td>'.crewpak_detail_to_edit_table($crewpak_name, $crewpak_detail->detail).'</td><td>'.$crewpak_detail->cnt.'</td><td>'.get_checkbox($crewpak_detail->done, 'crewpak['.$crewpak_name.']', $crewpak_name, 'crewpak').'</td></tr>';
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

	$table_out = '<tr><td>'.$product_name.'</td><td>'.get_product_name($product_name).'</td><td>'.$product_detail->cnt.'</td><td>'.get_checkbox($product_detail->done, $name, $id, 'product').'</td></tr>';
	return $table_out;
}



function get_product_name($id){
	$product = Product::find()
		->where(['id' => $id])
		->one();

	return $product->chinese_name;
}

function get_crewpk_name($id){
	$crewpak = CrewPak::find()
		->where(['id' => $id])
		->one();

	return $crewpak->chinese_name;
}

function get_check_icon($checked){
	if($checked){
		return '<span class="glyphicon glyphicon glyphicon-ok"></span>';
	} else {
		return '';
	}
}

function get_checkbox($checked, $name, $id, $class){
	if($checked){
		return '<span class="glyphicon glyphicon glyphicon-ok"></span>';
	} else if(0 == strcmp($class, 'product')){
		return '<input type="checkbox" name="'.$name.'" class="product_'.$id.' product" data-target=".crewpak_'.$id.'" data-sibling=".product_'.$id.'">';
	} else {
		return '<input type="checkbox" name="'.$name.'" class="crewpak_'.$id.' crewpak" data-target=".product_'.$id.'">';
	}
}

function get_order_status($status){
		switch($status){
		case Order::STATUS_NEW:
			$ret = '未完成出貨';
			break;
		case Order::STATUS_DONE:
			$ret = '已完成出貨';
			break;
		default:
			$ret = $status;
	}
	return $ret;
}

function get_transfer_status($status){
		switch($status){
		case Transfer::STATUS_NEW:
			$ret = '尚未寄達';
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
		$row = '<tr><th>'.$trans['date'].'</th><th>'.$trans['serial'].'</th><th>'.$trans['serial'].'</th>';
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


/*
	$content_array = json_decode($content);
	foreach ($content_array as $key => $value) {
		$table_out = $table_out.'<tr><td>'.$key.'</td><td>'.$value->order_cnt.'</td><td>'.$value->print_cnt.'</td></tr>';
	}
*/
	$table_out = $table_out.'</tbody></table></div>';

	return $table_out;
}



?>