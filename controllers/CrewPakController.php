<?php

namespace app\controllers;

use app\models\CrewPak;
use app\models\Product;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use Yii;
use app\models\User;
use yii\web\NotFoundHttpException;

class CrewPakController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
	public function actionAdd()
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$model = new CrewPak;
		$product = new Product();

		$product_col = $product->find()->column();

		$post_param = Yii::$app->request->post();

		// FIXME:  check same name
		// FIXME:  check must hase value
		// FIXME: use dynamic

		if($post_param["CrewPak"]){
			for ($x = 0; $x < 16; $x++)  {
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
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		return $this->render('delete');
	}

	public function actionGet()
	{
		return $this->render('get');
	}

	public function actionIndex()
	{

		$query = new Query;
		$product = Product::find()->column();

		$crewpak = $query->select('*')
						->from('crew_pak')
						->all();
		$crew_list = array();

		foreach ($crewpak as $c) {
			$content = array();
			foreach ($product as $p) {
				if(0 != $c[$p]){
					$content[$p] = $c[$p];
				}
			}

			$crew['id'] = $c['id'];
			$crew['extra_info'] = $c['extra_info'];
			$crew['content'] = $content;
			array_push($crew_list, $crew);

		}

		$provider = new ArrayDataProvider([
		    'allModels' => $crew_list,
		    'sort' => [
		        'attributes' => ['id'],
		    ],
		    'pagination' => [
		        'pageSize' => 50,
		    ],
		]);

		return $this->render('index', [
			'dataProvider' => $provider,
		]);

	}

	public function actionAjaxList()
	{
		$crewpak = new CrewPak();

		return json_encode($crewpak->find()->column(), JSON_FORCE_OBJECT);
	}

}
