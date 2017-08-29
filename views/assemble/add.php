<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Assemble Order';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/assemble_order_add.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="purchase-order-add">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($assemble_order_model, 'id', ['labelOptions' => ['label' => '編號']]) ?>

		<div class="form-group field-order-date">
		<label class="control-label" for="order-date">日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'AssembleOrder[date]',
				'value' => date("Y-m-d", strtotime('today')),
			]);
		?>
		<div class="help-block"></div>
		</div>

		<?= $form->field($assemble_order_model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			])
		?>

		<div>

		<div class="input_fields_wrap_assemble">
			<label class="control-label">組裝套裝名稱 / 數量</label>
			<div>
				<select class="form-group" name="AssembleOrder[assemble]">
					<option value='empty'></option>
					<script>
					var assemble = <?php echo json_encode($assemble); ?>;
					var idx;
					for	(idx = 0; idx < assemble.length; idx++) {
						document.write('<option value="');
						document.write(assemble[idx]);
						document.write('">');
						document.write(assemble[idx]);
						document.write('</option>');
					}
					</script>
				</select>
				<label>/</label>
				<?= Html::input('number', 'AssembleOrder[qty]', '0') ?>
			</div>
		</div>

		<div class="help-block"></div>
		</div>

		<?= $form->field($assemble_order_model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- purchase-order-add -->
