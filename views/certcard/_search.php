<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CertcardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certcard-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 't_send_date') ?>

    <?= $form->field($model, 'DHL') ?>

    <?= $form->field($model, 'tracking') ?>

    <?= $form->field($model, 'small_box') ?>

    <?php // echo $form->field($model, 's_recv_date') ?>

    <?php // echo $form->field($model, 'orig_fee') ?>

    <?php // echo $form->field($model, 'req_fee') ?>

    <?php // echo $form->field($model, 'extra_info') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
