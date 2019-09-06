<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Transfer;
require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cert Card');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="certcard-list">

	<?php
		if(0 == strcmp($status, 'done')){
			$subtitle = ' - 已寄達';
			$btn_lable = '列出未完成列表';
			$btn_cfg = ['list', 'status' => '', 'sort' => '-t_send_date'];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'DHL:text:DHL tracking',					
					's_recv_date:text:收到日期',
					'tracking:text:順豐Tracking',
					'small_box:text:small box',
					'extra_info:text:備註',
				],
			];
		} else {
			$subtitle = ' - 未完成';
			$btn_lable = '列出已完成列表';
			$btn_cfg = ['list', 'status' => 'done', 'detail' => $detail, 'sort' => '-s_recv_date'];
			$config = [
				'dataProvider' => $dataProvider,
				'columns' => [
					'DHL:text:DHL tracking',					
					't_send_date:text:台灣寄出日期',
					'tracking:text:順豐Tracking',
					'extra_info:text:備註',
					[
						'attribute' => '',
						'format' => 'raw',
						'value' => function ($model) {
							if(true){
//								$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=certcard%2Fedit&amp;id='.urlencode($model->id).'" title="出貨" data-pjax="0"><span class="glyphicon glyphicon glyphicon-ok"></span></a>'.
//									'<a href="'.Yii::$app->request->getBaseUrl().'?r=certcard%2Fdelete&amp;id='.urlencode($model->id).'" title="刪除" data-confirm="確定要刪除嗎?"><span class="glyphicon glyphicon glyphicon-trash"></span></a>';
								$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=certcard%2Fedit&amp;id='.urlencode($model->id).'" title="出貨" data-pjax="0"><span class="glyphicon glyphicon glyphicon-ok"></span></a>';

							}
							return $opt;

						}
					],
				],
			];
		}


	?>
	<h1><?= Html::encode($this->title.$subtitle) ?></h1>
	<?= Html::a($btn_lable, $btn_cfg, ['class' => 'btn btn-primary']) ?>
	<?= GridView::widget($config); ?>

</div>