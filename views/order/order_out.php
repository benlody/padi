<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>

<?php
	$total_fee = 0;
	$ship_out = '';
	foreach ($ship_array as $ship_info) {
		$ship_out = $ship_out.'&nbsp;&nbsp;&nbsp;&nbsp;Tracking No.: '.substr($ship_info['id'], 0, strpos($ship_info['id'], '_')).'<br>';
		$fee = isset($ship_info['req_fee']) ? $ship_info['req_fee'] : Fee::getShipFreightFee($ship_info['fee'], $region, $warehouse, $ship_info['type'], $ship_info['weight'], $ship_info['box']);
		$total_fee += $fee;
		$ship_out = $ship_out.'&nbsp;&nbsp;&nbsp;&nbsp;Freight Fee: '.$fee;
		$ship_out = $ship_out.((0 == strcmp('xm', $warehouse)) ? 'RMB<br>' : 'AUD<br>');
		$ship_out = $ship_out.'&nbsp;&nbsp;&nbsp;&nbsp;Packing: '.(isset($ship_info['box']) ? $ship_info['box'].'box' : $ship_info['pack'].'pack').'<br>';
		$ship_out = $ship_out.'&nbsp;&nbsp;&nbsp;&nbsp;Weight: '.$ship_info['weight'].'KG<br>';
		$ship_out = $ship_out.'<br>';
	}
?>

<?php
	$missing = '';
	$product_array = array();
	foreach ($content->product as $p => $detail) {
		if($detail->done === true){
			continue;
		} else if($detail->done){
			$product_array[$p] += ($detail->cnt - $detail->done);
		} else {
			$product_array[$p] += $detail->cnt;
		}
	}
	foreach ($content->crewpak as $c => $detail) {
		if($detail->done){
			continue;
		}
		foreach ($detail->detail as $p => $d) {
			if($d->done === true){
				continue;
			} else if($d->done){
				$product_array[$p] += ($d->cnt - $d->done);
			} else {
				$product_array[$p] += $d->cnt;
			}
		}
	}

	if (!empty($product_array)) {
		$title = '<p>Freight info and missing item as below:</p>';
		$missing = $missing.'<p>Missing items & Qty:</p>';
		$missing = $missing.'<p>';
		foreach ($product_array as $p => $cnt) {
			$missing = $missing.'&nbsp;&nbsp;&nbsp;&nbsp;'.$p.':'.$cnt.'<br>';
		}
		$missing = $missing.'</p>';
	} else {
		$title = '<p>Freight info as below:</p>';
	}

?>


<?= $title ?>
<p>warehouse: <b><?= $warehouse ?></b></p>
<p>PO#: <b><?= $order_id ?></b></p>
<p>DC#: <b><?= $customer_id ?>&nbsp;&nbsp;<?= $customer_name ?></b></p>
<p>Total Freight Fee: <b><?= $total_fee ?><? echo (0 == strcmp('xm', $warehouse)) ? 'RMB' : 'AUD'; ?></b></p>
<p>shipping info:</p>
<? echo $ship_out; ?>
<? echo $missing; ?>

