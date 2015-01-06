<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<p>倉儲:<?= $warehouse?></p>
<p>訂單:<?= $order_id?>出貨後 以下商品數量已低於安全庫存量</p>

<?php

	foreach ($warning as $product => $cnt) {
		echo '<p>商品名稱:'.$product.'<br>';
		echo '安全庫存量:'.$cnt['warning_cnt'].'<br>';
		echo '現有數量:'.$cnt['balance'].'</p>';
	}

?>
