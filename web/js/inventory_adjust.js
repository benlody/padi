$(document).ready(function() {
	var max_fields = 100; //maximum input boxes allowed
	var wrapper_product = $(".input_fields_wrap_product"); //Fields wrapper
	var add_button_product = $(".add_field_button_product"); //Add button ID
	
	var product_cnt = 1; //initlal text box count
	$(add_button_product).click(function(e){ //on add input button click
		e.preventDefault();
		if(product_cnt < max_fields){ //max input box allowed
			var newIn = '<div><select class="form-group" name="product_' + product_cnt + '" id="product_' + product_cnt + '" onchange="get_balance(this,' + product_cnt + ')"><option value=""></option>'
			for	(idx = 0; idx < product.length; idx++) {
				newIn += '<option value="';
				newIn += product[idx];
				newIn += '">';
				newIn += product[idx];
				newIn += '</option>';
			}
			newIn += '</select>';
			newIn += '<label>目前庫存餘額:</label><label id="label_' + product_cnt + '"></label>';
			newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;增減:</label><input type="number" name="change_' + product_cnt + 
						'" id="change_' + product_cnt + '" value="0" onchange="change_hook(this.value,' + product_cnt + ')">';
			newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;調整為:</label><input type="number" name="product_cnt_' + product_cnt + 
						'" id="product_cnt_' + product_cnt + '" value="0" onchange="balance_hook(this.value,' + product_cnt + ')">';
			newIn += '</div>';
			product_cnt++; //text box increment
			$(wrapper_product).append(newIn); //add input box
		}
	});
});

function get_balance(sel, idx) {
	var warehouse = document.getElementById("warehouse").value;
	var warehouse_type = document.getElementById("warehouse_type").value;
	var balance = warehouse + '_' + warehouse_type + '_balance';

	jQuery.ajax({
		// The url must be appropriate for your configuration;
		// this works with the default config of 1.1.11
		url: 'index.php?r=inventory/ajax-get_balance',
		type: "POST",
		data: {
			balance: balance,
			id: sel.value
		},
		error: function(xhr,tStatus,e){
			console.log(arguments);
		},
		success: function(resp){
			var ret = JSON.parse(resp);
			var cur_balance = ret[sel.value] ? ret[sel.value] : 0;
			document.getElementById("label_" + idx).innerHTML = cur_balance;
			document.getElementById("change_" + idx).value = 0;
			document.getElementById("product_cnt_" + idx).value = cur_balance;
		}
	});
}

function change_hook(val, idx){
	var cur_balance = document.getElementById("label_" + idx).innerHTML;
	if(!cur_balance){
		cur_balance = 0;
	}
	document.getElementById("product_cnt_" + idx).value = parseInt(cur_balance) + parseInt(val);
}

function balance_hook(val, idx){
	var cur_balance = document.getElementById("label_" + idx).innerHTML;
	if(!cur_balance){
		cur_balance = 0;
	}
	document.getElementById("change_" + idx).value = parseInt(val) - parseInt(cur_balance);
}

function change_wh() {
	var warehouse = document.getElementById("warehouse").value;
	var warehouse_type = document.getElementById("warehouse_type").value;
	var balance = warehouse + '_' + warehouse_type + '_balance';

	jQuery.ajax({
		// The url must be appropriate for your configuration;
		// this works with the default config of 1.1.11
		url: 'index.php?r=inventory/ajax-get_balance',
		type: "POST",
		data: {
			balance: balance,
			id: '*'
		},
		error: function(xhr,tStatus,e){
			console.log(arguments);
		},
		success: function(resp){
			var ret = JSON.parse(resp);
			var idx = 0, product, change, new_balance, cur_balance;

			while(1){
				product = document.getElementById("product_" + idx);
				change = document.getElementById("change_" + idx);
				new_balance = document.getElementById("product_cnt_" + idx);
				cur_balance = document.getElementById("label_" + idx);

				if(null === product){
					break;
				}

				var balance = ret[product.value] ? ret[product.value] : 0;
				if(product.value){
					cur_balance.innerHTML = balance;
					change.value = 0;
					new_balance.value = balance;
				}

				idx++;
			}
		}
	});
}

function validate() {
	var warehouse = document.getElementById("warehouse").value;
	var warehouse_type = document.getElementById("warehouse_type").value;
	var balance = warehouse + '_' + warehouse_type + '_balance';
	while(1){
		product = document.getElementById("product_" + idx);
		change = document.getElementById("change_" + idx);
		new_balance = document.getElementById("product_cnt_" + idx);
		cur_balance = document.getElementById("label_" + idx);

		if(idx > 10 || null === product){
			break;
		}

		if(!product.value){
			idx++;
			continue;
		}

		if(parseInt(cur_balance.innerHTML) + parseInt(change.value) != parseInt(new_balance.value)){
			alert('產品' + product.value + '數量有誤');
			return false;
		}

		idx++;
	}
	return true;

}