

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
			newIn += '&nbsp;&nbsp;&nbsp;包裝:&nbsp;<input name="packing_cnt_' + ship_cnt +'" type="number" style="width:60px;"/>';
			newIn += '<select name="packing_type_' + ship_cnt +'">';
			newIn += '<option value="box">箱</option>';
			newIn += '<option value="pack">包</option>';
			newIn += '</select>&nbsp;&nbsp;&nbsp;重量:&nbsp;<input name="weight_' + ship_cnt +'" type="number" style="width:100px;"/>KG';
			newIn += '</select>&nbsp;&nbsp;&nbsp;運費:&nbsp;<input name="shipping_fee_' + ship_cnt +'" type="number" style="width:100px;"/></b></p></div>';

			ship_cnt++; //text box increment
			$(wrapper_ship).append(newIn); //add input box
		}
	});
});

function count_fee(idx){
	jQuery.ajax({
		// The url must be appropriate for your configuration;
		// this works with the default config of 1.1.11
		url: 'index.php?r=order/ajax-fee',
		type: "POST",

		data: {
			org_fee: document.getElementsByName("shipping_fee_" + idx)[0].value,
			region: '',
			warehouse: 'tw',
			weight: '',
			box: '',
			type: '',
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
