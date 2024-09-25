<?php 
function APPLICATION_CSS($type='application'){
	$css =  array(
		CORE_PATH().'plugins/bootstrap-4.3.1/css/bootstrap.min.css',
		CORE_PATH().'plugins/bootstrap-select-1.13.10/dist/css/bootstrap-select.css',
		CORE_PATH().'plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',

		CORE_PATH().'plugins/toastr-2.1.3/toastr.min.css',

		CORE_PATH().'plugins/perfect-scrollbar-0.6.10/perfect-scrollbar.css',

		CORE_PATH().'plugins/fontawesome-pro-5.6.1-web/css/all.css',
		CORE_PATH().'plugins/slim/slim.min.css',
		CORE_PATH().'plugins/jquery-ui-1.12.1/jquery-ui.min.css',	

    CORE_PATH().'plugins/bootstrap-sweetalert/sweet-alert.css',		

		CORE_PATH().'plugins/colorpicker/color-picker.min.css',

		CORE_PATH().'plugins/chart.js-2.8.0/dist/Chart.min.css',

		CORE_PATH().'css/base.css',
		CORE_PATH().'css/style.css',
		THEME_PATH().'css/style.css',
		THEME_PATH().'css/custom.css',
	);
	return $css;
}

function APPLICATION_JS($type='application'){
	return array(
		CORE_PATH().'plugins/js/jquery-3.3.1.min.js',
		CORE_PATH().'plugins/jquery-ui-1.12.1/jquery-ui.min.js',
		CORE_PATH().'plugins/bootstrap-4.3.1/js/popper.min.js',
		CORE_PATH().'plugins/bootstrap-4.3.1/js/bootstrap.min.js',
		CORE_PATH().'plugins/printThis/printThis.js',
		CORE_PATH().'plugins/bootstrap-select-1.13.10/dist/js/bootstrap-select.min.js',
		CORE_PATH().'js/config/selectpicker.js',

		CORE_PATH().'plugins/js/moment.min.js',
		CORE_PATH().'plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js',
		CORE_PATH().'js/config/datetimepicker.js',

		CORE_PATH().'plugins/slim/slim.kickstart.min.js',
		CORE_PATH().'js/core/slimcropper.js',

		CORE_PATH().'plugins/toastr-2.1.3/toastr.min.js',
		CORE_PATH().'js/config/toastr.js',

		CORE_PATH().'plugins/jquery.scrollbar-0.2.11/jquery.scrollbar.min.js',
		CORE_PATH().'js/config/scrollbar.js',

		CORE_PATH().'plugins/colorpicker/color-picker.min.js',

		CORE_PATH().'plugins/chart.js-2.8.0/dist/Chart.min.js',		
		CORE_PATH().'js/config/chart.js',


		CORE_PATH().'js/core/hideshow.js',
		//CORE_PATH().'js/core/sidemenu.js',
		CORE_PATH().'js/core/sidebar.js',
		CORE_PATH().'js/core/truncate_text.js',

		CORE_PATH().'js/core/autocomplete.js',
		CORE_PATH().'js/core/tablefilter.js',

		CORE_PATH().'js/core/filter.js',
		CORE_PATH().'js/config/colorpicker.js',
		CORE_PATH().'js/core/ajax_library.js',
		CORE_PATH().'js/core/tablefilter.js',
		CORE_PATH().'js/sys/barcode.js',
		CORE_PATH().'plugins/firebase-7.4.0/firebase.js',
		// CORE_PATH().'js/config/firebase.js',
		//CORE_PATH().'js/tags_ajax.js',
		CORE_PATH().'js/core/modal.js',
		// THEME_PATH().'js/dashboard_js/dashboard.js',
		//CORE_PATH().'js/custom_tooltips.js',
		// THEME_PATH().'js/master/design.js',
		// THEME_PATH().'js/email_verify/email_verify.js',
		// THEME_PATH().'js/mobile_verify/mobile_verify.js',
		// THEME_PATH().'js/transactions/order.js',
		// THEME_PATH().'js/crm_module/clients.js',
		// THEME_PATH().'js/transactions/visited_clients.js',
		// THEME_PATH().'js/transactions/called_clients.js',
		THEME_PATH().'js/transactions/ac_vouchers.js',
		THEME_PATH().'js/transactions/refresh.js',
		THEME_PATH().'js/transactions/transaction_details.js',
		THEME_PATH().'js/transactions/metal_issue_vouchers.js',
		THEME_PATH().'js/calculator/calculator.js',
		THEME_PATH().'js/ar_gold/metal_vouchers.js',
		THEME_PATH().'js/reports/trial_balance/trial_balance.js',
		THEME_PATH().'js/ar_gold/production_summary.js',
		THEME_PATH().'js/base.js',
		THEME_PATH().'js/table_row_toggle.js',
	);
}

?>