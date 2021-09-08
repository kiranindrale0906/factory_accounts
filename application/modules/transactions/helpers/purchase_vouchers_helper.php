<?php defined('BASEPATH') OR exit('No direct script access allowed.');


$ci=&get_instance();
$ci->load->helper(array('ac_vouchers/ac_vouchers',
                        CLIENT_NAME.'/purchase_voucher_clients'));

function getTableSettings() {
  return purchase_voucher_clients_getTableSettings();
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
  return purchase_voucher_clients_list_settings();
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
  return purchase_voucher_clients_get_field_attribute($table, $field);
}

function get_row_actions($row, $url, $select_url, $filter) {
  return purchase_voucher_clients_get_row_actions($row,$url,$select_url,$filter);
}