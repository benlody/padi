<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

require_once __DIR__  . '/../../utils/utils.php';

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Order';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/yii/basic/web/js/order_add.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>

<div class="order-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'date', ['labelOptions' => ['label' => '日期']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			],['readonly' => true])
		?>
		<?= $form->field($model, 'customer_id', ['labelOptions' => ['label' => '會員編號']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'chinese_addr')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'english_addr')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'contact')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'tel')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'ship_type', ['labelOptions' => ['label' => '運送方式']])->dropDownList([
			'標準快遞',
			'順丰特惠',
			'物流普運'])
		?>

		<label class="control-label" for="order-content">訂單日期</label>
		<div style="margin-left: 50px">
			<div class="input_fields_wrap_product">
				<label class="control-label">套裝 / 數量</label><br>

				<?php
					$content = json_decode($model->toArray()['content']);
					$crewpak_content = $content->crewpak;
					$idx = 0;
					$out = '';
					foreach ($crewpak_content as $key => $value) {
						$out = $out.'<div>';
						$out = $out.'<input type="text" name="crew_pak_'.$idx.'" value="'.$key.'" readonly>';
						$out = $out.'<label>/</label>';
						$out = $out.'<input type="number" name="crew_pak_cnt_'.$idx.'" value="'.$value.'" readonly>';
						$out = $out.'</div>';
						$idx++;
					}
					echo $out;
				?>

				<label class="control-label">品名 / 數量</label><br>

				<?php
					$product_content = $content->product;
					$idx = 0;
					$out = '';
					foreach ($product_content as $key => $value) {
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
			<div class="help-block"></div>
		</div>

		<div class="form-group field-order-done_date">
		<label class="control-label" for="order-done_date">出貨日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'Order[done_date]',
				'value' => date("Y-m-d", strtotime('today')),
			]);
		?>
		<div class="help-block"></div>
		</div>		

		<?= $form->field($model, 'box_num', ['labelOptions' => ['label' => '總箱數']])->textInput(['integerOnly'=>true]) ?>
		<?= $form->field($model, 'weight', ['labelOptions' => ['label' => '總重']])->textInput(['integerOnly'=>true]) ?>
		<?= $form->field($model, 'shipping_no', ['labelOptions' => ['label' => '運單號碼']]) ?>


		<?= $form->field($model, 'extra_info')->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'done']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- order-edit -->
