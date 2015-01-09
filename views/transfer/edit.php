<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Transfer;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form ActiveForm */

$this->title = 'Transfer';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/transfer_edit.js',['depends' => [yii\web\JqueryAsset::className()]]);

?>
<div class="transfer-edit">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '編號']])->textInput(['readonly' => true]) ?>

		<?= $form->field($model, 'src_warehouse', ['labelOptions' => ['label' => '轉出倉儲']])->dropDownList([
				'xm_padi' => '廈門卡樂兒PADI庫存',
				'xm_self' => '廈門卡樂兒自有庫存',
				'tw_padi' => '台灣光隆PADI庫存',
				'tw_self' => '台灣光隆自有庫存',
				'sydney' => '雪梨PADI',
			], ['readonly' => true]) ?>

		<?= $form->field($model, 'dst_warehouse', ['labelOptions' => ['label' => '轉入倉儲']])->dropDownList([
				'xm_padi' => '廈門卡樂兒PADI庫存',
				'xm_self' => '廈門卡樂兒自有庫存',
				'tw_padi' => '台灣光隆PADI庫存',
				'tw_self' => '台灣光隆自有庫存',
				'sydney' => '雪梨PADI',
			], ['readonly' => true]) ?>

		<?= $form->field($model, 'ship_type', ['labelOptions' => ['label' => '運送方式']])->dropDownList([
				'sea' => '海運',
				'air' => '空運',
				'internal' => '內部轉移',
			], ['readonly' => true]) ?>

		<?= $form->field($model, 'chinese_addr', ['labelOptions' => ['label' => '中文地址']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'english_addr', ['labelOptions' => ['label' => '英文地址']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'contact', ['labelOptions' => ['label' => '聯絡人']])->textInput(['readonly' => true]) ?>
		<?= $form->field($model, 'tel', ['labelOptions' => ['label' => '電話']])->textInput(['readonly' => true]) ?>

		<div class="form-group">
		<label class="control-label" for="order-date">日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'date',
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
			<div class="help-block"></div>
		</div>

		<?php
			if($model->status == Transfer::STATUS_NEW){
				echo '<div class="input_fields_wrap_ship">';
					echo '<label class="control-label">貨運</label>';
					echo '<button class="add_field_button_ship">+</button>';
					echo '<div>';
					echo '<p><b>';
						echo 'Tracking Number:&nbsp;<input name="shipping_0" type="text" required/>';
						echo '&nbsp;&nbsp;&nbsp;包裝:&nbsp;<input name="packing_cnt_0" type="number" style="width:60px;" required/>';
						echo '<select name="packing_type_0">';
							echo '<option value="box">箱</option>';
							echo '<option value="pack">包</option>';
						echo '</select>&nbsp;&nbsp;&nbsp;重量:&nbsp;<input name="weight_0" type="number" style="width:100px;" required/>KG';
						echo '</select>&nbsp;&nbsp;&nbsp;運費:&nbsp;<input name="shipping_fee_0" type="number" style="width:100px;" required/>';
					echo '</b></p>';
					echo '</div>';
				echo '</div>';
			}

		?>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>
	
		<div class="form-group">
			<?php
				if($model->status == Transfer::STATUS_NEW){
					echo Html::submitButton(Yii::t('app', '出貨'), ['class' => 'btn btn-primary', 'name' => 'send_done']);
				} else if ($model->status == Transfer::STATUS_ONTHEWAY){
					echo Html::submitButton(Yii::t('app', '已寄達'), ['class' => 'btn btn-primary', 'name' => 'recv_done']);
				}
			?>
		</div>
	<?php ActiveForm::end(); ?>

</div><!-- transfer-add -->
