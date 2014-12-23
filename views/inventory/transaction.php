<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inventory');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/yii/basic/web/js/jquery.stickyheader.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/yii/basic/web/js/transaction_table.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/yii/basic/web/css/transaction_table_component.css');

?>

<?= transaction_to_table($start_balance, $end_balance, $transaction, $product)?>

