<?php

namespace app\controllers;

use Yii;
use app\models\Log;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
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

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->identity->group > User::GROUP_KL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $log = new Log();
            $log->username = Yii::$app->user->identity->username;
            $log->action = 'Add Customer ['.$model->id.']';
            $log->insert();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->identity->group > User::GROUP_KL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $log = new Log();
            $log->username = Yii::$app->user->identity->username;
            $log->action = 'Update Customer ['.$model->id.']';
            $log->insert();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->identity->group > User::GROUP_KL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->findModel($id)->delete();
        $log = new Log();
        $log->username = Yii::$app->user->identity->username;
        $log->action = 'Delete Customer ['.$model->id.']';
        $log->insert();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
