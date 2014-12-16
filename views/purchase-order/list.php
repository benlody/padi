<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Purchase Orders');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/yii/basic/web/js/util.js');




?>
<div class="purchase-order-list">

	<h1><?= Html::encode($this->title) ?></h1>

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
					return get_warehouse_name($model->status);
				}
			],
			'extra_info',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>