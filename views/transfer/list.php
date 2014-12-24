<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transfer');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transfer-list">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php
		//FIXME 選擇是否顯示內容
		if(0 == strcmp($status, 'done')){
			$btn_lable = '列出未完成列表';
			$btn_cfg = ['list', 'status' => '', 'detail' => $detail, 'sort' => $sort];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:編號',
					'send_date:text:轉出日期',
					'recv_date:text:轉入日期',
					[
						'attribute' => 'status',
						'format' => 'raw',
						'label' => '狀態',
						'value' => function ($model) {
							return get_transfer_status($model->status);
						}
					],
					[
						'attribute' => 'src_warehouse',
						'format' => 'raw',
						'label' => '轉出倉儲',
						'value' => function ($model) {
							return get_warehouse_name($model->src_warehouse);
						}
					],
					[
						'attribute' => 'dst_warehouse',
						'format' => 'raw',
						'label' => '轉入倉儲',
						'value' => function ($model) {
							return get_warehouse_name($model->dst_warehouse);
						}
					],
					[
						'attribute' => 'content',
						'format' => 'raw',
						'label' => '轉移內容',
						'value' => function ($model) {
							return transfer_content_to_table($model->content);
						}
					],
					'extra_info:text:備註',
				],
			];
		} else {
			$btn_lable = '列出已完成列表';
			$btn_cfg = ['list', 'status' => 'done', 'detail' => $detail, 'sort' => $sort];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:編號',
					'send_date:text:轉出日期',
					'recv_date:text:轉入日期',
					[
						'attribute' => 'status',
						'format' => 'raw',
						'label' => '狀態',
						'value' => function ($model) {
							return get_transfer_status($model->status);
						}
					],
					[
						'attribute' => 'src_warehouse',
						'format' => 'raw',
						'label' => '轉出倉儲',
						'value' => function ($model) {
							return get_warehouse_name($model->src_warehouse);
						}
					],
					[
						'attribute' => 'dst_warehouse',
						'format' => 'raw',
						'label' => '轉入倉儲',
						'value' => function ($model) {
							return get_warehouse_name($model->dst_warehouse);
						}
					],
					[
						'attribute' => 'content',
						'format' => 'raw',
						'label' => '轉移內容',
						'value' => function ($model) {
							return transfer_content_to_table($model->content);
						}
					],
					'extra_info:text:備註',
					[
						'attribute' => '',
						'format' => 'raw',
						'value' => function ($model) {
							return '<a href="/yii/basic/web/index.php?r=transfer%2Fedit&amp;id='.$model->id.'" title="Edit" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>';
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
			unset($config['columns'][6]);
		}
	?>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= Html::a($detail_btn_lable, $detail_btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>