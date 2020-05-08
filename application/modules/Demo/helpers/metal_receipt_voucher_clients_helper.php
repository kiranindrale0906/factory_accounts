<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function metal_receipt_voucher_clients_getTableSettings() {
  $table_setting=array('page_title'=>'Metal Receipt Voucher','where'=>'voucher_type="metal receipt voucher"');
  return ac_vouchers_getTableSettings($table_setting);
}
//Add Cash Issue Voucher
/*
  0 => column title
  1 => column name
  2 => order flag
  3 => order column
  4 => filter flag
  5 => expand text flag
  6 => select column
*/



function metal_receipt_voucher_clients_list_settings() {
  $list_option=array('voucher_date','created_time','voucher_number','account_name','purity','credit_weight','narration','account_id','company_id');
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

function metal_receipt_voucher_clients_get_field_attribute($table, $field) {
  $required_fields=array('id','voucher_date','account_name','credit_weight','narration','account_id','purity');

  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}

function metal_receipt_voucher_clients_get_row_actions($row, $url, $select_url, $filter) {
  return ac_vouchers_get_row_actions($row, $url, $select_url, $filter);
}