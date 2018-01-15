<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Order;
use app\models\User;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '組裝列表';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="assemble-order-list">


	<?php
		if(0 == strcmp($status, 'done')){
			$subtitle = ' - 已完工';
			$btn_lable = '列出未完工';
			$btn_cfg = ['list', 'status' => '', 'detail' => $detail, 'sort' => '-date'];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:編號',
					'assemble:text:組裝內容',
					'qty:text:數量',
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
/*
					[
						'attribute' => '',
						'format' => 'raw',
						'value' => function ($model) {
							return '<a href="'.Yii::$app->request->getBaseUrl().'?r=assemble%2Forder-edit_only&amp;id='.urlencode($model->id).'" title="修改" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>';
						}
					],
*/
				],
			];
		} else {
			$subtitle = ' - 未完工';
			$btn_lable = '列出已完工';
			$btn_cfg = ['list', 'status' => 'done', 'detail' => $detail, 'sort' => '-done_date'];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'id:text:編號',
					'assemble:text:組裝內容',
					'qty:text:數量',
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
							return '<a href="'.Yii::$app->request->getBaseUrl().'?r=assemble%2Forder-edit&amp;id='.urlencode($model->id).'" title="完工入庫" data-pjax="0"><span class="glyphicon glyphicon glyphicon-ok"></span></a>'
								.'<a href="'.Yii::$app->request->getBaseUrl().'?r=assemble%2Forder-modify&amp;id='.urlencode($model->id).'" title="修改" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>'
								.'<a href="'.Yii::$app->request->getBaseUrl().'?r=assemble%2Forder-download&amp;id='.urlencode($model->id).'" title="下載組裝單" data-pjax="0"><span class="glyphicon glyphicon glyphicon-download"></span></a>'
								.'<a href="'.Yii::$app->request->getBaseUrl().'?r=assemble%2Forder-delete&amp;id='.urlencode($model->id).'" title="刪除" data-confirm="確定要刪除'.$model->id.'嗎?"><span class="glyphicon glyphicon glyphicon-trash"></span></a>';
						}
					],
				],
			];
		}
	?>
	<h1><?= Html::encode($this->title.$subtitle) ?></h1>
	<?//= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?php
		if(Yii::$app->user->identity->group <= User::GROUP_KL){
			echo Html::a(Yii::t('app', 'Add Assemble'), ['add'], ['class' => 'btn btn-success']);
		}
	?>
	<?= GridView::widget($config); ?>

</div>