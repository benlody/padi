<?php

use app\models\Order;
use app\models\PurchaseOrder;

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
		case 'tw':
			$name = '台灣光隆';
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

function order_content_to_table($content){
	$table_out = '<div id="w0" class="grid-view"><table class="table table-striped table-bordered"><thead><tr><th>產品編號</th><th>數量</th></tr></thead><tbody>';

	$content_array = json_decode($content);

	$table_out = $table_out.'<tr><td>套裝</td><td></td></tr>';
	$crewpak_array = $content_array->crewpak;
	foreach ($crewpak_array as $key => $value) {
		$table_out = $table_out.'<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
	}

	$table_out = $table_out.'<tr><td>單品</td><td></td></tr>';
	$product_array = $content_array->product;
	foreach ($product_array as $key => $value) {
		$table_out = $table_out.'<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
	}
	$table_out = $table_out.'</tbody></table></div>';


	return $table_out;
}


function get_order_status($status){
		switch($status){
		case Order::STATUS_NEW:
			$ret = '未出貨';
			break;
		case Order::STATUS_DONE:
			$ret = '已完出貨';
			break;
		default:
			$ret = $status;
	}
	return $ret;
}



?>