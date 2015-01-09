<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '產品列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '新增產品', [
    'modelClass' => 'Product',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id:text:產品編號',
            'chinese_name:ntext:中文名稱',
            'english_name:ntext:英文名稱',
            'warning_cnt_tw:text:台灣安全庫存量',
            'warning_cnt_xm:text:廈門安全庫存量',
            'weight:text:重量(克)',
            'extra_info:ntext:備註',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
