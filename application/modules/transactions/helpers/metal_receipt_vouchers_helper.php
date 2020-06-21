<?php defined('BASEPATH') OR exit('No direct script access allowed.');
//General

$ci=&get_instance();
$ci->load->helper(array('ac_vouchers/ac_vouchers', CLIENT_NAME.'/metal_receipt_voucher_clients'));

function getTableSettings() {
  if (!function_exists('metal_receipt_voucher_clients_getTableSettings')) {
    $table_setting=array('page_title'=>'Metal Receipt Voucher','where'=>'voucher_type="metal receipt voucher"');
    return ac_vouchers_getTableSettings($table_setting);
  } else
    return metal_receipt_voucher_clients_getTableSettings();
}

function list_settings() {
  if (!function_exists('metal_receipt_voucher_clients_list_settings')) { 
    $list_option=array('voucher_date', 'created_time', 'voucher_number', 'account_name', 'debit_weight', 'purity', 'fine', 'narration');
    return ac_vouchers_list_settings($list_option);
  } else 
    return metal_receipt_voucher_clients_list_settings();
}

function get_field_attribute($table, $field) {
  if (!function_exists('metal_receipt_voucher_clients_get_field_attribute')) {
    $required_fields=array('id', 'voucher_date', 'account_name', 'debit_weight', 'narration', 'account_id', 'purity');
    return ac_voucher_get_field_attribute($table,$field,$required_fields);
  } else
    return metal_receipt_voucher_clients_get_field_attribute($table, $field);
}

function get_row_actions($row, $url, $select_url, $filter) {
  if (!function_exists('metal_receipt_voucher_clients_get_row_actions')) {
    return ac_vouchers_get_row_actions($row, $url, $select_url, $filter);
  } else
    return metal_receipt_voucher_clients_get_row_actions($row, $url, $select_url, $filter);
}