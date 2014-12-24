<?php

namespace app\controllers;
use app\models\Product;
use app\models\Transfer;
use app\models\TransferSearch;
use app\models\Balance1;
use app\models\Balance2;
use app\models\Transaction1;
use app\models\Transaction2;
use yii\db\Query;
use Yii;

require_once __DIR__  . '/../utils/utils.php';

class TransferController extends \yii\web\Controller
{
	public function actionAdd()
	{

		$model = new Transfer;
		$product = new Product();

		$post_param = Yii::$app->request->post();

		if(isset($post_param['add'])){

			$content = $this->get_content($post_param);
			$post_param['Transfer']['content'] = json_encode($content, JSON_FORCE_OBJECT);

			$src = $post_param['Transfer']['src_warehouse'];
			$dst = $post_param['Transfer']['dst_warehouse'];

			if(0 == strcmp($src, $dst)){
				echo "<script type='text/javascript'>alert('倉儲來源與目的相同 請重新輸入');</script>";
				return $this->render('add', [
					'model' => $model,
					'product' =>  $product->find()->column()
				]);

			} else if(0 == strcmp($dst, 'sydney')){

				$pos = strpos($src, '_');
				$warehouse = substr($src, 0, $pos);
				$warehouse_type = substr($src, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));
				$post_param['Transfer']['recv_date'] = date("Y-m-d", strtotime($post_param['date']));

				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_DONE;

				$transaction_model =  new Transaction1($warehouse, $warehouse_type);
				$balance_model =  new Balance1($warehouse, $warehouse_type);
				get_balance($balance_model, $warehouse, $warehouse_type);

				foreach ($content as $p_name => $cnt) {
					$transaction_model->$p_name -= $cnt;
					$balance_model->$p_name -= $cnt;
				}

				$now = strtotime('now');
				$transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$transaction_model->date = date("Y-m-d", strtotime($post_param['date']));
				$transaction_model->extra_info = $post_param['Transfer']['extra_info'];

				$balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$balance_model->date = date("Y-m-d", strtotime($post_param['date']));
				$balance_model->extra_info = $post_param['Transfer']['extra_info'];

				$model->insert();
				$transaction_model->insert();
				$balance_model->insert();

				return $this->redirect(['list', 'status' => 'done']);

			} else if(0 == strcmp($src, 'sydney')){

				$pos = strpos($dst, '_');
				$warehouse = substr($dst, 0, $pos);
				$warehouse_type = substr($dst, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));
				$post_param['Transfer']['recv_date'] = date("Y-m-d", strtotime($post_param['date']));

				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_DONE;

				$transaction_model =  new Transaction1($warehouse, $warehouse_type);
				$balance_model =  new Balance1($warehouse, $warehouse_type);
				get_balance($balance_model, $warehouse, $warehouse_type);

				foreach ($content as $p_name => $cnt) {
					$transaction_model->$p_name += $cnt;
					$balance_model->$p_name += $cnt;
				}

				$now = strtotime('now');
				$transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$transaction_model->date = date("Y-m-d", strtotime($post_param['date']));
				$transaction_model->extra_info = $post_param['Transfer']['extra_info'];

				$balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$balance_model->date = date("Y-m-d", strtotime($post_param['date']));
				$balance_model->extra_info = $post_param['Transfer']['extra_info'];

				$model->insert();
				$transaction_model->insert();
				$balance_model->insert();

				return $this->redirect(['list', 'status' => 'done']);

			} else if(0 == strncmp($src, $dst, strpos($dst, '_'))){

				$pos = strpos($dst, '_');
				$warehouse = substr($dst, 0, $pos);
				$dst_warehouse_type = substr($dst, $pos + 1);
				$src_warehouse_type = substr($src, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));
				$post_param['Transfer']['recv_date'] = date("Y-m-d", strtotime($post_param['date']));
				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_DONE;

				$dst_transaction_model =  new Transaction1($warehouse, $dst_warehouse_type);
				$src_transaction_model =  new Transaction2($warehouse, $src_warehouse_type);
				$dst_balance_model =  new Balance1($warehouse, $dst_warehouse_type);
				$src_balance_model =  new Balance2($warehouse, $src_warehouse_type);
				get_balance($dst_balance_model, $warehouse, $dst_warehouse_type);
				get_balance($src_balance_model, $warehouse, $src_warehouse_type);
				foreach ($content as $p_name => $cnt) {
					$dst_transaction_model->$p_name += $cnt;
					$src_transaction_model->$p_name -= $cnt;
					$dst_balance_model->$p_name += $cnt;
					$src_balance_model->$p_name -= $cnt;
				}

				$now = strtotime('now');
				$dst_transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$dst_transaction_model->date = date("Y-m-d", strtotime($post_param['date']));
				$dst_transaction_model->extra_info = $post_param['Transfer']['extra_info'];
				$src_transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$src_transaction_model->date = date("Y-m-d", strtotime($post_param['date']));
				$src_transaction_model->extra_info = $post_param['Transfer']['extra_info'];

				$dst_balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$dst_balance_model->date = date("Y-m-d", strtotime($post_param['date']));
				$dst_balance_model->extra_info = $post_param['Transfer']['extra_info'];
				$src_balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$src_balance_model->date = date("Y-m-d", strtotime($post_param['date']));
				$src_balance_model->extra_info = $post_param['Transfer']['extra_info'];

				$model->insert();
				$dst_transaction_model->insert();
				$src_transaction_model->insert();
				$dst_balance_model->insert();
				$src_balance_model->insert();

				return $this->redirect(['list', 'status' => 'done']);

			} else {
				$pos = strpos($dst, '_');
				$warehouse = substr($src, 0, $pos);
				$warehouse_type = substr($src, $pos + 1);

				$post_param['Transfer']['send_date'] = date("Y-m-d", strtotime($post_param['date']));
				$post_param['Transfer']['recv_date'] = date("Y-m-d", strtotime($post_param['date']));
				foreach ($post_param['Transfer'] as $key => $value) {
					$model->$key = $value;
				}
				$model->status = Transfer::STATUS_NEW;

				$transaction_model =  new Transaction2($warehouse, $warehouse_type);
				$balance_model =  new Balance2($warehouse, $warehouse_type);
				get_balance($balance_model, $warehouse, $warehouse_type);
				foreach ($content as $p_name => $cnt) {
					$transaction_model->$p_name -= $cnt;
					$balance_model->$p_name -= $cnt;
				}

				$now = strtotime('now');
				$transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$transaction_model->date = date("Y-m-d", strtotime($post_param['date']));
				$transaction_model->extra_info = $post_param['Transfer']['extra_info'];

				$balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
				$balance_model->date = date("Y-m-d", strtotime($post_param['date']));
				$balance_model->extra_info = $post_param['Transfer']['extra_info'];

				$model->insert();
				$transaction_model->insert();
				$balance_model->insert();

				return $this->redirect(['list']);
			}

			return $this->render('add', [
				'model' => $model,
				'product' =>  $product->find()->column()
			]);

		} else {
			return $this->render('add', [
				'model' => $model,
				'product' =>  $product->find()->column()
			]);
		}
	}

	public function actionEdit($id)
	{
		$model = $this->findModel($id);
		$post_param = Yii::$app->request->post();

		if(isset($post_param['done'])){
			$content = $this->get_content($post_param);
			$post_param['Transfer']['content'] = json_encode($content, JSON_FORCE_OBJECT);
			$post_param['Transfer']['recv_date'] = date("Y-m-d", strtotime($post_param['Transfer']['recv_date']));

			$src = $post_param['Transfer']['src_warehouse'];
			$dst = $post_param['Transfer']['dst_warehouse'];

			$pos = strpos($dst, '_');
			$warehouse = substr($dst, 0, $pos);
			$warehouse_type = substr($dst, $pos + 1);

			foreach ($post_param['Transfer'] as $key => $value) {
				$model->$key = $value;
			}
			$model->status = Transfer::STATUS_DONE;

			$transaction_model =  new Transaction1($warehouse, $warehouse_type);
			$balance_model =  new Balance1($warehouse, $warehouse_type);
			get_balance($balance_model, $warehouse, $warehouse_type);
			foreach ($content as $p_name => $cnt) {
				$transaction_model->$p_name += $cnt;
				$balance_model->$p_name += $cnt;
			}

			$now = strtotime('now');
			$transaction_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
			$transaction_model->date = $post_param['Transfer']['recv_date'];
			$transaction_model->extra_info = $post_param['Transfer']['extra_info'];

			$balance_model->serial = 'transfer_'.$post_param['Transfer']['id'].'_'.$now;
			$balance_model->date = $post_param['Transfer']['recv_date'];
			$balance_model->extra_info = $post_param['Transfer']['extra_info'];

			$model->update();
			$transaction_model->insert();
			$balance_model->insert();

			return $this->redirect(['list', 'status' => 'done']);

		} else {

			return $this->render('edit', [
				'model' => $model,
			]);
		}
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

	public function actionList($status='', $detail = true, $sort='-send_date')
	{
		$searchModel = new TransferSearch();
		if(0 == strcmp($status, 'done')){
			$search_param['TransferSearch'] = array('status' => Transfer::STATUS_DONE);
		} else {
			$search_param['TransferSearch'] = array('status' => Transfer::STATUS_NEW);
		}
		$dataProvider = $searchModel->search($search_param);

		return $this->render('list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'status' => $status,
			'detail' => $detail,
			'sort' => $sort,
		]);
	}

	protected function findModel($id)
	{
		if (($model = Transfer::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	protected function get_content($post_param){

		$x = 0;
		$content = array();

		while(1){

			$product_idx = "product_".$x;
			$cnt_idx = "product_cnt_".$x;

			if(!isset($post_param[$product_idx])){
				break;
			}

			$cnt = $post_param[$cnt_idx];
			$product_id =  $post_param[$product_idx];

			if(0 == strcmp($product_id, "") || 0 == $cnt ){
				$x++;
				continue;
			}

			$content[$product_id] = $cnt;

			$x++;
		}

		return $content;
	}
}
