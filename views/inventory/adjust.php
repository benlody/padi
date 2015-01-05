<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Inventory';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile($baseUrl.'/padi_dev/web/js/inventory_adjust.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>

<div class="inventory-adjust">

	<?php $form = ActiveForm::begin(); ?>

		<label class="control-label">倉儲</label>
		<div>
		<?= Html::dropDownList('warehouse', 'xm', [
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			])
		?>
		<div class="help-block"></div>


		<?= Html::dropDownList('warehouse_type', 'xm', [
			'padi' => 'PADI庫存',
			'self' => '自有庫存',
			])
		?>
		<div class="help-block"></div>
		</div>

		<label class="control-label">調整內容</label>
		<div style="margin-left: 50px">

		<div class="input_fields_wrap_product">
			<label class="control-label">Product / 調整數量</label>
			<button class="add_field_button_product">+</button>
			<div>
				<select class="form-group" name="product_0">
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
				<label>/</label>
				<?= Html::input('number', 'product_cnt_0', '0') ?>
			</div>
		</div>

		<div class="help-block"></div>
		</div>

		<div>
		<label class="control-label">備註</label>
		<?= Html::textArea('extra_info', '', ['rows' => 6, 'class' => 'form-control']) ?>
		</div>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'adjust']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- inventory-adjust -->
