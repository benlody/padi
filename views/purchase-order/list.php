<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Purchase Orders');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="purchase-order-list">

	<h1><?= Html::encode($this->title) ?></h1>


	<!--  FIXME switch done and working PO  -->
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'id',
			[
				'attribute' => 'content',
				'format' => 'raw',
				'value' => function ($model) {
					return product_content_to_table($model->content);
				}
			],
			'date',
			[
				'attribute' => 'status',
				'format' => 'raw',
				'value' => function ($model) {
					return get_puchase_order_status($model->status);
				}
			],
			[
				'attribute' => 'warehouse',
				'format' => 'raw',
				'value' => function ($model) {
					return get_warehouse_name($model->warehouse);
				}
			],
			'extra_info',
			[
				'attribute' => '',
				'format' => 'raw',
				'value' => function ($model) {
					return '<a href="/yii/basic/web/index.php?r=purchase-order%2Fedit&amp;id='.$model->id.'" title="Edit" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>';
				}
			],
		],
	]); ?>

</div>