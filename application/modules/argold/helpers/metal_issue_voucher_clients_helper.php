<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function metal_issue_voucher_clients_list_settings() {
  $list_option=array('voucher_date', 'created_time', 'voucher_number', 'account_name', 
                     'credit_weight', 'factory_purity', 'factory_fine', 'purity', 'fine', 'narration');
  return ac_vouchers_list_settings($list_option);
}

function metal_issue_voucher_clients_get_field_attribute($table, $field) {
  $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name', 
                         'credit_weight', 'factory_purity','factory_fine', 'purity', 'fine', 'narration');
  return ac_voucher_get_field_attribute($table, $field, $required_fields);
}
