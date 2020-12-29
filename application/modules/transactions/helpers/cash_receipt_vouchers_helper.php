<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
 $ci=&get_instance();

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/helpers/client_cash_receipt_vouchers_helper.php")) {
	$ci->load->helper(array('ac_vouchers/ac_vouchers',CLIENT_NAME.'/client_cash_receipt_vouchers'));
} else {
	$ci->load->helper(array('ac_vouchers/core_cash_receipt_vouchers'));
}

function list_settings(){
	return cash_receipt_list_settings();
}