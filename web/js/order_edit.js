
$(document).ready(function() {
	$('.crewpak').click(function () {
		var $this = $(this),
			$inputs = $($this.data('target'));

		$inputs.prop('checked', this.checked);
	})
	$('.product').click(function () {
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
