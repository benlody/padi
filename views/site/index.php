<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '光隆庫存管理系統';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>光隆庫存管理系統</h1>

		<?php
			if(Yii::$app->user->isGuest){
				echo Html::a('登入系統', ['login'], ['class' => 'btn btn-lg btn-success']);
			} else {
				echo '<p class="lead">Welcome '.Yii::$app->user->identity->username.'</p>';
			}
		?>

    </div>

</div>
