<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form ActiveForm */

$this->title = 'import/export';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/paditransfer_add.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="paditransfer-add">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => Yii::t('app', 'ID')],
		 'inputOptions' => ['onchange' => 'onchange_id()', 'class' => 'form-control']
		 ]) ?>

		<label class="control-label"><?= Yii::t('app', 'Source Warehouse') ?></label>
		<?= Html::dropDownList('PadiTransfer[src_warehouse]', 'xm_padi', [
			'xm_padi' => get_warehouse_location('xm_padi'),
			'tw_padi' => get_warehouse_location('tw_padi'),
			'padi_sydney' => get_warehouse_location('padi_sydney'),
			], ['class' => 'form-control', 'id' => 'src_warehouse'])
		?>
		<div class="help-block"></div>

		<label class="control-label"><?= Yii::t('app', 'Destination Warehouse') ?></label>
		<?= Html::dropDownList('PadiTransfer[dst_warehouse]', 'xm_padi', [
			'xm_padi' => get_warehouse_location('xm_padi'),
			'tw_padi' => get_warehouse_location('tw_padi'),
			'padi_sydney' => get_warehouse_location('padi_sydney'),
			], ['class' => 'form-control', 'id' => 'dst_warehouse'])
		?>
		<div class="help-block"></div>

		<div class="form-group">
		<label class="control-label" for="order-date"><?= Yii::t('app', 'Date') ?></label>
		<?php
			echo DatePicker::widget([
				'name' => 'date',
				'value' => date("Y-m-d", strtotime('today')),
				'dateFormat' => 'MM/dd/yyyy',
			]);
		?>
		<div class="help-block"></div>
		</div>

		<label class="control-label"><?= Yii::t('app', 'Content') ?></label>
		<div style="margin-left: 50px">

		<label class="control-label"><?= Yii::t('app', 'By Box') ?></label>
		<div class="input_fields_wrap_packing">
			<button class="add_field_button_packing">+</button>
			<div>
				<select class="form-group" name="packing_0" id="packing_0" onchange="get_packing(this, 0)">
					<option value=""></option>
					<script>
					var packing = <?php echo json_encode($packing); ?>;
					var idx;
					for	(idx = 0; idx < packing.length; idx++) {
						document.write('<option value="');
						document.write(packing[idx]);
						document.write('">');
						document.write(packing[idx]);
						document.write('</option>');
					}
					</script>
				</select>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::t('app', 'qty per Box:') ?></label>
				<label id="label_qty_0"></label>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::t('app', 'Net Weight per Box:') ?></label>
				<label id="label_weight_0"></label>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::t('app', 'Measurement:') ?></label>
				<label id="label_measurement_0"></label>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::t('app', 'Number of Box:') ?></label>
				<?= Html::input('number', 'box_0', '0', ['id' => 'box_0', 'onchange' => 'box_hook(this.value, 0)']) ?>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::t('app', 'Total:') ?></label>
				<label id="label_total_0"></label>
			</div>
		</div>


		<label class="control-label"><?= Yii::t('app', 'By Mix') ?></label>
		<div class="input_fields_wrap_product">
			<button class="add_field_button_product">+</button>
			<div>
				<select class="form-group" name="product_0" id="product_0">
					<option value=""></option>
					<script>
					var product = <?php echo json_encode($product); ?>;
					var idx;
					for	(idx = 0; idx < product.length; idx++) {
						document.write('<option value="');
						document.write(product[idx]);
						document.write('">');
						document.write(product[idx]);
						document.write('</option>');
					}
					</script>
				</select>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::t('app', 'Qty:') ?></label>
				<?= Html::input('number', 'mix_0', '0', ['id' => 'mix_0']) ?>
			</div>
		</div>



<!--
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
	-->
		</div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => Yii::t('app', 'Remark')]])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- transfer-add -->
