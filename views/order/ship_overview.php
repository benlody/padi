<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

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

	<h1><?= Html::encode(get_warehouse_name($warehouse).' - 出貨明細') ?></h1>
	<div class='summry'>

		Form <b><?= $from?></b> to <b><?= $to?></b><br>

	</div>

	<?php $form = ActiveForm::begin(); ?>

		<div class="form-group field-from">
		<label class="control-label" for="from">From</label>
		<?php
			echo DatePicker::widget([
				'name' => 'chose_from',
				'value' => $from,
				'dateFormat' => 'yyyy-MM-dd',

			]);
		?>
		<label class="control-label" for="to">To</label>
		<?php
			echo DatePicker::widget([
				'name' => 'chose_to',
				'value' => $to,
				'dateFormat' => 'yyyy-MM-dd',
			]);

		?>
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'ship_overview']) ?>
		</div>
		</div>

	<?php ActiveForm::end(); ?>

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

		echo Html::a('下載PADI運費請款單', ['ship_download',
				'from' => $from,
				'to' => $to,
				'warehouse' => $warehouse,
			], ['class' => 'btn btn-success']).'&nbsp;&nbsp;';

		if($warehouse == 'xm'){
			echo Html::a('下載金璽服務費報價單', ['ship_download_service',
					'from' => $from,
					'to' => $to,
					'warehouse' => $warehouse,
				], ['class' => 'btn btn-success']).'&nbsp;&nbsp;';
		}

		if($warehouse == 'tw'){
			echo Html::a('下載台灣運費對帳單', ['match',
					'from' => $from,
					'to' => $to,
					'warehouse' => 'tw',
				], ['class' => 'btn btn-success']).'&nbsp;&nbsp;';
			echo Html::a('下載台灣進出口明細', ['download_customs',
					'from' => $from,
					'to' => $to,
					'warehouse' => 'tw',
				], ['class' => 'btn btn-success']).'&nbsp;&nbsp;';
		}

		echo Html::a('下載KPI報表', ['download_kpi',
				'from' => $from,
				'to' => $to,
				'warehouse' => $warehouse,
			], ['class' => 'btn btn-success']).'&nbsp;&nbsp;';


/*
		if($warehouse == 'tw'){
			echo Html::a('下載光隆運費對帳單', ['match',
					'from' => $from,
					'to' => $to,
					'warehouse' => $warehouse,
				], ['class' => 'btn btn-success']).'&nbsp;&nbsp;';
		}
*/
		foreach (['xm', 'tw'] as $w) {
			echo Html::a(get_warehouse_name($w), ['ship_overview',
					'from' => $from,
					'to' => $to,
					'warehouse' => $w,
				], ['class' => 'btn btn-primary']).'&nbsp;&nbsp;';
		}
	?>

	<?= orders_to_shipment_table($orders, $warehouse, $from, $to)?>
