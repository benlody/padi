$(document).ready(function() {
	var max_fields = 100; //maximum input boxes allowed
	var wrapper_product = $(".input_fields_wrap_product"); //Fields wrapper
	var add_button_product = $(".add_field_button_product"); //Add button ID
	
	var product_cnt = 1; //initlal text box count
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
					var newIn = '<div><select class="form-group" name="product_' + product_cnt +'"><option value=""></option>'
					for	(idx = 0; idx < product.length; idx++) {
						newIn += '<option value="';
						newIn += product[idx];
						newIn += '">';
						newIn += product[idx];
						newIn += '</option>';
					}
					newIn += '</select>';
					newIn += '<label>/</label><input type="number" name="product_cnt_';
					newIn += product_cnt;
					newIn += '" value="0"></div>';
					product_cnt++; //text box increment
					$(wrapper_product).append(newIn); //add input box
				}
			});
		}
	});
});

function onchange_dst() {
	var dst = document.getElementById("dst_warehouse").value;
	var src = document.getElementById("src_warehouse").value;

	if(dst.substring(0, 2) == 'xm'){
		document.getElementById("transfer-chinese_addr").value = '厦门市火炬东路28号';
		document.getElementById("transfer-english_addr").value = 'No.28, Huoju East Road, Huli, Xiamen, Fujian, China';
		document.getElementById("transfer-contact").value = '李美紅';
		document.getElementById("transfer-tel").value = '0592-2087596/15396270698';
	} else if(dst.substring(0, 2) == 'tw'){
		document.getElementById("transfer-chinese_addr").value = '新北市三重區光復路一段83巷8號';
		document.getElementById("transfer-english_addr").value = ' ';
		document.getElementById("transfer-contact").value = '陳學輝';
		document.getElementById("transfer-tel").value = '+886-2331-4526';
	} else if(dst == 'padi_sydney') {
		document.getElementById("transfer-chinese_addr").value = ' ';
		document.getElementById("transfer-english_addr").value = 'PADI Asia Pacific---UNIT 3, 4 SKYLINE PLACE FRENCHS FOREST NSW 2086 AUSTRALIA';
		document.getElementById("transfer-contact").value = 'Norman';
		document.getElementById("transfer-tel").value = '61 2 9454 2923';
	}

	if(dst.substring(0, 2) == src.substring(0, 2)){
		document.getElementById("ship_type").value = 'internal';
	} else {
		document.getElementById("ship_type").value = '';
	}
}

function onchange_src() {
	var dst = document.getElementById("dst_warehouse").value;
	var src = document.getElementById("src_warehouse").value;

	if(dst.substring(0, 2) == src.substring(0, 2)){
		document.getElementById("ship_type").value = 'internal';
	} else {
		document.getElementById("ship_type").value = '';
	}
}