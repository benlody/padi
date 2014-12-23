<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'chinese_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'english_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'level')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'chinese_addr')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'english_addr')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'extra_info')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
