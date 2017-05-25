<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Product',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="product-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <?//= $form->field($model, 'id', ['labelOptions' => ['label' => '產品編號']])->textInput(['maxlength' => 64]) ?>

	    <?= $form->field($model, 'chinese_name', ['labelOptions' => ['label' => '中文名稱']])->textInput() ?>

	    <?= $form->field($model, 'english_name', ['labelOptions' => ['label' => '英文名稱']])->textInput() ?>

	    <?= $form->field($model, 'warning_cnt_xm', ['labelOptions' => ['label' => '廈門安全庫存量']])->textInput() ?>

	    <?= $form->field($model, 'warning_cnt_tw', ['labelOptions' => ['label' => '台灣安全庫存量']])->textInput() ?>

	    <?= $form->field($model, 'weight', ['labelOptions' => ['label' => '重量(克)']])->textInput() ?>

	    <?= $form->field($model, 'inv_price', ['labelOptions' => ['label' => '發票價格']])->textInput() ?>
	   
	    <?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>

	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '新增') : Yii::t('app', '儲存'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>
