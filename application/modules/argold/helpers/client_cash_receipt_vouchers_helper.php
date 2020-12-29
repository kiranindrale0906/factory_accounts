<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function cash_receipt_list_settings() {
  $list_option=array('voucher_date','created_time', 'voucher_number', 'account_name', 
                     'debit_amount', 'description','action');
  return ac_vouchers_list_settings($list_option);
}

function get_field_attribute($table, $field) {
  $required_fields=array('id', 'voucher_date','account_name','debit_amount','description');
  return ac_voucher_get_field_attribute($table,$field,$required_fields);
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
      return $actions;
  }
}
