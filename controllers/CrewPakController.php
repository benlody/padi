<?php

namespace app\controllers;

use app\models\CrewPak;
use app\models\Product;
use Yii;

class CrewPakController extends \yii\web\Controller
{
	public function actionAdd()
	{
		$model = new CrewPak;
		$product = new Product();

		$product_col = $product->find()->column();

		$post_param = Yii::$app->request->post();

		// FIXME:  check same name
		// FIXME:  check must hase value
		// FIXME: use dynamic

		if($post_param["CrewPak"]){
			for ($x = 0; $x < 10; $x++)  {
				$cnt_idx = "cnt_".$x;
				$product_idx = "product_".$x;

				if($post_param[$cnt_idx] > 0){
					$product_list[$post_param[$product_idx]] = $post_param[$cnt_idx];
					$post_param['CrewPak'][$post_param[$product_idx]] = $post_param[$cnt_idx];
				}
			}

			foreach ($post_param['CrewPak'] as $key => $value) {
				$model->$key = $value;
			}

			$model->insert();
			return $this->redirect(['index']);

		} else {
			return $this->render('add', [
				'model' => $model,
				'product' => $product_col,
			]);

		}

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

	public function actionAjaxList()
	{
		$crewpak = new CrewPak();

		return json_encode($crewpak->find()->column(), JSON_FORCE_OBJECT);
	}

}
