
function isInt(value) {
  return !isNaN(value) && 
         parseInt(Number(value)) == value && 
         !isNaN(parseInt(value, 10));
}

$(document).ready(function() {
	$('.crewpak').click(function () {
		var $this = $(this),
			$inputs = $($this.data('target')),
			$cnts =  $($this.data('cnt'));
		var cnt = parseInt(document.getElementById($this[0].name).innerText);

		$inputs.prop('checked', this.checked);
		$cnts.val(this.checked ? cnt : 0);

	})
	$('.product').click(function () {
		var $this = $(this),
			$parent = $($this.data('target')),
			$siblings = $($this.data('sibling'));

		var cnt_input = document.getElementById('cnt_' + $this[0].name);
		var cnt = parseInt(document.getElementById($this[0].name).innerText);
		var i, check = true;

		cnt_input.value = this.checked ? cnt : 0;

		for(i = 0; i < $siblings.length; i++){
			check &= $siblings[i].checked;
		}
		$parent.prop('checked', check);
	})

	$('.cnt').keyup(function () {
		var name = this.name.substring(4);
		var cnt = parseInt(document.getElementById(name).innerText);
		var checkbox = document.getElementsByName(name)[0];
		var $parent = $(($(checkbox)).data('target'));
		var $siblings = $(($(checkbox)).data('sibling'));

		if((!isInt(this.value) && this.value !== '') || this.value > cnt){
			alert('輸入錯誤');
			this.value = 0;
		}
		if(this.value != cnt){
			checkbox.checked = false;
			$parent.prop('checked', false);
		} else {
			checkbox.checked = true;
			var i, check = true;
			for(i = 0; i < $siblings.length; i++){
				check &= $siblings[i].checked;
			}
			$parent.prop('checked', check);
		}
	})
});


$(document).ready(function() {
	var max_fields = 100; //maximum input boxes allowed
	var wrapper_ship = $(".input_fields_wrap_ship"); //Fields wrapper
	var add_button_ship = $(".add_field_button_ship"); //Add button ID
	var ship_cnt = 1; //initlal text box count

	$(add_button_ship).click(function(e){ //on add input button click
		e.preventDefault();
		if(ship_cnt < max_fields){ //max input box allowed

			var newIn = '';
			newIn += '<div><p><b>';
			newIn += 'Tracking Number:&nbsp;<input name="shipping_' + ship_cnt +'" type="text" />';
			newIn += '&nbsp;&nbsp;&nbsp;包裝:&nbsp;<input name="packing_cnt_' + ship_cnt +'" type="number" style="width:60px;" onchange="count_fee(' + ship_cnt +')" />';
			newIn += '<select name="packing_type_' + ship_cnt +'">';
			newIn += '<option value="box">箱</option>';
			newIn += '<option value="pack">包</option>';
			newIn += '</select>&nbsp;&nbsp;&nbsp;重量:&nbsp;<input name="weight_' + ship_cnt +'" type="number" step="0.01" style="width:100px;" onchange="count_fee(' + ship_cnt +')" />KG';
			newIn += '&nbsp;&nbsp;&nbsp;原始運費:&nbsp;<input name="shipping_fee_' + ship_cnt +'" type="number" step="0.01" style="width:100px;" onchange="count_fee(' + ship_cnt +')" />';
			newIn += '&nbsp;&nbsp;&nbsp;請款運費:&nbsp;<input name="req_fee_' + ship_cnt +'" type="number" step="0.01" style="width:100px;"/></b></p></div>';

			ship_cnt++; //text box increment
			$(wrapper_ship).append(newIn); //add input box
		}
	});
});

function check_missing(){

	document.getElementById('btn_submit').innerText='按過了唷';

	var check_array = document.getElementsByClassName('product'), idx = 0, missing = {}, ret;
	for(idx = 0; idx < check_array.length; idx++){
		if(!check_array[idx].checked){
			var p_name = check_array[idx].name;
			var p_cnt = parseInt(document.getElementById(p_name).innerText);
			var p_done = parseInt(document.getElementsByName('cnt_' + p_name)[0].value);

			p_name = p_name.substring(p_name.lastIndexOf('[') + 1, p_name.lastIndexOf(']'));
			missing[p_name] = missing[p_name] ? missing[p_name] + p_cnt - p_done : p_cnt - p_done;
		}
	}

	if(!jQuery.isEmptyObject(missing)){
		var msg = '確認以下missing item\n';
		for(var p in missing){
			msg += (p + ': ' + missing[p] + '\n');
		}
		ret = confirm(msg);
	}

	return ret;
}

function count_fee(idx){
	jQuery.ajax({
		// The url must be appropriate for your configuration;
		// this works with the default config of 1.1.11
		url: 'index.php?r=order/ajax-fee',
		type: "POST",

		data: {
			org_fee: document.getElementsByName("shipping_fee_" + idx)[0].value,
			region: document.getElementById("order-region").value,
			warehouse: document.getElementById("order-warehouse").value,
			weight: document.getElementsByName("weight_" + idx)[0].value,
			box: document.getElementsByName("packing_cnt_" + idx)[0].value,
			type: document.getElementById("order-ship_type").value,
		},

		error: function(xhr,tStatus,e){
			console.log(arguments);
		},
		success: function(resp){
			var req_fee = JSON.parse(resp);
			document.getElementsByName("req_fee_" + idx)[0].value = req_fee;
		}
	});
}

