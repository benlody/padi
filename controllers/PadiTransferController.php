<?php

namespace app\controllers;

use Yii;
use app\models\PadiTransfer;
use app\models\PadiTransferSearch;
use app\models\Product;
use app\models\Packing;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Log;

require_once __DIR__  . '/../utils/utils.php';
require_once __DIR__  . '/../utils/paditransfer_download.php';

/**
 * PadiTransferController implements the CRUD actions for PadiTransfer model.
 */
class PadiTransferController extends Controller
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
		if(Yii::$app->user->identity->group > User::GROUP_PADI){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$model = new PadiTransfer;
		$product = new Product();
		$packing = new Packing();

		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){

			$post_param['PadiTransfer']['content'] = json_encode($this->get_content($post_param), JSON_FORCE_OBJECT);
			$post_param['PadiTransfer']['date'] = date("Y-m-d", strtotime($post_param['date']));

			foreach ($post_param['PadiTransfer'] as $key => $value) {
				$model->$key = $value;
			}
			$model->insert();

			$log = new Log();
			$log->username = Yii::$app->user->identity->username;
			$log->action = 'Add padiTransfer ['.$model->id.']';
			$log->insert();


			return $this->redirect(['list', 'sort' => '-date']);

		} else {
			return $this->render('add', [
				'model' => $model,
				'product' =>  $product->find()->column(),
				'packing' =>  $packing->find()->column()
			]);
		}
	}



	public function actionList($sort='-date')
	{

		if(Yii::$app->user->identity->group > User::GROUP_PADI){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$searchModel = new PadiTransferSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('list', [
			'dataProvider' => $dataProvider,
			'sort' => $sort,
		]);

	}

	/**
	 * Lists all PadiTransfer models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PadiTransferSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single PadiTransfer model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new PadiTransfer model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new PadiTransfer();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing PadiTransfer model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
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
	 * Deletes an existing PadiTransfer model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionDownload($id)
	{
		if(Yii::$app->user->identity->group > User::GROUP_PADI){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

//		$query = new Query;
		$model = $this->findModel($id);
		$content_array = json_decode($model->content, true);
//		print_r($content_array);
	$packings = $content_array['packing'];
	$mixs = $content_array['mix'];
//	print_r($packings);
//	print_r($mixs);

		paditransfer_download($model->id, $model->content, $model->src_warehouse, $model->dst_warehouse, $model->date);
	}



	/**
	 * Finds the PadiTransfer model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return PadiTransfer the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = PadiTransfer::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	protected function get_content($post_param){


		$packing_content = array();
		$mix_content = array();

		$x = 0;

		while(1){

			$packing_idx = "packing_".$x;
			$packing_cnt_idx = "box_".$x;

			if(!isset($post_param[$packing_idx])){
				break;
			}

			if(0 == strcmp($post_param[$packing_idx], "")){
				$x++;
				continue;
			}

			$packing_cnt = $post_param[$packing_cnt_idx];

			if(0 >= $packing_cnt){
				$x++;
				continue;
			}
			$packing_id =  $post_param[$packing_idx];
			$packing_info = get_packing($packing_id);
			$packing_content[$packing_id]['cnt'] += $packing_cnt;
			$packing_content[$packing_id]['qty'] = $packing_info['qty'];
			$packing_content[$packing_id]['net_weight'] = $packing_info['net_weight'];
			$packing_content[$packing_id]['measurement'] = $packing_info['measurement'];
			$packing_content[$packing_id]['chinese_name'] = $packing_info['chinese_name'];
			$packing_content[$packing_id]['english_name'] = $packing_info['english_name'];
			$packing_content[$packing_id]['id'] = $packing_id;

			$x++;
		}

		$x = 0;

		while(1){

			$mix_idx = "product_".$x;
			$mix_cnt_idx = "mix_".$x;

			if(!isset($post_param[$mix_idx])){
				break;
			}

			if(0 == strcmp($post_param[$mix_idx], "")){
				$x++;
				continue;
			}

			$mix_cnt = $post_param[$mix_cnt_idx];

			if(0 >= $mix_cnt){
				$x++;
				continue;
			}

			$mix_id =  $post_param[$mix_idx];				
			$mix_info = get_mix($mix_id);

			$mix_content[$mix_id]['cnt'] += $mix_cnt;
			$mix_content[$mix_id]['id'] = $mix_id;
			$mix_content[$mix_id]['chinese_name'] = $mix_info['chinese_name'];
			$mix_content[$mix_id]['english_name'] = $mix_info['english_name'];

			$x++;
		}

		$content['packing'] = $packing_content;
		$content['mix'] = $mix_content;

		return $content;
	}


}
