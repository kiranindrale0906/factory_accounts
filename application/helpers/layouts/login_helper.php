<?php 
function LOGIN_CSS($type='login'){
	return array(		
		CORE_PATH().'plugins/bootstrap-4.3.1/css/bootstrap.min.css',
		CORE_PATH().'plugins/toastr-2.1.3/toastr.min.css',

		LOGIN_PATH().'css/base.css',
		LOGIN_PATH().'css/style.css'

	);
}

function LOGIN_JS($type='login'){
	return array(
		CORE_PATH().'plugins/js/jquery-3.3.1.min.js',
		CORE_PATH().'plugins/jquery-ui-1.12.1/jquery-ui.min.js',
		CORE_PATH().'plugins/bootstrap-4.3.1/js/popper.min.js',
		CORE_PATH().'plugins/bootstrap-4.3.1/js/bootstrap.min.js'
	);
}

?>