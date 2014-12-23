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

	<h1><?= Html::encode(get_warehouse_name($warehouse.'_'.$type)) ?></h1>
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
					'type' => $type,
				]).'">'.date("Y-m", strtotime("now -".$i." month")).'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		echo '<br>';

		foreach (['padi', 'self'] as $t) {
			foreach (['xm', 'tw'] as $w) {
				echo Html::a(get_warehouse_name($w.'_'.$t), ['transaction',
						'from' => $from,
						'to' => $to,
						'warehouse' => $w,
						'type' => $t,
					], ['class' => 'btn btn-primary']).'&nbsp;&nbsp;';
			}
		}
	?>

	<p><?= '<br><br>'.Html::encode('總覽') ?></p>

	<?= transaction_to_table($start_balance, $end_balance, $transaction, $product)?>

	<?php
		foreach ($crew_list as $crewpak_id => $crewpak_product) {
			echo '<p><br><br>'.Html::encode($crewpak_id).'</p>';
			echo transaction_to_table($start_balance, $end_balance, $transaction, $crewpak_product);
		}





	?>
