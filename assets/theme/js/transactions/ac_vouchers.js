
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

function calculate_fine_factory_fine() {
	var debit_wt=$(".debit_weight").val();
	var purity = $(".purity").val();
	var factory_purity = $(".factory_purity").val();

	if(isNaN(debit_wt)) debit_wt=0;
	if(isNaN(purity) || purity==undefined ) purity=0;
	if(isNaN(factory_purity) || factory_purity==undefined || factory_purity=="") factory_purity=0;


	var fine = parseFloat(debit_wt) * parseFloat(purity)/100;
	if(isNaN(fine)) fine=0;
	$(".fine").val(fine.toFixed(2));

	var factory_fine = parseFloat(debit_wt) * parseFloat(factory_purity)/100;
	if(isNaN(factory_fine)) factory_fine=0;
	$(".factory_fine").val(factory_fine.toFixed(2));
	//console.log(factory_fine);
}