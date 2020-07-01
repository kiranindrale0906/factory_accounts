$('select[name*="metal_receipt_vouchers[receipt_type]"]').on('change', function() {
    var receipt_type = $(this).val(); 
    window.location = base_url+ 'transactions/metal_receipt_vouchers?receipt_type='+receipt_type;  
  })
// $('select[name*="metal_issue_vouchers[receipt_type]"]').on('change', function() {
//     var receipt_type = $(this).val(); 
//     window.location = base_url+ 'transactions/metal_issue_vouchers?receipt_type='+receipt_type;  
//   })
$('.select_all').click(function(){
    check_metal_issue_all_checkboxes();   
  })

function check_metal_issue_all_checkboxes() {
  $('.chitti_details_id').each(function() {
    $(this).prop("checked", true);
  });
}

