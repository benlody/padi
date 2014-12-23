<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form ActiveForm */

$this->title = 'Transfer';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/yii/basic/web/js/transfer_add.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="transfer-add">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '編號']]) ?>

		<label class="control-label">來源倉儲</label>
		<div>
		<?= Html::dropDownList('Transfer[src_warehouse]', 'xm_padi', [
			'xm_padi' => '廈門卡樂兒PADI庫存',
			'xm_self' => '廈門卡樂兒自有庫存',
			'tw_padi' => '台灣光隆PADI庫存',
			'tw_self' => '台灣光隆自有庫存',
			'sydney' => '雪梨PADI',
			], ['class' => 'form-control'])
		?>
		<div class="help-block"></div>

		<label class="control-label">目的倉儲</label>
		<div>
		<?= Html::dropDownList('Transfer[dst_warehouse]', 'xm_padi', [
			'xm_padi' => '廈門卡樂兒PADI庫存',
			'xm_self' => '廈門卡樂兒自有庫存',
			'tw_padi' => '台灣光隆PADI庫存',
			'tw_self' => '台灣光隆自有庫存',
			'sydney' => '雪梨PADI',
			], ['class' => 'form-control'])
		?>
		<div class="help-block"></div>


		<div class="form-group">
		<label class="control-label" for="order-date">日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'date',
				'value' => date("Y-m-d", strtotime('today')),
			]);
		?>
		<div class="help-block"></div>
		</div>


		<label class="control-label">內容</label>
		<div style="margin-left: 50px">

		<div class="input_fields_wrap_product">
			<label class="control-label">Product / 數量</label>
			<button class="add_field_button_product">+</button>
			<div>
				<select class="form-group" name="product_0">
					<option value=""></option>
					<script>
					var product = <?php echo json_encode($product); ?>;
					var idx;
					for (idx = 0; idx < product.length; idx++) {
						document.write('<option value="');
						document.write(product[idx]);
						document.write('">');
						document.write(product[idx]);
						document.write('</option>');
					}
					</script>
				</select>
				<label>/</label>
				<?= Html::input('number', 'product_cnt_0', '0') ?>
			</div>
		</div>
		</div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- transfer-add -->