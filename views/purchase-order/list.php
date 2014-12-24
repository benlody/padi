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

	<?php
		if(0 == strcmp($status, 'done')){
			$btn_lable = '列出未完工';
			$btn_cfg = ['list', 'status' => '', 'detail' => $detail, 'sort' => $sort];
			$config = [
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
					'done_date:text:完工日期',
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
				],
			];
		} else {
			$btn_lable = '列出已完工';
			$btn_cfg = ['list', 'status' => 'done', 'detail' => $detail, 'sort' => $sort];
			$config = [
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
			];
		}
		if($detail){
			$detail_btn_lable = '隱藏詳細';
			$detail_btn_cfg = ['list', 'status' => $status, 'detail' => false, 'sort' => $sort];
		} else {
			$detail_btn_lable = '顯示詳細';
			$detail_btn_cfg = ['list', 'status' => $status, 'detail' => true, 'sort' => $sort];
			unset($config['columns'][1]);
		}
	?>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= Html::a($detail_btn_lable, $detail_btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>