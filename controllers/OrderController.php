<?php

namespace app\controllers;

use app\models\Order;
use app\models\CrewPak;
use app\models\Product;
use app\models\Customer;
use Yii;

class OrderController extends \yii\web\Controller
{
	public function actionAdd()
	{
		
		$model = new Order;
		$customer = new Customer();
		$crewpak = new CrewPak();
		$product = new Product();

		return $this->render('add', [
			'model' => $model,
			'customer' => $customer->find()->column(),
			'crewpak' =>  $crewpak->find()->column(),
			'product' =>  $product->find()->column()
		]);
	}

	public function actionDelete()
	{
		return $this->render('delete');
	}

	public function actionGet()
	{
		return $this->render('get');
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

}
