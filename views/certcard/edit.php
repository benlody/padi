<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Transfer;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form ActiveForm */

$this->title = 'CertCard';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="certcard-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'tracking', ['labelOptions' => ['label' => '順豐單號']])->textInput(['readonly' => true]) ?>

		<?= $form->field($model, 'small_box', ['labelOptions' => ['label' => 'small box']])->textInput(['type' => "number"]) ?>

		<div class="form-group">
		<label class="control-label">日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'Certcard[s_recv_date]',
				'value' => date("Y-m-d", strtotime('today')),
				'dateFormat' => 'MM/dd/yyyy',
			]);
		?>
		<div class="help-block"></div>
		</div>


		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', '已寄達'), ['class' => 'btn btn-primary', 'id' => 'btn_submit', 'name' => 'done']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- transfer-add -->
