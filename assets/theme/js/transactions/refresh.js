function calculate_refresh_purity(index) {
	var credit_wt=$("#refesh_weight_"+index).val();
	var purity = $("#refresh_purity_"+index).val();
  	if(isNaN(credit_wt)) credit_wt=0;
  	if(isNaN(purity) || purity==undefined ) purity=0;
  	var fine = parseFloat(credit_wt) * parseFloat(purity)/100;
  	if(isNaN(fine)) fine=0;
  	$("#refesh_fine_"+index).val(fine.toFixed(4));
    calculate_refresh_total_weight();
    calculate_refresh_total_fine();
    calculate_refresh_avg_purity();
}
function calculate_refresh_factory_purity(index) {
  var credit_wt=$("#refesh_weight_"+index).val();
  var purity = $("#refresh_factory_purity_"+index).val();
    if(isNaN(credit_wt)) credit_wt=0;
    if(isNaN(purity) || purity==undefined ) purity=0;
    var fine = parseFloat(credit_wt) * parseFloat(purity)/100;
    if(isNaN(fine)) fine=0;
    $("#refesh_factory_fine_"+index).val(fine.toFixed(4));
    calculate_refresh_total_factory_fine();
    calculate_refresh_avg_factory_purity();
}

function calculate_refresh_total_weight() {
  var total_weight=0;
  if($('input[name*="refresh[weight]"]').length>0) {
    var total_weight=0;
    var weight = $(".weight").val();
    if(isNaN(weight)) weight=0; 
    console.log(weight+'weight');

    $('.refresh_weight').each(function(){
      total_weight += parseFloat($(this).val()); 
    });
    
    if(isNaN(total_weight)) total_weight=0;
    total_weight=parseFloat(total_weight);
    if(isNaN(total_weight)) total_weight=0;
    $('input[name*="refresh[weight]"]').val(total_weight.toFixed(4));
  }
}
function calculate_refresh_total_fine() {
  var total_fine=0;
  if($('input[name*="refresh[fine]"]').length>0) {
    var total_weight=0;
    var fine = $(".fine").val();
    if(isNaN(fine)) fine=0; 
    console.log(fine+'fine');

    $('.refresh_fine').each(function(){
      total_fine += parseFloat($(this).val()); 
    });
    
    if(isNaN(total_fine)) total_fine=0;
    total_fine=parseFloat(total_fine);
    if(isNaN(total_fine)) total_fine=0;
    $('input[name*="refresh[fine]"]').val(total_fine.toFixed(4));
  }
}
function calculate_refresh_avg_purity() {
   weight=$('input[name*="refresh[weight]"]').val();
   fine=$('input[name*="refresh[fine]"]').val();
   total_purity=(fine/weight)*100;
  $('input[name*="refresh[purity]"]').val(total_purity.toFixed(4));
}
function calculate_refresh_total_factory_fine() {
  var total_factory_fine=0;
  if($('input[name*="refresh[factory_fine]"]').length>0) {
    var total_weight=0;
    var factory_fine = $(".factory_fine").val();
    if(isNaN(factory_fine)) factory_fine=0; 
    console.log(factory_fine+'factory_fine');

    $('.refresh_factory_fine').each(function(){
      total_factory_fine += parseFloat($(this).val()); 
    });
    
    if(isNaN(total_factory_fine)) total_factory_fine=0;
    total_factory_fine=parseFloat(total_factory_fine);
    if(isNaN(total_factory_fine)) total_factory_fine=0;
    $('input[name*="refresh[factory_fine]"]').val(total_factory_fine.toFixed(4));
  }
}
function calculate_refresh_avg_factory_purity() {
   weight=$('input[name*="refresh[weight]"]').val();
   fine=$('input[name*="refresh[factory_fine]"]').val();
   total_purity=(fine/weight)*100;
	$('input[name*="refresh[factory_purity]"]').val(total_purity.toFixed(4));
}
