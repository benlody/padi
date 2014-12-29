<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'CrewPak';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
	<div class="col-lg-5">
		<?php $form = ActiveForm::begin(['id' => 'crew-pak']); ?>

			<?= $form->field($model, 'id') ?>
			<?= $form->field($model, 'chinese_name') ?>
			<?= $form->field($model, 'english_name') ?>

			<?php
				$option['empty'] = '';
				foreach ($product as $key => $value) {
					$option[$value] = $value;
				}


			?>

			<!--  FIXME  -->

			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_0', '', $option) ?>
				<?= Html::input('number', 'cnt_0', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_1', '', $option) ?>
				<?= Html::input('number', 'cnt_1', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_2', '', $option) ?>
				<?= Html::input('number', 'cnt_2', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_3', '', $option) ?>
				<?= Html::input('number', 'cnt_3', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_4', '', $option) ?>
				<?= Html::input('number', 'cnt_4', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_5', '', $option) ?>
				<?= Html::input('number', 'cnt_5', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_6', '', $option) ?>
				<?= Html::input('number', 'cnt_6', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_7', '', $option) ?>
				<?= Html::input('number', 'cnt_7', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_8', '', $option) ?>
				<?= Html::input('number', 'cnt_8', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_9', '', $option) ?>
				<?= Html::input('number', 'cnt_9', '0') ?>
			</div>

			<div class="form-group">
				<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
