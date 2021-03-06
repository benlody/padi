<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
require_once __DIR__  . '/../../utils/enum.php';

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?php
			if(Yii::$app->user->identity->group <= User::GROUP_KL){
				echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
				echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
					'class' => 'btn btn-danger',
					'data' => [
						'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
						'method' => 'post',
					],
				]);
			}
		?>
	</p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'chinese_name:ntext',
			'english_name:ntext',
			'level',
			'contact:ntext',
			'tel:ntext',
			'email:ntext',
			'chinese_addr:ntext',
			'english_addr:ntext',
			[
				'attribute' => 'region',
				'value' => ShippingRegion::getRegion($model->region)
			],
			'extra_info:ntext',
		],
	]) ?>

</div>
