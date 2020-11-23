<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function list_settings() {
  $list_option=array('voucher_date','created_time', 'voucher_number', 'account_name', 
                     'debit_amount', 'description');
  return ac_vouchers_list_settings($list_option);
}

function get_field_attribute($table, $field) {
  $required_fields=array('id', 'voucher_date','account_name','debit_amount','description');
  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}

if (!function_exists('get_row_actions')) {
  function get_row_actions($row, $url, $select_url, $filter) {
    $actions = array();
    return $actions;
  }
}
