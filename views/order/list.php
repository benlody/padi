<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="order-list">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php
		//FIXME 選擇是否顯示訂單內容
		if(0 == strcmp($status, 'done')){
			$btn_lable = '列出未出貨';
			$btn_cfg = ['list', 'status' => ''];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:Order編號',
					'customer_id:text:會員編號',
					'done_date:text:出貨日期',
					[
						'attribute' => 'status',
						'format' => 'raw',
						'label' => '狀態',
						'value' => function ($model) {
							return get_order_status($model->status);
						}
					],
					[
						'attribute' => 'warehouse',
						'format' => 'raw',
						'label' => '倉儲',
						'value' => function ($model) {
							return get_warehouse_name($model->warehouse);
						}
					],
					[
						'attribute' => 'content',
						'format' => 'raw',
						'label' => '訂單內容',
						'value' => function ($model) {
							return order_content_to_table($model->content);
						}
					],
					'extra_info:text:備註',
				],
			];
		} else {
			$btn_lable = '列出已出貨';
			$btn_cfg = ['list', 'status' => 'done'];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:Order編號',
					'customer_id:text:會員編號',
					'date:text:日期',
					[
						'attribute' => 'status',
						'format' => 'raw',
						'label' => '狀態',
						'value' => function ($model) {
							return get_order_status($model->status);
						}
					],
					[
						'attribute' => 'warehouse',
						'format' => 'raw',
						'label' => '倉儲',
						'value' => function ($model) {
							return get_warehouse_name($model->warehouse);
						}
					],
					[
						'attribute' => 'content',
						'format' => 'raw',
						'label' => '訂單內容',
						'value' => function ($model) {
							return order_content_to_table($model->content);
						}
					],
					'extra_info:text:備註',
					[
						'attribute' => '',
						'format' => 'raw',
						'value' => function ($model) {
							return '<a href="/yii/basic/web/index.php?r=order%2Fedit&amp;id='.$model->id.'" title="Edit" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>';
						}
					],
				],
			];
		}
	?>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>