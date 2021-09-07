<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//General

if (!function_exists('getTableSettings')) {
  function getTableSettings() {
    $table_setting=array('page_title'=>'Rate Cut Receipt Voucher',
                         'where'=>'voucher_type="rate cut receipt voucher"');
    return ac_vouchers_getTableSettings($table_setting);
  }
}

if (!function_exists('list_settings')) {
  function list_settings() {
    $list_option=array('voucher_date', 'created_time', 
                       'gold_rate', 'gold_rate_purity', 
                       'debit_weight', 'purity', 
                       'voucher_number', 'account_name', 'account_id', 'company_id',
                       'credit_amount', 'description','action');
    return ac_vouchers_list_settings($list_option);
  }
}

if (!function_exists('get_field_attribute')) {
  function get_field_attribute($table, $field) {  
    $required_fields=array('id', 'voucher_date', 'account_name', 
                           'gold_rate', 'gold_rate_purity', 
                           'debit_weight', 'purity', 'credit_amount', 'description', 'account_id');
    return ac_voucher_get_field_attribute($table,$field,$required_fields);
  }
}

if (!function_exists('get_row_actions')) {
  function get_row_actions($row, $url, $select_url, $filter) {
    return ac_vouchers_get_row_actions($row, $url, $select_url, $filter);
  }
}