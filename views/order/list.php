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
			$btn_cfg = ['list', 'status' => '', 'detail' => $detail, 'sort' => $sort];
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
			$btn_cfg = ['list', 'status' => 'done', 'detail' => $detail, 'sort' => $sort];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:訂單編號',
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
							return 	'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fedit&amp;id='.$model->id.'" title="Edit" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fdownload&amp;id='.$model->id.'" title="Edit" data-pjax="0"><span class="glyphicon glyphicon glyphicon-download"></span></a>';
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
			unset($config['columns'][5]);
		}

	?>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= Html::a($detail_btn_lable, $detail_btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>