<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function bank_issue_voucher_clients_getTableSettings() {
  $table_setting=array('page_title'=>'Bank Issue Voucher','where'=>'voucher_type="bank issue voucher"');
  return ac_vouchers_getTableSettings($table_setting);
}
//Add bank Issue Voucher
/*
  0 => column title
  1 => column name
  2 => order flag
  3 => order column
  4 => filter flag
  5 => expand text flag
  6 => select column
*/



function bank_issue_voucher_clients_list_settings() {
  $list_option=array('voucher_date','created_time','voucher_number','account_name','debit_amount','bank_name','cheque_number','narration','account_id','company_id','created_time');
  return ac_vouchers_list_settings($list_option);
}


/*
  | [0] => Label
  | [1] => Placeholder
  | [2] => Mandatory/Not Mandatory
  | [3] => Class
  | [4] => Autofocus
  | [5] => Readonly
  | [6] => disabled
*/

function bank_issue_voucher_clients_get_field_attribute($table, $field) {
  $required_fields=array('id','voucher_date','account_name','bank_name','cheque_number','debit_amount','narration','account_id');

  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}

function bank_issue_voucher_clients_get_row_actions($row, $url, $select_url, $filter) {
  return ac_voucher_get_row_actions($row,$url,$select_url,$filter);
}