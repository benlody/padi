
$(document).ready(function() {
	var max_fields = 100; //maximum input boxes allowed
	var wrapper_crewpak = $(".input_fields_wrap_crewpak"); //Fields wrapper
	var add_button_crewpak = $(".add_field_button_crewpak"); //Add button ID
	var wrapper_product = $(".input_fields_wrap_product"); //Fields wrapper
	var add_button_product = $(".add_field_button_product"); //Add button ID
	
	var crew_cnt = 0; //initlal text box count
	var product_cnt = 0; //initlal text box count
	while(document.getElementsByName("crew_pak_" + crew_cnt).length > 0){
		crew_cnt++;
	}
	while(document.getElementsByName("product_" + product_cnt).length > 0){
		product_cnt++;
	}
	$(add_button_crewpak).click(function(e){ //on add input button click
		e.preventDefault();
		if(crew_cnt < max_fields){ //max input box allowed
			var newIn = '<div><select class="form-group" name="crew_pak_' + crew_cnt +'"><option value=""></option>'
			for	(idx = 0; idx < crewpak.length; idx++) {
				newIn += '<option value="';
				newIn += crewpak[idx];
				newIn += '">';
				newIn += crewpak[idx];
				newIn += '</option>';
			}
			newIn += '</select>';
			newIn += '<input type="number" name="crew_pak_cnt_';
			newIn += crew_cnt;
			newIn += '" value="0"></div>';
			crew_cnt++; //text box increment
			$(wrapper_crewpak).append(newIn); //add input box
		}
	});    
	$(add_button_product).click(function(e){ //on add input button click
		e.preventDefault();
		if(product_cnt < max_fields){ //max input box allowed
			var newIn = '<div><select class="form-group" name="product_' + product_cnt +'"><option value=""></option>'
			for	(idx = 0; idx < product.length; idx++) {
				newIn += '<option value="';
				newIn += product[idx];
				newIn += '">';
				newIn += product[idx];
				newIn += '</option>';
			}
			newIn += '</select>';
			newIn += '<input type="number" name="product_cnt_';
			newIn += product_cnt;
			newIn += '" value="0"></div>';
			product_cnt++; //text box increment
			$(wrapper_product).append(newIn); //add input box
		}
	});
});


function fill_customer_info() {
	var customer_id = document.getElementById("customer_id").value;

	jQuery.ajax({
		// The url must be appropriate for your configuration;
		// this works with the default config of 1.1.11
		url: 'index.php?r=customer/ajax-get',
		type: "POST",
		data: {customer_id: customer_id},
		error: function(xhr,tStatus,e){
			console.log(arguments);
		},
		success: function(resp){
			var cus_info = JSON.parse(resp);
			document.getElementById("order-chinese_addr").value = cus_info.chinese_addr;
			document.getElementById("order-english_addr").value = cus_info.english_addr;
			document.getElementById("order-contact").value = cus_info.contact;
			document.getElementById("order-tel").value = cus_info.tel;
			document.getElementById("order-region").value = cus_info.region;
		}
	});
}