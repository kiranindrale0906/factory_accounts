function delete_metal_issue_voucher(index){
  $("input[name*='table_metal_issue_voucher["+index+"][delete]']").val(1);
  $("tr.table_metal_issue_voucher_"+index).hide();
}

// function delete_purchase_voucher(index){
//   $("input[name*='table_purchase_voucher["+index+"][delete]']").val(1);
//   $("tr.table_purchase_voucher_"+index).hide();
// }