<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Kuang Lung PADI Inventory');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= $this->title?></h1>

		<?php
			if(Yii::$app->user->isGuest){
				echo Html::a(Yii::t('app', 'Login'), ['login'], ['class' => 'btn btn-lg btn-success']);
			} else {
				echo '<p class="lead">Welcome '.Yii::$app->user->identity->username.'</p>';
			}
		?>

    </div>

</div>
