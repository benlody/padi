
<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
require_once __DIR__  . '/../../utils/utils.php';

$this->title = Yii::t('app', 'Inventory Overview');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/inventory_overview.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>

<h1><?= Yii::t('app', 'Inventory Overview')?></h1>

<?php

	if(Yii::$app->user->identity->group == User::GROUP_PADI){
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
	} else {
		$config = [
			'dataProvider' => $provider,
			'columns' => [
				'id:text:'.Yii::t('app', 'Product No.'),
				[
					'attribute' => 'padi',
					'format' => 'raw',
					'label' => Yii::t('app', 'PADI Balance'),
					'value' => function ($model) {
						if($model['safety'] > $model['padi']){
							return '<font color="red">'.$model['padi'].'</font>';
						} else {
							return $model['padi'];
						}
					}
				],
				'self:text:'.Yii::t('app', 'Self Balance'),
				'safety:text:'.Yii::t('app', 'Safety Stock'),
			],
		];
	}



?>
<div>
	<h2><? echo get_warehouse_name($warehouse).'&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d", strtotime('now')); ?></h2>
	<?php
		if(Yii::$app->user->identity->group != User::GROUP_XM){
			foreach (['xm', 'tw'] as $w) {
				echo Html::a(get_warehouse_name($w), ['overview',
					'warehouse' => $w,
				], ['class' => 'btn btn-primary']).'&nbsp;&nbsp;';
			}
		}

	?>
	<?= Html::button(Yii::t('app', 'Print'), ['class' => 'btn btn-success', 'onclick' => "PrintElem('#print', '".get_warehouse_name($warehouse).'&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d", strtotime('now'))."')"]) ?>
	<div id="print">
		<?= GridView::widget($config); ?>
	</div>
</div>

