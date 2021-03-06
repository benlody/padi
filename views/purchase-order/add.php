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

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '生產編號']]) ?>

		<div class="form-group field-order-date">
		<label class="control-label" for="order-date">日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'PurchaseOrder[date]',
				'value' => date("Y-m-d", strtotime('today')),
				'dateFormat' => 'MM/dd/yyyy',
			]);
		?>
		<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			])
		?>

		<div>

		<div class="input_fields_wrap_product">
			<label class="control-label">產品名稱 / 原始訂單數量 / 預計生產數量</label>
			<div>
				<select required class="form-group" name="product">
					<option value=''></option>
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
				<?= Html::input('number', 'order_cnt', '0') ?>
				<label>/</label>
				<?= Html::input('number', 'print_cnt', '0') ?>
			</div>
		</div>

		<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- purchase-order-add -->
