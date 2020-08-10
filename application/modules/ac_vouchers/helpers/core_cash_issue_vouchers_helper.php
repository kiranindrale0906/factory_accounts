<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//General

if (!function_exists('getTableSettings')) {
  function getTableSettings() {
    $table_setting=array('page_title'=>'Cash Issue Voucher','where'=>'voucher_type="cash issue voucher"');
    return ac_vouchers_getTableSettings($table_setting);
  }
}

if (!function_exists('list_settings')) {
  function list_settings() {
    $list_option=array('voucher_date', 'created_time', 'voucher_number', 'account_name', 'credit_amount', 'narration');
    return ac_vouchers_list_settings($list_option);
  }
}

if (!function_exists('get_field_attribute')) {
  function get_field_attribute($table, $field) {  
    $required_fields=array('id', 'voucher_date', 'account_name', 'credit_amount', 'narration', 'account_id', 'purity');
    return ac_voucher_get_field_attribute($table,$field,$required_fields);
  }
}

if (!function_exists('get_row_actions')) {
  function get_row_actions($row, $url, $select_url, $filter) {
    return ac_vouchers_get_row_actions($row, $url, $select_url, $filter);
  }
}