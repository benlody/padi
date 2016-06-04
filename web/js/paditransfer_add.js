$(document).ready(function() {
	var max_fields = 100; //maximum input boxes allowed
	var wrapper_packing = $(".input_fields_wrap_packing"); //Fields wrapper
	var add_button_packing = $(".add_field_button_packing"); //Add button ID
	var wrapper_product = $(".input_fields_wrap_product"); //Fields wrapper
	var add_button_product = $(".add_field_button_product"); //Add button ID
	
	var packing_cnt = 1; //initlal text box count
	var product_cnt = 1; //initlal text box count
	$(add_button_packing).click(function(e){ //on add input button click
		e.preventDefault();
		if(packing_cnt < max_fields){ //max input box allowed
			jQuery.ajax({
				// The url must be appropriate for your configuration;
				// this works with the default config of 1.1.11
				url: 'index.php?r=packing/ajax-list',
				type: "POST",
				error: function(xhr,tStatus,e){
					console.log(arguments);
				},
				success: function(resp){
					var packing_list = JSON.parse(resp);
					var newIn = '<div><select class="form-group" name="packing_' + packing_cnt + '" id="packing_' + packing_cnt + '" onchange="get_packing(this,' + packing_cnt + ')"><option value=""></option>'
					for	(idx = 0; idx < packing.length; idx++) {
						newIn += '<option value="';
						newIn += packing[idx];
						newIn += '">';
						newIn += packing[idx];
						newIn += '</option>';
					}
					newIn += '</select>';

					newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;qty per Box:</label><label id="label_qty_' + packing_cnt + '"></label>';
					newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Net Weight per Box:</label><label id="label_weight_' + packing_cnt + '"></label>';
					newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Measurement:</label><label id="label_measurement_' + packing_cnt + '"></label>';
					newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Box:&nbsp;</label><input type="number" name="box_' + packing_cnt + 
								'" id="box_' + packing_cnt + '" value="0" onchange="box_hook(this.value,' + packing_cnt + ')">';
					newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total:</label><label id="label_total_' + packing_cnt + '"></label>';
					newIn += '</div>';

					packing_cnt++; //text box increment
					$(wrapper_packing).append(newIn); //add input box
				}
			});
		}
	});

	$(add_button_product).click(function(e){ //on add input button click
		e.preventDefault();
		if(product_cnt < max_fields){ //max input box allowed
			jQuery.ajax({
				// The url must be appropriate for your configuration;
				// this works with the default config of 1.1.11
				url: 'index.php?r=product/ajax-list',
				type: "POST",
				error: function(xhr,tStatus,e){
					console.log(arguments);
				},
				success: function(resp){

					var product_list = JSON.parse(resp);
					var newIn = '<div><select class="form-group" name="product_' + product_cnt + '" id="product_' + packing_cnt + '"><option value=""></option>'
					for	(idx = 0; idx < product.length; idx++) {
						newIn += '<option value="';
						newIn += product[idx];
						newIn += '">';
						newIn += product[idx];
						newIn += '</option>';
					}
					newIn += '</select>';

					newIn += '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qty:&nbsp;</label><input type="number" name="mix_' + product_cnt + 
						'" id="mix_' + product_cnt + '" value="0">';


					product_cnt++; //text box increment
					$(wrapper_product).append(newIn); //add input box
				}
			});
		}
	});
});


function onchange_id() {
	/*
	var id = document.getElementById("transfer-id").value;
	console.log(id);

	jQuery.ajax({
		// The url must be appropriate for your configuration;
		// this works with the default config of 1.1.11
		url: 'index.php?r=transfer/check-exist',
		type: "POST",
		data:{
			id: id
		},
		error: function(xhr,tStatus,e){
			console.log(arguments);
		},
		success: function(resp){
			if(resp == 0){
				alert('編號已存在 請重新輸入');
				document.getElementById("transfer-id").value = '';
			}
		}
	});

*/
}

function get_packing(sel, idx) {

	jQuery.ajax({
		// The url must be appropriate for your configuration;
		// this works with the default config of 1.1.11
		url: 'index.php?r=packing/ajax-get',
		type: "POST",
		data: {
			id: sel.value
		},
		error: function(xhr,tStatus,e){
			console.log(arguments);
		},
		success: function(resp){
			var ret = JSON.parse(resp);
			document.getElementById("label_qty_" + idx).innerHTML = ret['qty'];
			document.getElementById("label_weight_" + idx).innerHTML = ret['net_weight'];
			document.getElementById("label_measurement_" + idx).innerHTML = ret['measurement'];

		}
	});
}

function box_hook(val, idx){
	document.getElementById("label_total_" + idx).innerHTML = parseInt(document.getElementById("label_qty_" + idx).innerHTML) * parseInt(val);

}
