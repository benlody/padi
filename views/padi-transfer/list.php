<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\PadiTransfer;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '列表';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/paditransfer_list.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>

<div class="paditransfer-list">


	<?php

		$config = [
			'dataProvider' => $dataProvider,
			'columns' => [
				'id:text:編號',
				'date:text:日期',
				[
					'attribute' => 'src_warehouse',
					'format' => 'raw',
					'label' => '來源倉儲',
					'value' => function ($model) {
						return get_warehouse_name($model->src_warehouse);
					}
				],
				[
					'attribute' => 'dst_warehouse',
					'format' => 'raw',
					'label' => '目的倉儲',
					'value' => function ($model) {
						return get_warehouse_name($model->dst_warehouse);
					}
				],
				[
					'attribute' => 'content',
					'format' => 'raw',
					'label' => '內容',
					'value' => function ($model) {
						return paditransfer_content_to_table($model->content,$model->id);
					}
				],
				'extra_info:text:備註',
				[
					'attribute' => '',
					'format' => 'raw',
					'label' => 'Action',
					'value' => function ($model) {
/*
						$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fmodify&amp;id='.urlencode($model->id).'" title="修改" data-pjax="0"><span class="glyphicon glyphicon glyphicon-pencil"></span></a>'.
							'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fdelete&amp;id='.urlencode($model->id).'" title="刪除" data-confirm="確定要刪除'.$model->id.'嗎?"><span class="glyphicon glyphicon glyphicon-trash"></span></a>'.
							'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Fdownload&amp;id='.urlencode($model->id).'" title="下載EXCEL" data-pjax="0"><span class="glyphicon glyphicon glyphicon-download"></span></a>'.
							'<a href="'.Yii::$app->request->getBaseUrl().'?r=order%2Freview&amp;id='.urlencode($model->id).'" title="覆核" data-pjax="0"><span class="glyphicon glyphicon glyphicon-eye-open"></span></a>';
*/
						$opt = '<a href="'.Yii::$app->request->getBaseUrl().'?r=padi-transfer%2Fdownload&amp;id='.urlencode($model->id).'" title="下載EXCEL" data-pjax="0"><span class="glyphicon glyphicon glyphicon-download"></span></a>';
						return $opt;
					}
				],
			],
		];



	?>
	<h1><?= Html::encode($this->title.$subtitle) ?></h1>
	<?= GridView::widget($config); ?>

</div>