<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Purchase Order';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/purchase_order_add.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="purchase-order-add">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id') ?>
		<?= $form->field($model, 'date')->widget(DatePicker::className()) ?>
		<?= $form->field($model, 'warehouse')->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			])
		?>


		<div>

		<div class="input_fields_wrap_product">
			<label class="control-label">Product / 訂單數量 / 實印數量</label>
			<button class="add_field_button_product">+</button>
			<div>
				<select class="form-group" name="product_0">
					<option value='empty'></option>
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
				<?= Html::input('number', 'order_cnt_0', '0') ?>
				<label>/</label>
				<?= Html::input('number', 'print_cnt_0', '0') ?>
			</div>
		</div>

		<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'extra_info')->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- purchase-order-add -->
