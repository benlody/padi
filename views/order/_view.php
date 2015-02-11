<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

require_once __DIR__  . '/../../utils/utils.php';
require_once __DIR__  . '/../../utils/enum.php';

?>


<div class="product-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
					'id:text:訂單編號',
					'customer_id:text:會員編號',
					'customer_name:text:會員名稱',
					'date:text:日期',
					'done_date:text:出庫日期',
					'chinese_addr:text:中文地址',
					'english_addr:text:英文地址',
					[
						'label' => '地區',
						'format' => 'raw',
						'value' => ShippingRegion::getRegion($model->region)
					],
					'contact:text:聯絡人',
					'tel:text:電話',
					[
						'label' => '狀態',
						'format' => 'raw',
						'value' => get_order_status($model->status)
					],
					[
						'label' => '倉儲',
						'format' => 'raw',
						'value' => get_warehouse_name($model->warehouse)
					],
					[
						'label' => '訂單內容',
						'format' => 'raw',
						'value' => order_content_to_table($model->content)
					],
					[
						'label' => '運送方式',
						'format' => 'raw',
						'value' => ShippingType::getShippingType($model->ship_type)
					],
					[
						'label' => '貨運資訊',
						'format' => 'raw',
						'value' => shipping_info_to_table($model->shipping_info)
					],
					'extra_info:text:備註',
		],
	]) ?>

</div>