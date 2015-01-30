
<?php

use yii\helpers\Html;
use yii\grid\GridView;
require_once __DIR__  . '/../../utils/utils.php';

$this->title = Yii::t('app', '庫存總覽');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/inventory_overview.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>

<h1>庫存總覽</h1>

<?php

	$config = [
		'dataProvider' => $provider,
		'columns' => [
			'id:text:產品名稱',
			'padi:text:PADI庫存',
			'self:text:自有庫存',
		],
	];


?>
<div>
	<h2><? echo get_warehouse_name($warehouse).'&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d", strtotime('now')); ?></h2>
	<?php
		foreach (['xm', 'tw'] as $w) {
			echo Html::a(get_warehouse_name($w), ['overview',
				'warehouse' => $w,
			], ['class' => 'btn btn-primary']).'&nbsp;&nbsp;';
		}

	?>
	<?= Html::button('列印', ['class' => 'btn btn-success', 'onclick' => "PrintElem('#print', '".get_warehouse_name($warehouse).'&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d", strtotime('now'))."')"]) ?>
	<div id="print">
		<?= GridView::widget($config); ?>
	</div>
</div>

