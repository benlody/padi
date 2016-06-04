<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PadiTransfer */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Padi Transfer',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Padi Transfers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="padi-transfer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
