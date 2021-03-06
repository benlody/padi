<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inventory');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/jquery.stickyheader.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/transaction_table.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->getBaseUrl().'/css/transaction_table_component.css');

?>

	<h1><?= Html::encode('訂單統計') ?></h1>
	<div class='summry'>

		Form <b><?= $from?></b> to <b><?= $to?></b><br>

	</div>

	<?php
		for($i = 0; $i < 6; $i++){
			echo '<a href="'.Yii::$app->request->getBaseUrl().'?'.http_build_query([
					'r' => Yii::$app->request->getQueryParam('r'),
					'from' => date("Y-m-d", strtotime("first day of this month -".$i." month")),
					'to' => date("Y-m-d", strtotime("last day of this month -".$i." month")),
					'warehouse' => $warehouse,
				]).'">'.date("Y-m", strtotime("now -".$i." month")).'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		echo '<br>';

		echo Html::a('下載PADI訂單統計', ['stat_download',
				'from' => $from,
				'to' => $to,
			], ['class' => 'btn btn-success']).'&nbsp;&nbsp;';
	?>

	<?= orders_to_statistics_table($orders, $from, $to)?>
