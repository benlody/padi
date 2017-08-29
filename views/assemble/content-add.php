<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Assemble';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/assemble_content_add.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="assemble-add">

	<?php $form = ActiveForm::begin(); ?>

		<div class="form-group">


			<label class="control-label">組裝產品名稱</label>
			<div>
				<select class="form-group" name="Assemble[id]">
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
			</div>

		<?php
			$content = json_decode($model->content, true);
		?>
		<script>
			var product = <?php echo json_encode($product); ?>;
		</script>

		<div class="input_fields_wrap_product">
			<label class="control-label">單品</label>
			<button class="add_field_button_product">+</button>
			<?php
				echo '<div>';
				echo '<select class="form-group" name="product_0">';
				echo '<option value=""></option>';
				foreach ($product as $p) {
					echo '<option value="'.$p.'">'.$p.'</option>';
				}
				echo '</select>';
				echo Html::input('number', 'product_cnt_0', '0');
				echo '</div>';
			?>
		</div>


		<div class="help-block"></div>

		</div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div>
