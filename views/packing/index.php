<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PackingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Packings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packing-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?php
			if(Yii::$app->user->identity->group <= User::GROUP_KL){
				echo Html::a(Yii::t('app', 'Create Packing'), ['create'], ['class' => 'btn btn-success']);
			}
		?>
	</p>
	<?php 
		if(Yii::$app->user->identity->group <= User::GROUP_KL){
			$columns = array(
				'id',
				'qty',
				'net_weight:ntext',
				'measurement:ntext',
				[
					'class' => 'yii\grid\ActionColumn',
				],
			);
		} else {
			$columns = array(
				'id',
				'qty',
				'net_weight:ntext',
				'measurement:ntext',
			);
		}

		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $columns,
		]);

 	?>

</div>
