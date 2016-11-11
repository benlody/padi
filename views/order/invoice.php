<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

require_once __DIR__  . '/../../utils/enum.php';

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form ActiveForm */
$this->title = '發票產生器';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->getBaseUrl().'/js/order_invoice.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>


<div class="order-invoice">

	<?php $form = ActiveForm::begin(); ?>

		<div class="form-group field-order-id required">
		<label for="order-id">訂單編號</label>
		<input type="text" id="order-id" class="form-control" name="Order[id]">
		<div class="help-block"></div>
		</div>

		<div class="form-group field-order-tracking required">
		<label for="order-tracking">提單號碼</label>
		<input type="text" id="order-tracking" class="form-control" name="Order[tracking]">
		<div class="help-block"></div>
		</div>

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

		<div class="form-group field-order-customer_name required">
		<label for="order-customer_name">會員名稱</label>
		<input type="text" id="order-customer_name" class="form-control" name="Order[customer_name]">
		<div class="help-block"></div>
		</div>

		<div class="form-group field-order-region required">
		<label for="order-region">地區</label>
		<input type="text" id="order-region" class="form-control" name="Order[region]">
		<div class="help-block"></div>
		</div>

		<div class="form-group field-order-addr required">
		<label for="order-addr">地址</label>
		<input type="text" id="order-addr" class="form-control" name="Order[addr]">
		<div class="help-block"></div>
		</div>

		<div class="form-group field-order-contact required">
		<label for="order-contact">聯絡人</label>
		<input type="text" id="order-contact" class="form-control" name="Order[contact]">
		<div class="help-block"></div>
		</div>

		<div class="form-group field-order-tel required">
		<label for="order-tel">電話</label>
		<input type="text" id="order-tel" class="form-control" name="Order[tel]">
		<div class="help-block"></div>
		</div>


		<label class="control-label" for="order-content">發票內容</label>
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

		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'invoice']) ?>
		</div>
	<?php ActiveForm::end(); ?>

</div>