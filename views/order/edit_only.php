<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Order;

require_once __DIR__  . '/../../utils/utils.php';
require_once __DIR__  . '/../../utils/enum.php';

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = $model->id;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '訂單編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'date', ['labelOptions' => ['label' => '日期']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			],['readonly' => true])
		?>
		<?= $form->field($model, 'customer_id', ['labelOptions' => ['label' => '會員編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'chinese_addr')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'english_addr')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'region', ['labelOptions' => ['label' => '地區']])
					->dropDownList(ShippingRegion::getRegionList(),['readonly' => true]) ?>
		<?= $form->field($model, 'contact')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'tel')->textInput(['readonly' => true]) ?>

		<label class="control-label" for="order-content">訂單內容</label>
		<?= order_content_to_table($model->toArray()['content']) ?>
		<div class="help-block"></div>

		<?= $form->field($model, 'ship_type', ['labelOptions' => ['label' => '運送方式']])
					->dropDownList(ShippingType::getType(),['readonly' => ($model->status == Order::STATUS_DONE)]) ?>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', '儲存'), ['class' => 'btn btn-primary', 'name' => 'save']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- order-edit -->
