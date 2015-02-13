<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Member List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?php
			if(Yii::$app->user->identity->group <= User::GROUP_KL){
				echo Html::a(Yii::t('app', 'Create Member'), ['create'], ['class' => 'btn btn-success']);
			}
		?>
	</p>

	<?php
		if(Yii::$app->user->identity->group <= User::GROUP_KL){
			$columns = array(
				'id:ntext',
				'chinese_name:ntext',
				'english_name:ntext',
				//'level',
				'contact:ntext',
				// 'tel:ntext',
				// 'email:ntext',
				'chinese_addr:ntext',
				'english_addr:ntext',
				//'region:ntext:地區',
				// 'extra_info:ntext',
				['class' => 'yii\grid\ActionColumn'],
			);
		} else {
			$columns = array(
				'id:ntext',
				'chinese_name:ntext',
				'english_name:ntext',
				//'level',
				'contact:ntext',
				// 'tel:ntext',
				// 'email:ntext',
				'chinese_addr:ntext',
				'english_addr:ntext',
				['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
			);
		}
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $columns,
		]); 
	?>

</div>
