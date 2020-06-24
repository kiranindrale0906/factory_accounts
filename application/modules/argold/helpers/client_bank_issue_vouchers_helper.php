<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function list_settings() {
  $list_option=array('voucher_date','created_time','voucher_number','account_name','credit_amount','bank_name','cheque_number','narration','account_id','company_id','created_time');
  return ac_vouchers_list_settings($list_option);
}

function get_field_attribute($table, $field) {
   $required_fields=array('id','voucher_date','account_name','bank_name','cheque_number','credit_amount','narration','account_id');
  return ac_voucher_get_field_attribute($table, $field, $required_fields);
}
