<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Inventory';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/inventory_adjust.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>

<div class="inventory-adjust">

	<script>
	var product = <?php echo json_encode($product); ?>;
	</script>

	<?php $form = ActiveForm::begin(); ?>

		<label class="control-label">倉儲</label>
		<div>
		<?= Html::dropDownList('warehouse', 'xm', [
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			], ['id' => 'warehouse',  'onchange' => "change_wh()"])
		?>
		<div class="help-block"></div>


		<?= Html::dropDownList('warehouse_type', 'xm', [
			'padi' => 'PADI庫存',
			'self' => '自有庫存',
			], ['id' => 'warehouse_type',  'onchange' => "change_wh()"])
		?>
		<div class="help-block"></div>
		</div>

		<label class="control-label">調整內容</label>
		<div style="margin-left: 50px">

		<div class="input_fields_wrap_product">
			<button class="add_field_button_product">+</button>
			<div>
				<select class="form-group" name="product_0" id="product_0" onchange="get_balance(this, 0)">
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
				<label>目前庫存餘額:</label>
				<label id="label_0"></label>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;增減:</label>
				<?= Html::input('number', 'change_0', '0', ['id' => 'change_0', 'onchange' => 'change_hook(this.value, 0)']) ?>
				<label>&nbsp;&nbsp;&nbsp;&nbsp;調整為:</label>
				<?= Html::input('number', 'product_cnt_0', '0', ['id' => 'product_cnt_0', 'onchange' => 'balance_hook(this.value, 0)']) ?>
			</div>
		</div>

		<div class="help-block"></div>
		</div>

		<div>
		<label class="control-label">備註</label>
		<?= Html::textArea('extra_info', '', ['rows' => 6, 'class' => 'form-control']) ?>
		</div>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'adjust', 'onclick' => 'return validate()']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- inventory-adjust -->
