<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Order;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '訂單列表';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/order_list.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="order-search">

	<?php $form = ActiveForm::begin(); ?>

	<label class="control-label">訂單編號</label>
	<?= Html::input('text', 'OrderSearch[id]', $search_param['id'], ['class' => 'form-control', 'id' => 'OrderSearch_id']) ?>
	<div class="help-block"></div>

	<label class="control-label">會員編號</label>
	<?= Html::input('text', 'OrderSearch[customer_id]', $search_param['customer_id'], ['class' => 'form-control', 'id' => 'OrderSearch_customer_id']) ?>
	<div class="help-block"></div>

	<label class="control-label">會員名稱</label>
	<?= Html::input('text', 'OrderSearch[customer_name]', $search_param['customer_name'], ['class' => 'form-control', 'id' => 'OrderSearch_customer_name']) ?>
	<div class="help-block"></div>

	<label class="control-label">地址</label>
	<?= Html::input('text', 'OrderSearch[addr]', $search_param['addr'], ['class' => 'form-control', 'id' => 'OrderSearch_addr']) ?>
	<div class="help-block"></div>

	<label class="control-label">產品內容</label>
	<?= Html::input('text', 'OrderSearch[content]', $search_param['content'], ['class' => 'form-control', 'id' => 'OrderSearch_content']) ?>
	<div class="help-block"></div>

	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary', 'name' => 'search']) ?>
	</div>

	<?php ActiveForm::end(); ?>

	<?php
		$config = [
			'dataProvider' => $dataProvider,
			'columns' => [
				'id:text:Order編號',
				'customer_id:text:會員編號',
				'customer_name:text:會員名稱',
				'date:text:日期',
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
						return order_content_to_table($model->content, $model->id);
					}
				],


				'chinese_addr:text:中文地址',
				'english_addr:text:英文地址',
				[
					'class' => 'yii\grid\ActionColumn', 'template' => '{view}'
				],
			],
		];

	?>
	<?php
		if(isset($dataProvider)){
			echo "<h1><?= Html::encode('搜尋結果') ?></h1>";
			echo GridView::widget($config);
		}
	?>

</div>