<?php

use yii\helpers\Html;
use yii\grid\GridView;

require_once __DIR__  . '/../../utils/utils.php';

$this->title = Yii::t('app', 'Crew-Pak List');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="crew_pak-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php

	$config = [
		'dataProvider' => $dataProvider,
		'columns' => [
			'id:text:'.Yii::t('app', 'Crew-Pak No.'),
			[
				'format' => 'raw',
				'label' => Yii::t('app', 'Crew-Pak Content'),
				'value' => function ($model) {
					return crewpak_index_to_table($model['id'], $model['content']);
				}
			],
		],
	];

	?>

	<?= GridView::widget($config); ?>

</div>