<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
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

	<h1><?= Html::encode(get_warehouse_name($warehouse.'_'.$type)) ?></h1>
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
		<?php

			echo '<div>';
			echo '<label class="control-label" for="from">Choose a Product:  </label>';
			echo '<select class="form-group" name="single_product">';
			echo '<option value="'.$single_product.'" selected>'.$single_product.'</option>';
			foreach ($product as $p) {
				echo '<option value="'.$p.'">'.$p.'</option>';
			}
			echo '</select>';
			echo '</div>';
		?>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'transaction']) ?>
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
					'type' => $type,
				]).'">'.date("Y-m", strtotime("now -".$i." month")).'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		echo '<br>';

		foreach (['padi', 'self'] as $t) {
			foreach (['xm', 'tw'] as $w) {

				if(Yii::$app->user->identity->group == User::GROUP_XM && $w != 'xm'){
					continue;
				}

				if(Yii::$app->user->identity->group == User::GROUP_PADI && $t != 'padi'){
					continue;
				}

				echo Html::a(get_warehouse_name($w.'_'.$t), ['transaction',
						'from' => $from,
						'to' => $to,
						'warehouse' => $w,
						'type' => $t,
					], ['class' => 'btn btn-primary']).'&nbsp;&nbsp;';
			}
		}
	?>


	<?php
		foreach ($crew_list as $crewpak_id => $crewpak_product) {
			echo '<p><br><br>'.Html::encode($crewpak_id).'</p>';
			echo transaction_to_table($start_balance, $end_balance, $transaction, $crewpak_product);
		}
	?>

	<p><?= '<br>'.Html::encode('總覽') ?></p>

	<?= transaction_to_table($start_balance, $end_balance, $transaction, $product)?>

