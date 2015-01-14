<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<p>Warehouse:<?= $warehouse?></p>
<p>The following product current balance is lower than Safty count after order <?= $order_id?> delivery:</p>

<?php

	foreach ($warning as $product => $cnt) {
		echo '<p>Product:'.$product.'<br>';
		echo 'Safty count:'.$cnt['warning_cnt'].'<br>';
		echo 'Current balance:'.$cnt['balance'].'</p>';
	}

?>
