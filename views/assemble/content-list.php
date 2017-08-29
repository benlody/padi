<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

$this->title = Yii::t('app', 'Assemble Content List');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/assemble_content_list.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="assemble-content-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php

	$config = [
		'dataProvider' => $dataProvider,
		'columns' => [
			'id:text:'.Yii::t('app', 'Assemble No.'),
			[
				'attribute' => 'content',
				'format' => 'raw',
				'label' => '組裝內容',
				'value' => function ($model) {
					return assemble_content_to_table($model->content, $model->id);
				}
			],
			'extra_info:text:'.Yii::t('app', 'Remark'),
		],
	];

	?>

	<?= GridView::widget($config); ?>

</div>