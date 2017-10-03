<?php

namespace app\controllers;

use Yii;
use app\models\Marketing;
use app\models\MarketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Log;
use app\models\User;
use yii\db\Query;

require_once __DIR__  . '/../utils/ship_download.php';

/**
 * MarketController implements the CRUD actions for Marketing model.
 */
class MarketController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all Marketing models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new MarketSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Marketing model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Marketing model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Marketing();
		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){
			$post_param['date'] = date("Y-m-d", strtotime($post_param['date']));

			$x = 0;
			while(1){
				$model = new Marketing();

				$content_idx = "content_".$x;
				$shipping_idx = "shipping_".$x;
				$packing_cnt_idx = "packing_cnt_".$x;
				$weight_idx = "weight_".$x;
				$orig_fee_idx = "orig_fee_".$x;
				$req_fee_idx = "req_fee_".$x;

				if(!isset($post_param[$shipping_idx])){
					break;
				}

				if(0 == strcmp($post_param[$shipping_idx], "")){
					$x++;
					continue;
				}

				$model->tracking = preg_replace('/\s(?=)/', '', $post_param[$shipping_idx]);
				$model->weight = $post_param[$weight_idx];
				$model->orig_fee = $post_param[$orig_fee_idx];
				$model->req_fee = $post_param[$req_fee_idx];
				$model->content = $post_param[$content_idx];
				$model->date = $post_param['date'];
				$model->extra_info = $post_param['Marketing']['extra_info'];

				$model->insert();

				$x++;
			}


			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Add market ['.$model->id.']';
			$log->insert();

			return $this->redirect(['index']);

		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Marketing model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Marketing model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionBill($from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$post_param = Yii::$app->request->post();

		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		if($post_param['chose_from']){
			$from = $post_param['chose_from'];
		}
		if($post_param['chose_to']){
			$to = $post_param['chose_to'];
		}

		$marketing = $query->select('*')
						->from('marketing')
						->where('date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('date ASC')
						->all();

		return $this->render('bill' ,[
			'from' => $from,
			'to' => $to,
			'marketing' => $marketing,
		]);
	}

	public function actionBill_download($from='', $to='')
	{
		if(Yii::$app->user->identity->group > User::GROUP_KL){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$query = new Query;
		if(!$from){
			$from = date("Y-m-d", strtotime("first day of this month"));
		}
		if(!$to){
			$to = date("Y-m-d", strtotime("last day of this month"));
		}

		$marketing = $query->select('*')
						->from('marketing')
						->where('date BETWEEN  "'.$from.'" AND "'.$to.'"')
						->orderBy('date ASC')
						->all();

		market_bill_download($marketing, $from, $to);
	}


	/**
	 * Finds the Marketing model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Marketing the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Marketing::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
