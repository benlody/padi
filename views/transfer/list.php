<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Transfer;
require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '庫存轉移列表');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transfer-list">

	<?php
		if(0 == strcmp($status, 'done')){
			$subtitle = ' - 已完成';
			$btn_lable = '列出未完成列表';
			$btn_cfg = ['list', 'status' => '', 'detail' => $detail, 'sort' => '-send_date'];
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
						'attribute' => 'ship_type',
						'format' => 'raw',
						'label' => '運送方式',
						'value' => function ($model) {
							return ShippingType::getTransferShippingType($model->ship_type);
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
			$subtitle = ' - 未完成';
			$btn_lable = '列出已完成列表';
			$btn_cfg = ['list', 'status' => 'done', 'detail' => $detail, 'sort' => '-recv_date'];
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
						'attribute' => 'ship_type',
						'format' => 'raw',
						'label' => '運送方式',
						'value' => function ($model) {
							return ShippingType::getTransferShippingType($model->ship_type);
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
							if(Transfer::STATUS_NEW == $model->status){
								$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=transfer%2Fedit&amp;id='.urlencode($model->id).'" title="出貨" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=transfer%2Fdelete&amp;id='.urlencode($model->id).'" title="刪除" data-confirm="確定要刪除'.$model->id.'嗎?"><span class="glyphicon glyphicon glyphicon-trash"></span></a>'.
									'<a href="'.Yii::$app->request->getBaseUrl().'?r=transfer%2Fdownload&amp;id='.urlencode($model->id).'" title="下載出貨單" data-pjax="0"><span class="glyphicon glyphicon glyphicon-download"></span></a>';
							} else if (Transfer::STATUS_ONTHEWAY == $model->status) {
								$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=transfer%2Fedit&amp;id='.urlencode($model->id).'" title="貨到入庫" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>';
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
			unset($config['columns'][7]);
		}
	?>
	<h1><?= Html::encode($this->title.$subtitle) ?></h1>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= Html::a($detail_btn_lable, $detail_btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>