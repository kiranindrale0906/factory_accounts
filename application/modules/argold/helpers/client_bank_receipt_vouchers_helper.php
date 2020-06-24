<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function list_settings() {
 $list_option=array('voucher_date','created_time','bank_name','cheque_number','voucher_number','account_name','debit_amount','narration','account_id','company_id');
  return ac_vouchers_list_settings($list_option);
}

function get_field_attribute($table, $field) {
  $required_fields=array('id','voucher_date','account_name','bank_name','cheque_number','debit_amount','narration','account_id');
  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}