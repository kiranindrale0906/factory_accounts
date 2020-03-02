function delete_transaction_detail(index) {
  $("input[name*='transaction_details["+index+"][delete]']").val(1);
  $("tr.transaction_details_"+index).hide();
}