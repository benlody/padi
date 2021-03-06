<?php

namespace app\controllers;

use Yii;
use app\models\Log;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->identity->group > User::GROUP_KL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // add cloumn on tables
            Yii::$app->db->createCommand()->addColumn('crew_pak', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('tw_padi_balance', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('tw_self_balance', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('xm_padi_balance', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('xm_self_balance', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('tw_padi_transaction', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('tw_self_transaction', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('xm_padi_transaction', $model->id, 'int(8) DEFAULT 0')->execute();
            Yii::$app->db->createCommand()->addColumn('xm_self_transaction', $model->id, 'int(8) DEFAULT 0')->execute();

            $log = new Log();
            $log->username = Yii::$app->user->identity->username;
            $log->action = 'Add Product ['.$model->id.']';
            $log->insert();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
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
            $log->action = 'Modify Product ['.$model->id.']';
            $log->insert();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
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
        $log->action = 'Delete Product ['.$id.']';
        $log->insert();

        return $this->redirect(['index']);
    }


    public function actionAjaxList()
    {
        $product = new Product();

        return json_encode($product->find()->column(), JSON_FORCE_OBJECT);
    }


    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
