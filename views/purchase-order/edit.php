<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = 'Purchase Order';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/yii/basic/web/js/purchase_order_add.js',['depends' => [yii\web\JqueryAsset::className()]]);

//print_r($model->attributes['content']);

//print_r($model->toArray());


?>
<div class="purchase-order-add">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'date')->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'warehouse')->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			], ['readonly' => true])
		?>

		<div class="form-group field-purchaseorder-done_date">
		<label class="control-label" for="purchaseorder-done_date">完工日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'done_date',
				'value' => date("Y-m-d", strtotime('today')),
			]);
		?>
		<div class="help-block"></div>
		</div>		

		<div class="input_fields_wrap_product">
			<label class="control-label">Product / 訂單數量 / 實印數量</label>

			<?php
				$content = json_decode($model->toArray()['content']);
				$idx = 0;
				$out = '';
				foreach ($content as $key => $value) {
					$out = $out.'<div>';
					$out = $out.'<input type="text" name="product_'.$idx.'" value="'.$key.'" readonly>';
					$out = $out.'<label>/</label>';
					$out = $out.'<input type="number" name="order_cnt_'.$idx.'" value="'.$value->order_cnt.'" readonly>';
					$out = $out.'<label>/</label>';
					$out = $out.'<input type="number" name="print_cnt_'.$idx.'" value="'.$value->print_cnt.'" >';
					$out = $out.'</div>';
					$idx++;
				}
				echo $out;
			?>
		</div>

		<div class="help-block"></div>
		

		<?= $form->field($model, 'extra_info')->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save']) ?>
			<?= Html::submitButton('完工', ['class' => 'btn btn-primary', 'name' => 'done']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- purchase-order-add -->
