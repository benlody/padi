<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form ActiveForm */

$this->title = 'Transfer';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transfer-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '編號']])->textInput(['readonly' => true]) ?>


		<?= $form->field($model, 'src_warehouse', ['labelOptions' => ['label' => '轉出倉儲']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'dst_warehouse', ['labelOptions' => ['label' => '轉入倉儲']])->textInput(['readonly' => true]) ?>

		<?= $form->field($model, 'send_date', ['labelOptions' => ['label' => '寄送日期']])->textInput(['readonly' => true]) ?>

		<div class="form-group">
		<label class="control-label" for="order-date">日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'Transfer[recv_date]',
				'value' => date("Y-m-d", strtotime('today')),
			]);
		?>
		<div class="help-block"></div>
		</div>


		<label class="control-label">內容</label>
		<div style="margin-left: 50px">
			<?php
				$content = json_decode($model->toArray()['content']);
				$idx = 0;
				$out = '';
				foreach ($content as $key => $value) {
					$out = $out.'<div>';
					$out = $out.'<input type="text" name="product_'.$idx.'" value="'.$key.'" readonly>';
					$out = $out.'<label>/</label>';
					$out = $out.'<input type="number" name="product_cnt_'.$idx.'" value="'.$value.'" readonly>';
					$out = $out.'</div>';
					$idx++;
				}
				echo $out;
			?>

		</div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', '已寄達'), ['class' => 'btn btn-primary', 'name' => 'done']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- transfer-add -->
