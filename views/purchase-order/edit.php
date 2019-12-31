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
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/purchase_order_edit.js',['depends' => [yii\web\JqueryAsset::className()]]);

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

		<div class="form-group field-purchaseorder-done_date">
		<label class="control-label" for="purchaseorder-done_date">完工日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'PurchaseOrder[done_date]',
				'value' => date("Y-m-d", strtotime('today')),
				'dateFormat' => 'MM/dd/yyyy',
			]);
		?>
		<div class="help-block"></div>
		</div>		

		<div class="input_fields_wrap_product">
			<label class="control-label">產品名稱 / 原始訂單數量 / 實際生產數量</label>

			<?php
				$content = json_decode($model->toArray()['content']);
				$out = '';
				foreach ($content as $key => $value) {
					$out = $out.'<div>';
					$out = $out.'<input type="text" name="product" value="'.$key.'" readonly>';
					$out = $out.'<label>/</label>';
					$out = $out.'<input type="number" name="order_cnt" value="'.$value->order_cnt.'" readonly>';
					$out = $out.'<label>/</label>';
					$out = $out.'<input type="number" name="print_cnt" value="'.$value->print_cnt.'" >';
					$out = $out.'</div>';
					$idx++;
				}
				echo $out;
			?>
			<label class="control-label">入庫說明: padi庫存 / 自有庫存 </label>
			<div>
				<input type="number" name="padi_cnt" value="" >
				<label>/</label>
				<input type="number" name="self_cnt" value="" >
			</div>
		</div>
		<div class="help-block"></div>
		
		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>

		<div class="form-group">
			<?= Html::submitButton('完工入庫', ['class' => 'btn btn-primary', 'name' => 'done', 'onclick' => 'return check_cnt()']) ?>
			<?= Html::submitButton('分批入庫', ['class' => 'btn btn-primary', 'name' => 'partial', 'onclick' => 'return check_cnt()']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- purchase-order-edit -->
