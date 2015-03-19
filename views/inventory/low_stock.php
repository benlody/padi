
<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
require_once __DIR__  . '/../../utils/utils.php';

$this->title = Yii::t('app', 'Low Stock Items');
$this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/inventory_overview.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>

<h1><?= Yii::t('app', 'Low Stock Items')?></h1>

<?php

	$config = [
		'dataProvider' => $provider,
		'columns' => [
			'id:text:'.Yii::t('app', 'Product No.'),
			[
				'attribute' => 'padi',
				'format' => 'raw',
				'label' => Yii::t('app', 'Balance'),
				'value' => function ($model) {
					if($model['safety'] > $model['padi']){
						return '<font color="red">'.$model['padi'].'</font>';
					} else {
						return $model['padi'];
					}
				}
			],
			'safety:text:'.Yii::t('app', 'Safety Stock'),
		],
	];

	$config_c = [
		'dataProvider' => $provider_c,
		'columns' => [
			'id:text:'.Yii::t('app', 'Crew-Pak No.'),
			[
				'format' => 'raw',
				'label' => Yii::t('app', 'Crew-Pak Content'),
				'value' => function ($model) {
					return crewpak_index_to_table($model['id'], $model['content']);
				}
			],
			[
				'format' => 'raw',
				'label' => Yii::t('app', 'Low Stock Content'),
				'value' => function ($model) {
					foreach ($model['low'] as $low) {
						$low_itmes .= $low.', ';
					}
					return $low_itmes;
				}
			],
		],
	];


?>
<div>
	<h2><? echo get_warehouse_name($warehouse).'&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d", strtotime('now')); ?></h2>
	<?php
		if(Yii::$app->user->identity->group != User::GROUP_XM){
			foreach (['xm', 'tw'] as $w) {
				echo Html::a(get_warehouse_name($w), ['low_stock',
					'warehouse' => $w,
				], ['class' => 'btn btn-primary']).'&nbsp;&nbsp;';
			}
		}

	?>
	<h3><?= Yii::t('app', 'Product')?></h3>
	<?= GridView::widget($config); ?>
	<h3><?= Yii::t('app', 'Crew-Pak')?></h3>
	<?= GridView::widget($config_c); ?>
</div>

