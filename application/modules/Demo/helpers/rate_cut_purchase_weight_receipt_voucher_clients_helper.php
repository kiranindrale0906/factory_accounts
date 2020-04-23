<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function rate_cut_purchase_weight_receipt_voucher_clients_getTableSettings() {
  $table_setting=array('page_title'=>'Rate Cut Purchase Weight Receipt Voucher','where'=>'voucher_type="rate cut purchase weight receipt voucher"');
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



function rate_cut_purchase_weight_receipt_voucher_clients_list_settings() {
  $list_option=array('voucher_date','created_time','gold_rate','gold_rate_purity','voucher_number','account_name','amount','debit_weight','transaction_type','narration','account_id','company_id');
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

function rate_cut_purchase_weight_receipt_voucher_clients_get_field_attribute($table, $field) {
  $required_fields=array('id','voucher_date','account_name','gold_rate','gold_rate_purity','debit_weight','amount','transaction_type','narration','account_id');

  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}

function rate_cut_purchase_weight_receipt_voucher_clients_get_row_actions($row, $url, $select_url, $filter) {
  return ac_vouchers_get_row_actions($row, $url, $select_url, $filter);
}