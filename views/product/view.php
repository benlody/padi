<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

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

	<?php
		if(Yii::$app->user->identity->group <= User::GROUP_KL){
			$attributes = array(
				'id',
				'chinese_name:ntext',
				'english_name:ntext',
				'warning_cnt_tw',
				'warning_cnt_xm',
				'weight',
				'extra_info:ntext',
			);
		} else {
			$attributes = array(
				'id',
				'chinese_name:ntext',
				'english_name:ntext',
				'weight',
				'extra_info:ntext',
			);
		}

		echo DetailView::widget([
			'model' => $model,
			'attributes' => $attributes,
		]);
	?>

</div>
