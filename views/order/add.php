<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

require_once __DIR__  . '/../../utils/enum.php';

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = '新增訂單';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile($baseUrl.'/padi_dev/web/js/order_add.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>


	<?= $this->render('_form', [
		'model' => $model,
		'customer' => $customer,
		'crewpak' =>  $crewpak,
		'product' =>  $product
	]) ?>


<!-- order-add -->
