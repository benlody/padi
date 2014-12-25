<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

require_once __DIR__  . '/../../utils/enum.php';

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id', ['labelOptions' => ['label' => '編號']])->textInput() ?>

    <?= $form->field($model, 'chinese_name', ['labelOptions' => ['label' => '中文名稱']])->textInput() ?>

    <?= $form->field($model, 'english_name', ['labelOptions' => ['label' => '英文名稱']])->textInput() ?>

    <?= $form->field($model, 'level', ['labelOptions' => ['label' => 'Level']])->textInput() ?>

    <?= $form->field($model, 'contact', ['labelOptions' => ['label' => '聯絡人']])->textInput() ?>

    <?= $form->field($model, 'tel', ['labelOptions' => ['label' => '電話']])->textInput() ?>

    <?= $form->field($model, 'email', ['labelOptions' => ['label' => 'email']])->textInput() ?>

    <?= $form->field($model, 'chinese_addr', ['labelOptions' => ['label' => '中文地址']])->textInput() ?>

    <?= $form->field($model, 'english_addr', ['labelOptions' => ['label' => '英文地址']])->textInput() ?>

    <?= $form->field($model, 'region', ['labelOptions' => ['label' => '地區']])->dropDownList(ShippingRegion::getRegionList()) ?>

    <?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
