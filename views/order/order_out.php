<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<p>Freight and missing item as below:</p>
<p>warehouse: <?= $warehouse?></p>
<p>PO#: <?= $order_id?></p>
<p>shipping info:</p>

<?php
	foreach ($ship_array as $ship_info) {
		echo '&nbsp;&nbsp;&nbsp;&nbsp;Tracking No.: '.substr($ship_info['id'], 0, strpos($ship_info['id'], '_')).'<br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;Freight Fee: '.Fee::getShipFreightFee($ship_info['fee'], $region, $warehouse, $ship_info['type'], $ship_info['weight']);
		echo (0 == strcmp('xm', $warehouse)) ? 'RMB<br>' : 'AUD<br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;Packing: '.(isset($ship_info['box']) ? $ship_info['box'].'box' : $ship_info['pack'].'pack').'<br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;Weight: '.$ship_info['weight'].'KG<br>';
		echo '<br>';
	}
?>


<?php
	$product_array = array();
	foreach ($content->product as $p => $detail) {
		if($detail->done){
			continue;
		}
		$product_array[$p] += $detail->cnt;
	}
	foreach ($content->crewpak as $c => $detail) {
		if($detail->done){
			continue;
		}
		foreach ($detail->detail as $p => $d) {
			if($d->done){
				continue;
			}
			$product_array[$p] += $d->cnt;
		}
	}

	if (!empty($product_array)) {
		echo '<p>Missing items & Qty:</p>';
		echo '<p>';
		foreach ($product_array as $p => $cnt) {
			echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$p.':'.$cnt.'<br>';
		}
		echo '</p>';
	}

?>

