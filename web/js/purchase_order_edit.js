
function check_cnt() {
	var self_cnt = parseInt(document.getElementsByName('self_cnt')[0].value);
	var padi_cnt = parseInt(document.getElementsByName('padi_cnt')[0].value);
	var print_cnt = parseInt(document.getElementsByName('print_cnt')[0].value);
	if(self_cnt + padi_cnt !== print_cnt){
		alert('數量輸入錯誤, 入庫數量與生產數量不符');
		return false;
	}
	return true;
}
