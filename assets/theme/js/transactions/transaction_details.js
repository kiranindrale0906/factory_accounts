function delete_transaction_detail(index) {
  $("input[name*='transaction_details["+index+"][delete]']").val(1);
  $("tr.transaction_details_"+index).hide();
}

function set_company_session() {
	var company_id=$("#set_company_id").val();
	var base_url=$("#base_url").val();
	var url=base_url+'masters/company/index';
	var formdata=new FormData();
	formdata.append('set_company_id',company_id);
	ajax_post_request(url,formdata);
}

$(document).ready(function(){
	$('.hide_daily_drawer_type').hide();
});


//$("input[name*='metal_receipt_vouchers[receipt_type]']").change(function() {
$(".receipt_type").on('change', function() {
	var receipt_type=$(this).val();
	if(receipt_type=="Daily Drawer") {
		$('.hide_daily_drawer_type').show();	
	}
	else
		$('.hide_daily_drawer_type').hide();	 
});