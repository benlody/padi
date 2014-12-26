
$(document).ready(function() {
	$('.crewpak').click(function () {
		var $this = $(this),
			$inputs = $($this.data('target'));

		$inputs.prop('checked', this.checked);
	})
	$('.ship').click(function () {
		var $this = $(this),
			$parent = $($this.data('target')),
			$siblings = $($this.data('sibling'));
		var i, check = true;

		for(i = 0; i < $siblings.length; i++){
			check &= $siblings[i].checked;
		}
		$parent.prop('checked', check);
		
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