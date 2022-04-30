<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function list_settings() {
  $list_option=array('voucher_date','receipt_type', 'created_time', 'voucher_number', 'account_name','customer_name', 
                     'debit_weight', 'factory_purity', 'factory_fine', 'purity', 'fine', 'narration', 'description', 'debit_amount','created_by', 'action');
  return ac_vouchers_list_settings($list_option);
}

function get_field_attribute($table, $field) {
  if(!empty($_GET['receipt_type']) && ($_GET['receipt_type'] == 'Metal' || $_GET['receipt_type'] == 'Rhodium')) {
    if(!empty($_GET['parent_id']))
      $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name', 
                             'debit_weight', 'purity', 'fine','description');
    else
      $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name', 
                             'debit_weight', 'purity', 'fine', 'narration', 'description', 'sale_type', 'gold_rate', 'gold_rate_purity');
  } elseif(!empty($_GET['receipt_type']) && (  $_GET['receipt_type'] == 'AR Gold Chain Receipt'
                                          || $_GET['receipt_type'] == 'ARF Chain Receipt'
                                          || $_GET['receipt_type'] == 'ARC Chain Receipt'
                                          || $_GET['receipt_type'] == 'AR Gold Finished Goods Receipt'
                                          || $_GET['receipt_type'] == 'ARF Finished Goods Receipt'
                                          || $_GET['receipt_type'] == 'ARC Finished Goods Receipt'
                                          || $_GET['receipt_type'] == 'AR Gold RND'
                                          || $_GET['receipt_type'] == 'ARF RND'
                                          || $_GET['receipt_type'] == 'ARC RND'))	{
    $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name', 
                           'debit_weight', 'purity', 'fine', 'narration','description');

  }elseif(!empty($_GET['receipt_type']) && (  $_GET['receipt_type'] == 'Export Internal')) {
    $required_fields=array('id', 'voucher_date', 'receipt_type','debit_weight', 'purity', 'fine','description');

  }elseif (!empty($_GET['receipt_type']) && (   $_GET['receipt_type'] == 'ARC Finished Goods' 
                                             || $_GET['receipt_type'] == 'ARF Finished Goods'
                                             || $_GET['receipt_type'] == 'AR Gold Finished Goods'
                                             || $_GET['receipt_type'] == 'ARF Software Finished Goods')) {
    $required_fields=array('id', 'voucher_date', 'receipt_type', 
                           'debit_weight', 'purity', 'fine', 'narration','description');

  }elseif (!empty($_GET['receipt_type']) && ($_GET['receipt_type'] == 'Daily Drawer')) {
    $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name','dd_type',
                           'debit_weight', 'factory_purity','factory_fine', 'purity', 'fine', 'narration','description');

  }elseif (!empty($_GET['receipt_type']) && ($_GET['receipt_type'] == 'Vadotar')) {
    $required_fields=array('id', 'voucher_date', 'receipt_type');

  }elseif (!empty($_GET['receipt_type']) && (   $_GET['receipt_type'] == 'ARC Refresh' 
                                             || $_GET['receipt_type'] == 'ARF Refresh'
                                             || $_GET['receipt_type'] == 'AR Gold Refresh')) {
    $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name',
                           'debit_weight', 'factory_purity','factory_fine', 'purity', 'fine', 'narration','description', 'hook_kdm_purity', 'gold_rate', 'sale_type', 'hallmark_rate', 'hallmark_quantity');

  } else {
    $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name',
                           'debit_weight', 'factory_purity','factory_fine', 'purity', 'fine', 'narration','description');
  }

  return ac_voucher_get_field_attribute($table, $field, $required_fields);
}

if (!function_exists('get_row_actions')) {
  function get_row_actions($row, $url, $select_url, $filter) {
    $actions = array();
    $ci=&get_instance();
    $controller = 'argold/voucher_details'; 
    $actions["View"] =  array('request' => "http", 
                              'url' => ADMIN_PATH.$controller.'/view/'.$row['id'],
                              'confirm_message' => "",
                              'class' => 'text-warning text-uppercase');
    if (   $row['receipt_type'] == 'Metal'
        || $row['receipt_type'] == 'AR Gold Refresh'
        || $row['receipt_type'] == 'ARF Refresh'
        || $row['receipt_type'] == 'ARC Refresh'
        || $row['receipt_type'] == 'Rhodium')
      $actions["Edit Rate"] =  array('request' => "http", 
                                     'url' => ADMIN_PATH.'argold/metal_receipt_gold_rates/edit/'.$row['id'],
                                     'confirm_message' => "",
                                     'class' => 'text-warning text-uppercase');
    $actions["Edit"] =  array('request' => "http", 
                                   'url' => ADMIN_PATH.'argold/metal_issue_account_names/edit/'.$row['id'],
                                   'confirm_message' => "",
                                   'class' => 'text-warning text-uppercase');

    return $actions;
  }
}
