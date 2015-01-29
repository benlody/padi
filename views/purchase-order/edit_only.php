<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = '生產';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="purchase-order-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '生產編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'date', ['labelOptions' => ['label' => '日期']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			], ['readonly' => true])
		?>

		<label class="control-label" for="order-content">生產內容</label>
		<?= product_content_to_table($model->content, true) ?>
		<div class="help-block"></div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton('儲存', ['class' => 'btn btn-primary', 'name' => 'save']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- purchase-order-edit -->
