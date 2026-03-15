<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function contra_voucher_clients_getTableSettings() {
  $table_setting=array('page_title'=>'Contra Voucher','where'=>'voucher_type="contra voucher"');
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



function contra_voucher_clients_list_settings() {
  $list_option=array('voucher_date','created_time','voucher_number','from_account_name','account_name','from_group_name','to_group_name','amount','narration','account_id','from_account_id','from_group_id','to_group_id','company_id','created_time');
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

function contra_voucher_clients_get_field_attribute($table, $field) {
  $required_fields=array('id','voucher_date','account_name','from_account_name','account_name','from_group_name','to_group_name','amount','narration','account_id','from_account_id','from_group_id','to_group_id');

  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}

function contra_voucher_clients_get_row_actions($row, $url, $select_url, $filter) {
  return ac_voucher_get_row_actions($row,$url,$select_url,$filter);
}