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

?>
<div class="assemble-order-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($assemble_order_model, 'id', ['labelOptions' => ['label' => '編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($assemble_order_model, 'date', ['labelOptions' => ['label' => '日期']])->textInput(['readonly' => true]) ?>
		<?= $form->field($assemble_order_model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			], ['readonly' => true])
		?>

		<div class="form-group field-assembleorder-done_date">
		<label class="control-label" for="assembleorder-done_date">完工日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'AssembleOrder[done_date]',
				'value' => date("Y-m-d", strtotime('today')),
				'dateFormat' => 'MM/dd/yyyy',
			]);
		?>
		<div class="help-block"></div>
		</div>		

		<?= $form->field($assemble_order_model, 'assemble', ['labelOptions' => ['label' => '組裝套裝名稱']])->textInput(['readonly' => true]) ?>
		<?= $form->field($assemble_order_model, 'qty', ['labelOptions' => ['label' => '數量']])->textInput(['readonly' => true]) ?>

		
		<?= $form->field($assemble_order_model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>

		<div class="form-group">
			<?= Html::submitButton('完工入庫', ['class' => 'btn btn-primary', 'name' => 'done']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- assemble-order-edit -->
