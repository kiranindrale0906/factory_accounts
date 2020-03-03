<?php defined('BASEPATH') OR exit('No direct script access allowed.');
$ci=&get_instance();
$ci->load->helper(array('ac_vouchers/ac_vouchers'));

function getTableSettings() {
  $table_setting=array('page_title'=>'Cash Receipt Voucher','where'=>'voucher_type="cash receipt voucher" 
                                                                      company_id='.@$_SESSION['company_id']);
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



function list_settings() {
  $list_option=array('voucher_date','voucher_number','account_name','debit_amount','narration','action');
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

function get_field_attribute($table, $field) {
  $required_fields=array('id','voucher_date','account_name','debit_amount','narration','vouchersamount',
                        'company_id','account_id','document');

  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}

function get_row_actions($row, $url, $select_url, $filter) {
  return ac_voucher_get_row_actions($row,$url,$select_url,$filter);
}