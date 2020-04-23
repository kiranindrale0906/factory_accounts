
$(".credit_weight").on('keyup', function() {
	calculate_fine_factory_fine();
});

$(".debit_weight").on('keyup', function() {
	calculate_fine_factory_fine();
});

$(".purity").on('keyup', function() {
	 calculate_fine_factory_fine();
});

$(".factory_purity").on('keyup', function() {
	 calculate_fine_factory_fine();
});
$('input[name*="purchase_price_issue_vouchers"').on('keyup', function() {
	 calculate_purchase_price_issue_vouchers();
});
$('input[name*="purchase_weight_issue_vouchers"').on('keyup', function() {
	 calculate_purchase_weight_issue_vouchers();
});
$('input[name*="purchase_price_receipt_vouchers"').on('keyup', function() {
	 calculate_purchase_price_receipt_vouchers();
});
$('input[name*="purchase_weight_receipt_vouchers"').on('keyup', function() {
	 calculate_purchase_weight_receipt_vouchers();
});

function calculate_fine_factory_fine() {
	var debit_wt=$(".debit_weight").val();
	var credit_wt=$(".credit_weight").val();
	var purity = $(".purity").val();
	var factory_purity = $(".factory_purity").val();


	if(isNaN(debit_wt)) debit_wt=0;
	if(isNaN(credit_wt)) credit_wt=0;
	if(isNaN(purity) || purity==undefined ) purity=0;
	if(isNaN(factory_purity) || factory_purity==undefined || factory_purity=="") factory_purity=0;


	var fine = (parseFloat(credit_wt) + parseFloat(debit_wt)) * parseFloat(purity)/100;
	if(isNaN(fine)) fine=0;
	$(".fine").val(fine.toFixed(4));

	var factory_fine = (parseFloat(credit_wt) + parseFloat(debit_wt)) * parseFloat(factory_purity)/100;
	if(isNaN(factory_fine)) factory_fine=0;
	$(".factory_fine").val(factory_fine.toFixed(4));
	calculate_arg_weight();
}


function calculate_factory_purity(index) {
	var credit_wt=$("#credit_weight_"+index).val();
	var factory_purity = $("#factory_purity_"+index).val();
	if(isNaN(credit_wt)) credit_wt=0;
	if(isNaN(factory_purity) || factory_purity==undefined ) factory_purity=0;
	var fine = parseFloat(credit_wt) * parseFloat(factory_purity)/100;
	if(isNaN(fine)) fine=0;
	$("#factory_fine_"+index).val(fine.toFixed(4));
	calculate_arg_weight();
}

function calculate_arg_weight() {
	var total_weight=0;
	if($("#arg_weight").length>0) {
		var total_issue_weight=0;
		var receipt_weight = $(".debit_weight").val();
		if(isNaN(receipt_weight)) receipt_weight=0;	
		console.log(receipt_weight+'receipt_weight');

		$('.issue_credit_weight').each(function(){
		  total_issue_weight += parseFloat($(this).val()); 
		});
		
		if(isNaN(total_issue_weight)) total_issue_weight=0;
		total_weight=parseFloat(receipt_weight) - parseFloat(total_issue_weight);
		if(isNaN(total_weight)) total_weight=0;
		$("#arg_weight").val(total_weight.toFixed(4));
	}
}

function calculate_purchase_price_issue_vouchers() {
    var gold_rate = $('input[name*="purchase_price_issue_vouchers[gold_rate]"]').val();
    var gold_rate_purity = $('input[name*="purchase_price_issue_vouchers[gold_rate_purity]"]').val();
    var gold_weight = $('input[name*="purchase_price_issue_vouchers[gold_weight]"]').val();
    var gold_weight_purity = $('input[name*="purchase_price_issue_vouchers[gold_weight_purity]"]').val();
    var calculated_result = 0;
        gold_rate = gold_rate / 10;
        var rate_pure_gold = (gold_rate / gold_rate_purity) * 100;
        var gold_weight_pure_gold = (gold_weight * gold_weight_purity) / 100;
        calculated_result = (rate_pure_gold * gold_weight_pure_gold) / 100;
    
    $('input[name*="purchase_price_issue_vouchers[credit_amount]').val(calculated_result);
}

function calculate_purchase_price_receipt_vouchers() {
    var gold_rate = $('input[name*="purchase_price_receipt_vouchers[gold_rate]"]').val();
    var gold_rate_purity = $('input[name*="purchase_price_receipt_vouchers[gold_rate_purity]"]').val();
    var gold_weight = $('input[name*="purchase_price_receipt_vouchers[gold_weight]"]').val();
    var gold_weight_purity = $('input[name*="purchase_price_receipt_vouchers[gold_weight_purity]"]').val();
    var calculated_result = 0;
        gold_rate = gold_rate / 10;
        var rate_pure_gold = (gold_rate / gold_rate_purity) * 100;
        var gold_weight_pure_gold = (gold_weight * gold_weight_purity) / 100;
        calculated_result = (rate_pure_gold * gold_weight_pure_gold) / 100;
    
    $('input[name*="purchase_price_receipt_vouchers[debit_amount]').val(calculated_result);
}

function calculate_purchase_weight_issue_vouchers() {
	var gold_rate = $('input[name*="purchase_weight_issue_vouchers[gold_rate]"]').val();
	var gold_rate_purity = $('input[name*="purchase_weight_issue_vouchers[gold_rate_purity]"]').val();
	var amount = $('input[name*="purchase_weight_issue_vouchers[amount]"]').val();
	var calculated_result = 0;
	gold_weight_purity = 100.00;
    amount = amount * 100;
    gold_rate = gold_rate / 10;
    var rate_pure_gold = (gold_rate / gold_rate_purity) * 100;
    calculated_result = (amount / rate_pure_gold) / gold_weight_purity * 100;
    $('input[name*="purchase_weight_issue_vouchers[credit_weight]').val(calculated_result);
}

function calculate_purchase_weight_receipt_vouchers() {
	var gold_rate = $('input[name*="purchase_weight_receipt_vouchers[gold_rate]"]').val();
	var gold_rate_purity = $('input[name*="purchase_weight_receipt_vouchers[gold_rate_purity]"]').val();
	var amount = $('input[name*="purchase_weight_receipt_vouchers[amount]"]').val();
	var calculated_result = 0;
	gold_weight_purity = 100.00;
    amount = amount * 100;
    gold_rate = gold_rate / 10;
    var rate_pure_gold = (gold_rate / gold_rate_purity) * 100;
    calculated_result = (amount / rate_pure_gold) / gold_weight_purity * 100;
    
    $('input[name*="purchase_weight_receipt_vouchers[debit_weight]').val(calculated_result);
}

function delete_purchase_voucher(index){
  $("input[name*='table_purchase_voucher["+index+"][delete]']").val(1);
  $("tr.table_purchase_voucher_"+index).remove();
}

function delete_sales_voucher(index){
  $("input[name*='table_sales_voucher["+index+"][delete]']").val(1);
  $("tr.table_sales_voucher_"+index).remove();
}

function delete_sales_return_voucher(index){
  $("input[name*='table_sales_return_voucher["+index+"][delete]']").val(1);
  $("tr.table_sales_return_voucher_"+index).remove();
}
function delete_repair_voucher(index){
  $("input[name*='table_repair_voucher["+index+"][delete]']").val(1);
  $("tr.table_repair_voucher_"+index).remove();
}
function delete_opening_stock_voucher(index){
  $("input[name*='table_opening_stock_voucher["+index+"][delete]']").val(1);
  $("tr.table_opening_stock_voucher_"+index).remove();
}
function delete_approval_voucher(index){
  $("input[name*='table_approval_voucher["+index+"][delete]']").val(1);
  $("tr.table_approval_voucher_"+index).remove();
}

$(document).on("change", ".gross_weight", function() {
    var sum = 0;
    $(".gross_weight").each(function(){
        sum += +$(this).val();
    });
    $(".get_total_gross_weight").val(sum);
});
$(document).on("change", ".net_weight", function() {
    var sum = 0;
    $(".net_weight").each(function(){
        sum += +$(this).val();
    });
    $(".get_total_net_weight").val(sum);
});
$(document).on("change", ".melting, .gross_weight", function() {
    var sum = 0;
    var melting = 0;
    var melting_percent = 0;
    var gross_weight = 0;
    var length = 0;

    $(".melting").each(function(i){
        melting += +$(this).val();
        length=i+1;
    });
    $(".gross_weight").each(function(){
        gross_weight += +$(this).val();
    });
    melting_percent=(melting/length);
    sum=gross_weight*melting_percent/100

    $(".get_total_fine_weight").val(sum);
});


$(document).on("change", ".melting, .gross_weight", function() {
    var sum = 0;
    var melting = 0;
    var melting_percent = 0;
    var gross_weight = 0;
    var length = 0;

    $(".melting").each(function(i){
        melting += +$(this).val();
        length=i+1;
    });
    $(".gross_weight").each(function(){
        gross_weight += +$(this).val();
    });
    melting_percent=(melting/length);
    sum=gross_weight*melting_percent/100

    $(".get_total_fine_weight").val(sum);
});

$(document).on("change", ".net_weight, .labour_rate,.other_charges", function() {
    var sum = 0;
    var net_weight = 0;
    var melting_percent = 0;
    var labour_rate = 0;
    var other_charges = 0;

    $(".net_weight").each(function(){
        net_weight += +$(this).val();
    });
    $(".labour_rate").each(function(){
        labour_rate += +$(this).val();
    }); 
    $(".other_charges").each(function(){
        other_charges += +$(this).val();
    });

    sum=(net_weight*labour_rate)+other_charges;

    $(".get_total_amount").val(sum);
});

$(document).on('keypress',function(e) {
    if(e.which == 13) {
        var url = $('button.ajax_post').closest('form').attr('action');
        var formData = new FormData($('button.ajax_post').closest('form')[0]);
        ajax_post_request(url, formData);
    }
});



