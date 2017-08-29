
$(document).ready(function() {
	var max_fields = 100; //maximum input boxes allowed
	var wrapper_product = $(".input_fields_wrap_product"); //Fields wrapper
	var add_button_product = $(".add_field_button_product"); //Add button ID

	var product_cnt = 0; //initlal text box count

	while(document.getElementsByName("product_" + product_cnt).length > 0){
		product_cnt++;
	}

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


