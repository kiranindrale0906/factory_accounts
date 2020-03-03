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