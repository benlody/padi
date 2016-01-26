<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

require_once __DIR__  . '/../../utils/enum.php';

?>

<div class="order-add">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id', ['labelOptions' => ['label' => '訂單編號']]) ?>

		<div class="form-group field-order-date">
		<label class="control-label" for="order-date">日期</label>
		<?php
			echo DatePicker::widget([
				'name' => 'Order[date]',
				'value' => date("Y-m-d", strtotime('today')),
				'dateFormat' => 'yyyy-MM-dd',

			]);
		?>
		<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'warehouse', ['labelOptions' => ['label' => '倉儲']])->dropDownList([
			'xm' => '廈門卡樂兒',
			'tw' => '台灣光隆',
			])
		?>

		<?= $form->field($model, 'ship_type', ['labelOptions' => ['label' => '運送方式']])->dropDownList(ShippingType::getType()) ?>

		<div class="form-group field-order-customer_id required">
			<label class="control-label" for="order-customer_id">會員編號</label><br>

			<select class="form-control" id="customer_id" name='Order[customer_id]' onchange="fill_customer_info()">
				<option value='empty'></option>
				<script>
				var customer = <?php echo json_encode($customer); ?>;
				var select = <?php echo json_encode($model->customer_id); ?>;
				var idx;
				for	(idx = 0; idx < customer.length; idx++) {
					document.write('<option value="');
					document.write(customer[idx]);
					if(select === customer[idx]){
						document.write('" selected>');
					} else {
						document.write('">');
					}
					document.write(customer[idx]);
					document.write('</option>');
				}
				</script>
			</select>
			<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'customer_name', ['labelOptions' => ['label' => '會員名稱']]) ?>
		<?= $form->field($model, 'chinese_addr', ['labelOptions' => ['label' => '中文地址']]) ?>
		<?= $form->field($model, 'english_addr', ['labelOptions' => ['label' => '英文地址']]) ?>
		<?= $form->field($model, 'region', ['labelOptions' => ['label' => '地區']])->dropDownList(ShippingRegion::getRegionList()) ?>
		<?= $form->field($model, 'contact', ['labelOptions' => ['label' => '聯絡人']]) ?>
		<?= $form->field($model, 'tel', ['labelOptions' => ['label' => '電話']]) ?>

		<label class="control-label" for="order-content">訂單內容</label>
		<div style="margin-left: 50px">

		<?php
			$content = json_decode($model->content, true);
		?>
		<script>
			var crewpak = <?php echo json_encode($crewpak); ?>;
			var product = <?php echo json_encode($product); ?>;
		</script>

		<div class="input_fields_wrap_crewpak">
			<label class="control-label">套裝</label>
			<button class="add_field_button_crewpak">+</button>
			<?php
				if(empty($model->content)){
					echo '<div>';
					echo '<select class="form-group" name="crew_pak_0">';
					echo '<option value=""></option>';
					foreach ($crewpak as $c) {
						echo '<option value="'.$c.'">'.$c.'</option>';
					}
					echo '</select>';
					echo Html::input('number', 'crew_pak_cnt_0', '0');
					echo '</div>';
				} else {
					$crewpak_array = $content['crewpak'];
					$idx = 0;
					foreach ($crewpak_array as $cid => $detail) {
						echo '<div>';
						echo '<select class="form-group" name="crew_pak_'.$idx.'">';
						echo '<option value=""></option>';
						foreach ($crewpak as $c) {
							if(0 == strcmp($c, $cid)){
								echo '<option value="'.$c.'" selected>'.$c.'</option>';
							} else {
								echo '<option value="'.$c.'">'.$c.'</option>';
							}
						}
						echo '</select>';
						echo Html::input('number', 'crew_pak_cnt_'.$idx, $detail['cnt']);
						echo '</div>';
						$idx++;
					}
				}
			?>
		</div>

		<div class="input_fields_wrap_product">
			<label class="control-label">單品</label>
			<button class="add_field_button_product">+</button>
			<?php
				if(empty($model->content)){
					echo '<div>';
					echo '<select class="form-group" name="product_0">';
					echo '<option value=""></option>';
					foreach ($product as $p) {
						echo '<option value="'.$p.'">'.$p.'</option>';
					}
					echo '</select>';
					echo Html::input('number', 'product_cnt_0', '0');
					echo '</div>';
				} else {
					$product_array = $content['product'];
					$idx = 0;
					foreach ($product_array as $pid => $detail) {
						echo '<div>';
						echo '<select class="form-group" name="product_'.$idx.'">';
						echo '<option value=""></option>';
						foreach ($product as $p) {
							if(0 == strcmp($p, $pid)){
								echo '<option value="'.$p.'" selected>'.$p.'</option>';
							} else {
								echo '<option value="'.$p.'">'.$p.'</option>';
							}
						}
						echo '</select>';
						echo Html::input('number', 'product_cnt_'.$idx, $detail['cnt']);
						echo '</div>';
						$idx++;
					}
				}
			?>
		</div>

		<div class="help-block"></div>
		</div>

		<?= $form->field($model, 'extra_info', ['labelOptions' => ['label' => '備註']])->textArea(['rows' => 6]) ?>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'add']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div>