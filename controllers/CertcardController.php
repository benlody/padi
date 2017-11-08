<?php

namespace app\controllers;

use Yii;
use app\models\Certcard;
use app\models\CertcardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Log;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;


/**
 * CertcardController implements the CRUD actions for Certcard model.
 */
class CertcardController extends Controller
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

	/**
	 * Lists all Certcard models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new CertcardSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Certcard model.
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
	 * Creates a new Certcard model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){

			$post_param['Certcard']['t_send_date'] = date("Y-m-d", strtotime($post_param['Certcard']['t_send_date']));

			$x = 0;
			while(1){
				$model = new Certcard();

				$shipping_idx = "shipping_".$x;
				$orig_fee_idx = "orig_fee_".$x;
				$req_fee_idx = "req_fee_".$x;

				if(!isset($post_param[$shipping_idx])){
					break;
				}

				if(0 == strcmp($post_param[$shipping_idx], "")){
					$x++;
					continue;
				}

				$model->DHL = $post_param['Certcard']['DHL'];
				$model->tracking = $post_param[$shipping_idx];
				$model->orig_fee = $post_param[$orig_fee_idx];
				$model->req_fee = $post_param[$req_fee_idx];
				$model->t_send_date = $post_param['Certcard']['t_send_date'];
				$model->extra_info = $post_param['Certcard']['extra_info'];

				$model->insert();

				$x++;
			}

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Add CertCard ['.$model->DHL.']';
			$log->insert();

			return $this->redirect(['list', 'sort' => '-t_send_date']);

		} else {
			$model = new Certcard();
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	public function actionList($status='', $sort='-t_send_date')
	{

		$searchModel = new CertcardSearch();
		if(0 == strcmp($status, 'done')){
			$query = CertcardSearch::find();
			$query->Where('s_recv_date is not null');

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);
		} else {
			$query = CertcardSearch::find();
			$query->Where('s_recv_date is null');

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);
		}

		return $this->render('list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'status' => $status,
			'sort' => $sort,
		]);
	}

	public function actionEdit($id)
	{
//		if(Yii::$app->user->identity->group > User::GROUP_KL){
//			throw new NotFoundHttpException('The requested page does not exist.');
//		}
		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();


		if(isset($post_param['done'])){

			$post_param['Certcard']['s_recv_date'] = date("Y-m-d", strtotime($post_param['Certcard']['s_recv_date']));
			foreach ($post_param['Certcard'] as $key => $value) {
				$model->$key = $value;
			}
			$model->update();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Receive CertCard ['.$model->tracking.']';
			$log->insert();


			return $this->redirect(['list', 'sort' => '-t_send_date']);

		} else {

			return $this->render('edit', [
				'model' => $model,
			]);
		}
	}
	
	/**
	 * Updates an existing Certcard model.
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
	 * Deletes an existing Certcard model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['list', 'sort' => '-t_send_date']);
	}

	/**
	 * Finds the Certcard model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Certcard the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Certcard::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
