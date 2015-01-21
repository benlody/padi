
<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', '工作訂單統計');
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>工作訂單統計</h1>

<?php

$xm_config = [
	'dataProvider' => $xm_provider,
	'columns' => [
		'id:text:產品名稱',
		'order_cnt:text:待出貨數量',
		'trans_src_cnt:text:待轉出數量',
		'trans_dst_cnt:text:待轉入數量',
		'po_cnt:text:生產中數量',
		'balance:text:目前餘額',
	],
];
$tw_config = [
	'dataProvider' => $tw_provider,
	'columns' => [
		'id:text:產品名稱',
		'order_cnt:text:待出貨數量',
		'trans_src_cnt:text:待轉出數量',
		'trans_dst_cnt:text:待轉入數量',
		'po_cnt:text:生產中數量',
		'balance:text:目前餘額',
	],
];

?>
<div>
	<h2>廈門</h2>
	<?= GridView::widget($xm_config); ?>
</div>
<div>
	<h2>台灣</h2>
	<?= GridView::widget($tw_config); ?>
</div>

