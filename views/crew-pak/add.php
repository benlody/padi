<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'CrewPak';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>crew-pak/add</h1>

<p>
	You may change the content of this page by modifying
	the file <code><?= __FILE__; ?></code>.
</p>

<div class="row">
	<div class="col-lg-5">
		<?php $form = ActiveForm::begin(['id' => 'crew-pak']); ?>

			<?= $form->field($model, 'id') ?>
			<?= $form->field($model, 'chinese_name') ?>
			<?= $form->field($model, 'english_name') ?>



			<!--  FIXME  -->

			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_0', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_0', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_1', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_1', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_2', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_2', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_3', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_3', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_4', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_4', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_5', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_5', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_6', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_6', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_7', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_7', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_8', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_8', '0') ?>
			</div>
			<div class="col-lg-offset-0 col-lg-20">
				<?= Html::dropDownList('product_9', '', array_merge([''], $product)) ?>
				<?= Html::input('number', 'cnt_9', '0') ?>
			</div>

			<div class="form-group">
				<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
