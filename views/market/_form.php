<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Marketing */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/market_edit.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>

<div class="marketing-form">

	<?php $form = ActiveForm::begin(); ?>

	<div class="form-group">
	<label class="control-label" for="market-date">日期</label>
	<?php
		echo DatePicker::widget([
			'name' => 'date',
			'value' => date("Y-m-d", strtotime('today')),
			'dateFormat' => 'MM/dd/yyyy',
		]);
	?>
	<div class="help-block"></div>
	</div>

	<?php
		echo '<div class="input_fields_wrap_ship">';
			echo '<label class="control-label">行銷物</label>';
			echo '<button class="add_field_button_ship">+</button>';
			echo '<div>';
			echo '<p><b>';
				echo '內容:&nbsp;<input name="content_0" type="text" required/>';
				echo '&nbsp;&nbsp;&nbsp;Tracking Number:&nbsp;<input name="shipping_0" type="text" required/>';
				echo '</select>&nbsp;&nbsp;&nbsp;重量:&nbsp;<input name="weight_0" type="number" step="0.01" style="width:60px;" required/>KG';
				echo '</select>&nbsp;&nbsp;&nbsp;原始運費:&nbsp;<input name="orig_fee_0" type="number" step="0.01" style="width:60px;"  onchange="count_fee(0)"  required/>';
				echo '</select>&nbsp;&nbsp;&nbsp;請款運費:&nbsp;<input name="req_fee_0" type="number" step="0.01" style="width:60px;" required/>';
			echo '</b></p>';
			echo '</div>';
		echo '</div>';
	?>

	<?= $form->field($model, 'extra_info')->textarea(['rows' => 6]) ?>

	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
