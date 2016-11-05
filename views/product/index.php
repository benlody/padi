<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Product List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?php
			if(Yii::$app->user->identity->group <= User::GROUP_KL){
				echo Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']);
			}
		?>
	</p>

	<?php 
		if(Yii::$app->user->identity->group <= User::GROUP_KL){
			$columns = array(
				'id:text',
				'chinese_name:ntext',
				'english_name:ntext',
				'warning_cnt_tw:text',
				'warning_cnt_xm:text',
				'weight:text',
				'inv_price:text',
				'extra_info:ntext',
				[
					'class' => 'yii\grid\ActionColumn',
				],
			);
		} else {
			$columns = array(
				'id:text',
				'chinese_name:ntext',
				'english_name:ntext',
				'weight:text',
				'extra_info:ntext',
			);
		}
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $columns,
		]);
	?>

</div>
