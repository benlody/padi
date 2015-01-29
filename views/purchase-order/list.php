<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '生產列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="purchase-order-list">

	<?php
		if(0 == strcmp($status, 'done')){
			$subtitle = ' - 已完工';
			$btn_lable = '列出未完工';
			$btn_cfg = ['list', 'status' => '', 'detail' => $detail, 'sort' => $sort];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:編號',
					[
						'attribute' => 'content',
						'label' => '生產內容',
						'format' => 'raw',
						'value' => function ($model) {
							return product_content_to_table($model->content, true);
						}
					],
					'done_date:text:完工日期',
					[
						'attribute' => 'status',
						'label' => '狀態',
						'format' => 'raw',
						'value' => function ($model) {
							return get_puchase_order_status($model->status);
						}
					],
					[
						'attribute' => 'warehouse',
						'label' => '倉儲',
						'format' => 'raw',
						'value' => function ($model) {
							return get_warehouse_name($model->warehouse);
						}
					],
					'extra_info:text:備註',
					[
						'attribute' => '',
						'format' => 'raw',
						'value' => function ($model) {
							return '<a href="'.Yii::$app->request->getBaseUrl().'?r=purchase-order%2Fedit_only&amp;id='.urlencode($model->id).'" title="修改" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>';
						}
					],
				],
			];
		} else {
			$subtitle = ' - 未完工';
			$btn_lable = '列出已完工';
			$btn_cfg = ['list', 'status' => 'done', 'detail' => $detail, 'sort' => $sort];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:編號',
					[
						'attribute' => 'content',
						'label' => '生產內容',
						'format' => 'raw',
						'value' => function ($model) {
							return product_content_to_table($model->content);
						}
					],
					'date:text:日期',
					[
						'attribute' => 'status',
						'label' => '狀態',
						'format' => 'raw',
						'value' => function ($model) {
							return get_puchase_order_status($model->status);
						}
					],
					[
						'attribute' => 'warehouse',
						'label' => '倉儲',
						'format' => 'raw',
						'value' => function ($model) {
							return get_warehouse_name($model->warehouse);
						}
					],
					'extra_info:text:備註',
					[
						'attribute' => '',
						'format' => 'raw',
						'value' => function ($model) {
							return '<a href="'.Yii::$app->request->getBaseUrl().'?r=purchase-order%2Fedit&amp;id='.urlencode($model->id).'" title="完工入庫" data-pjax="0"><span class="glyphicon glyphicon glyphicon-ok"></span></a>'
								.'<a href="'.Yii::$app->request->getBaseUrl().'?r=purchase-order%2Fedit_only&amp;id='.urlencode($model->id).'" title="修改" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>'
								.'<a href="'.Yii::$app->request->getBaseUrl().'?r=purchase-order%2Fdelete&amp;id='.urlencode($model->id).'" title="刪除" data-confirm="確定要刪除'.$model->id.'嗎?"><span class="glyphicon glyphicon glyphicon-trash"></span></a>';
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
	<h1><?= Html::encode($this->title.$subtitle) ?></h1>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= Html::a($detail_btn_lable, $detail_btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>