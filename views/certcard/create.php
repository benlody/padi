<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Certcard */

$this->title = Yii::t('app', '潛水認證卡', [
    'modelClass' => 'Certcard',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Certcards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certcard-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
