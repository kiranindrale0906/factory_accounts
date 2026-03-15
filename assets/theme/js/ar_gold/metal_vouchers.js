$('select[name*="metal_receipt_vouchers[receipt_type]"]').on('change', function() {
    var receipt_type = $(this).val(); 
    refresh_id='';
    parent_id='';
    var refresh_id = $('#refresh_id').val(); 
    var parent_id = $('#parent_id').val(); 
    if(refresh_id!=''){
      refresh_id='&refresh_id='+refresh_id;
    }if(parent_id!=''){
      parent_id='&parent_id='+parent_id;
    }
    window.location = base_url+ 'transactions/metal_receipt_vouchers?receipt_type='+receipt_type+refresh_id+parent_id;  
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

// function calculate_taxable_amount(index) {
//   alert(index);
//   // var rate=$("#rate_"+index).val();
//   // var quantity = $("#quantity_"+index).val();
//   // if(isNaN(rate)) rate=0;
//   // if(isNaN(quantity) || quantity==undefined ) quantity=0;
//   // var amount = parseFloat(rate) * parseFloat(quantity);
//   // if(isNaN(amount)) amount=0;
//   // $("#taxable_amount_"+index).val(fine.toFixed(4));
//   // calculate_total_taxable_amount();
// }


function calculate_metal_issue_purity() {
  item_name = $('select[name*="metal_issue_vouchers[narration]"').val();
  chain_purity = $('select[name*="metal_issue_vouchers[purity]"').val();
  issue_purity = parseFloat(narrations[item_name]['chain_margin']) + parseFloat(chain_purity);
  $('input[name*="metal_issue_vouchers[factory_purity]"').val(issue_purity);
  calculate_fine_factory_fine();
}