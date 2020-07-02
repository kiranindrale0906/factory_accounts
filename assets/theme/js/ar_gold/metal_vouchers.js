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

$('select[name*="metal_issue_vouchers[narration]"').on('change', function() {
  calculate_metal_issue_purity();
});

$('select[name*="metal_issue_vouchers[purity]"').on('change', function() {
  calculate_metal_issue_purity();
});

function check_metal_issue_all_checkboxes() {
  $('.chitti_details_id').each(function() {
    $(this).prop("checked", true);
  });
}


function calculate_metal_issue_purity() {
  item_name = $('select[name*="metal_issue_vouchers[narration]"').val();
  chain_purity = $('select[name*="metal_issue_vouchers[purity]"').val();
  issue_purity = parseFloat(narrations[item_name]['chain_margin']) + parseFloat(chain_purity);
  $('input[name*="metal_issue_vouchers[factory_purity]"').val(issue_purity);
  calculate_fine_factory_fine();
}