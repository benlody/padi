<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Order;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '訂單列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="order-list">


	<?php


		if(0 == strcmp($status, 'done')){
			$subtitle = ' - 已出貨';
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
					[
						'attribute' => '',
						'format' => 'raw',
						'value' => function ($model) {
								$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fview&amp;id='.urlencode($model->id).'" title="檢視" data-pjax="0"><span class="glyphicon glyphicon glyphicon-eye-open"></span></a>';
							return $opt;
						}
					],
				],
			];
		} else {
			$subtitle = ' - 未完成出貨';
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
							if(Order::STATUS_NEW == $model->status){
								$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fmodify&amp;id='.urlencode($model->id).'" title="修改" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fdelete&amp;id='.urlencode($model->id).'" title="刪除" data-confirm="確定要刪除'.$model->id.'嗎?"><span class="glyphicon glyphicon glyphicon-trash"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fdownload&amp;id='.urlencode($model->id).'" title="下載出貨單" data-pjax="0"><span class="glyphicon glyphicon glyphicon-download"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Freview&amp;id='.urlencode($model->id).'" title="覆核" data-pjax="0"><span class="glyphicon glyphicon glyphicon-eye-open"></span></a>';
							} else if (Order::STATUS_PROCESSING == $model->status){
								$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fedit&amp;id='.urlencode($model->id).'" title="出貨" data-pjax="0"><span class="glyphicon glyphicon glyphicon-ok"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fdownload&amp;id='.urlencode($model->id).'" title="下載出貨單" data-pjax="0"><span class="glyphicon glyphicon glyphicon-download"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fview&amp;id='.urlencode($model->id).'" title="檢視" data-pjax="0"><span class="glyphicon glyphicon glyphicon-eye-open"></span></a>';
							}
							return $opt;
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
	<h1><?= Html::encode($this->title.$subtitle) ?></h1>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= Html::a($detail_btn_lable, $detail_btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>