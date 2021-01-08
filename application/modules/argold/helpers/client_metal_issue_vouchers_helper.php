<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function list_settings() {
  $list_option=array('voucher_date','site_name','receipt_type','created_time', 'voucher_number', 'account_name', 
                     'credit_weight', 'factory_purity', 'factory_fine', 'purity', 'fine', 'narration','description','action');
  return ac_vouchers_list_settings($list_option);
}

function get_field_attribute($table, $field) {
  $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name', 
                         'credit_weight', 'factory_purity','factory_fine', 'purity', 'fine', 'narration','description', 'add_more');
  return ac_voucher_get_field_attribute($table, $field, $required_fields);
}
if (!function_exists('get_row_actions')) {
  function get_row_actions($row, $url, $select_url, $filter) {
    $actions = array();
    $ci=&get_instance();
    $controller = 'argold/voucher_details'; 
    // if ($row['account_name'] == 'SWARN SHILP CHAINS AND JEWELLERS PVT LTD')
      $actions["View"] =  array('request' => "http", 
                              'url' => ADMIN_PATH.$controller.'/view/'.$row['id'],
                              'confirm_message' => "",
                              'class' => 'text-warning text-uppercase');
      $actions["Edit"] =  array('request' => "http", 
                                     'url' => ADMIN_PATH.'argold/metal_issue_account_names/edit/'.$row['id'],
                                     'confirm_message' => "",
                                     'class' => 'text-warning text-uppercase');
    return $actions;
  }
}
