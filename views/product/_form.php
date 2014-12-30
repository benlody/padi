<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'chinese_name')->textInput() ?>

    <?= $form->field($model, 'english_name')->textInput() ?>

    <?= $form->field($model, 'warning_cnt_xm')->textInput(['value' => 0]) ?>

    <?= $form->field($model, 'warning_cnt_tw')->textInput(['value' => 0]) ?>

    <?= $form->field($model, 'extra_info')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
