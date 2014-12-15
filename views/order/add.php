<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Order';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('//code.jquery.com/jquery-1.10.2.js',['position' => yii\web\View::POS_BEGIN]);
$this->registerJsFile('//code.jquery.com/ui/1.11.2/jquery-ui.js',['position' => yii\web\View::POS_BEGIN]);
$this->registerCssFile("//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css",['position' => yii\web\View::POS_BEGIN]);
$this->registerCssFile("//jqueryui.com/resources/demos/style.css",['position' => yii\web\View::POS_BEGIN]);
$this->registerCssFile("css/custom-combobox.css",['position' => yii\web\View::POS_BEGIN]);
$this->registerJsFile('js/custom-combox.js',['position' => yii\web\View::POS_BEGIN]);
$this->registerJsFile('js/crew_product_field.js',['position' => yii\web\View::POS_BEGIN]);
?>

<div class="order-add">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id') ?>
		<?= $form->field($model, 'date')->widget(DatePicker::className()) ?>
		<?= $form->field($model, 'ship_type')->dropDownList([
			'標準快遞',
			'順丰特惠',
			'物流普運'])
		?>

		<div class="form-group field-order-customer_id required">
			<label class="control-label" for="order-customer_id">Customer ID</label><br>
			<select id="combobox" >
				<option value="none"></option>
				<script>
				var customer = <?php echo json_encode($customer); ?>;
				var idx;
				for	(idx = 0; idx < customer.length; idx++) {
					document.write('<option value="');
					document.write(customer[idx]);
					document.write('">');
					document.write(customer[idx]);
					document.write('</option>');
				}
				</script>
			</select>
			<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'chinese_addr') ?>
		<?= $form->field($model, 'english_addr') ?>
		<?= $form->field($model, 'contact') ?>
		<?= $form->field($model, 'tel') ?>
		<?= $form->field($model, 'content') ?>

		<label class="control-label" for="order-content">Content</label>
		<div style="margin-left: 50px">

		<div class="input_fields_wrap_crewpak">
			<label class="control-label">Crew-Pak</label>
			<button class="add_field_button_crewpak">+</button>
			<div>
				<select class="form-group" name="crew_pak_0">
					<option value=""></option>
					<script>
					var crewpak = <?php echo json_encode($crewpak); ?>;
					var idx;
					for	(idx = 0; idx < crewpak.length; idx++) {
						document.write('<option value="');
						document.write(crewpak[idx]);
						document.write('">');
						document.write(crewpak[idx]);
						document.write('</option>');
					}
					</script>
				</select>
				<?= Html::input('number', 'crew_pak_cnt_0', '0') ?>
			</div>
		</div>

		<div class="input_fields_wrap_product">
			<label class="control-label">Product</label>
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
				<?= Html::input('number', 'product_cnt_0', '0') ?>
			</div>
		</div>

		<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'extra_info')->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- order-add -->
