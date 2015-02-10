<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

require_once __DIR__  . '/../../utils/utils.php';
require_once __DIR__  . '/../../utils/enum.php';

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = '訂單出貨';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/order_edit.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>

<div class="order-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '訂單編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'date', ['labelOptions' => ['label' => '日期']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			],['readonly' => true])
		?>
		<?= $form->field($model, 'customer_id', ['labelOptions' => ['label' => '會員編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'chinese_addr')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'english_addr')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'region', ['labelOptions' => ['label' => '地區']])
					->dropDownList(ShippingRegion::getRegionList(),['readonly' => true]) ?>
		<?= $form->field($model, 'contact')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'tel')->textInput(['readonly' => true]) ?>

		<label class="control-label" for="order-content">訂單內容</label>
		<?= order_content_to_edit_table($model->toArray()['content']) ?>
		<div class="help-block"></div>

		<?= $form->field($model, 'ship_type', ['labelOptions' => ['label' => '運送方式']])->dropDownList(ShippingType::getType()) ?>

		<div class="form-group field-order-done_date">
		<label class="control-label" for="order-done_date">出貨日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'Order[done_date]',
				'value' => date("Y-m-d", strtotime('today')),
			]);
		?>
		<div class="help-block"></div>
		</div>		

		<div class="input_fields_wrap_ship">
			<label class="control-label">貨運</label>
			<button class="add_field_button_ship">+</button>
			<div>
			<p><b>
				Tracking Number:&nbsp;<input name="shipping_0" type="text" required/>
				&nbsp;&nbsp;&nbsp;包裝:&nbsp;<input name="packing_cnt_0" type="number" style="width:60px;" onchange="count_fee(0)" required/>
				<select name="packing_type_0">
					<option value="box">箱</option>
					<option value="pack">包</option>
				</select>&nbsp;&nbsp;&nbsp;重量:&nbsp;<input name="weight_0" type="number" step="0.01" style="width:100px;" onchange="count_fee(0)" required/>KG
				&nbsp;&nbsp;&nbsp;原始運費:&nbsp;<input name="shipping_fee_0" type="number" step="0.01" style="width:100px;" onchange="count_fee(0)" required/>
				&nbsp;&nbsp;&nbsp;請款運費:&nbsp;<input name="req_fee_0" type="number" step="0.01" style="width:100px;" required/>
			</b></p>
			</div>
		</div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>

		<?= Html::checkbox('send_padi', true) ?>
		<label>自動寄發通知信給PADI</label>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', '出貨'), ['class' => 'btn btn-primary', 'name' => 'done', 'onclick' => 'return check_missing()']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- order-edit -->
