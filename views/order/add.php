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
?>


<div class="order-add">

	<?php $form = ActiveForm::begin(); ?>



		<?= $form->field($model, 'id') ?>
		<?= $form->field($model, 'date')->widget(DatePicker::className()) ?>
		<?= $form->field($model, 'ship_type') ?>

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
		<?= $form->field($model, 'extra_info') ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- order-add -->
