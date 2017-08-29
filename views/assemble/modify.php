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
<div class="assemble-order-add">

	<?php $form = ActiveForm::begin(); ?>

		<label class="control-label"><?= $assemble_order_model->id ?></label>

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
				<label class="control-label"><?= $assemble_order_model->assemble ?></label>
				<label>/</label>
				<?= Html::input('number', 'AssembleOrder[qty]', $assemble_order_model->qty) ?>
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
