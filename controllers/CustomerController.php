<?php

namespace app\controllers;
use app\models\Customer;
use Yii;


class CustomerController extends \yii\web\Controller
{
	public function actionAdd()
	{
		return $this->render('add');
	}

	public function actionAjaxGet()
	{
		$post_param = Yii::$app->request->post();
		$customer = Customer::find()
			->where(['id' => $post_param["customer_id"]])
			->asArray()
			->one();

		return json_encode($customer,JSON_FORCE_OBJECT);
	}

	public function actionDelete()
	{
		return $this->render('delete');
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

}
