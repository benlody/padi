<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

$this->title = Yii::t('app', '套裝');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="crew_pak-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php

	$config = [
		'dataProvider' => $dataProvider,
		'columns' => [
			'id:text:套裝',
			[
				'format' => 'raw',
				'label' => '套裝內容',
				'value' => function ($model) {
					return crewpak_index_to_table($model['id'], $model['content']);
				}
			],
			'extra_info:text:備註',
		],
	];

	?>

	<?= GridView::widget($config); ?>

</div>