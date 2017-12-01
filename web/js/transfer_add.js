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
		document.getElementById("transfer-chinese_addr").value = '廈門市同安區西柯鎮美溪道湖里園71號  郵編361100';
		document.getElementById("transfer-english_addr").value = 'No.71, Meixi Road, TongAn District, Xiamen City, Fu Jian Province, 361100';
		document.getElementById("transfer-contact").value = '林冠鳳Lin Guan Feng';
		document.getElementById("transfer-tel").value = '17750667326';
	} else if(dst.substring(0, 2) == 'tw'){
		document.getElementById("transfer-chinese_addr").value = '新北市三重區光復路一段83巷8號';
		document.getElementById("transfer-english_addr").value = ' ';
		document.getElementById("transfer-contact").value = '李偉誠';
		document.getElementById("transfer-tel").value = '+886-2999-9099';
	} else if(dst == 'padi_sydney') {
		document.getElementById("transfer-chinese_addr").value = ' ';
		document.getElementById("transfer-english_addr").value = 'PADI Asia Pacific---UNIT 3, 4 SKYLINE PLACE FRENCHS FOREST NSW 2086 AUSTRALIA';
		document.getElementById("transfer-contact").value = 'Vivian';
		document.getElementById("transfer-tel").value = '61 2 9454 2923';
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

function onchange_id() {
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


}

