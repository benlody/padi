<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_view', [
        'model' => $model,
    ]) ?>
