<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');
//AR Gold

function list_settings() {
  $list_option=array('voucher_date', 'created_time', 'voucher_number', 'account_name', 
                     'debit_weight', 'factory_purity', 'factory_fine', 'purity', 'fine', 'narration');
  return ac_vouchers_list_settings($list_option);
}

function get_field_attribute($table, $field) {

  if(!empty($_GET['receipt_type']) && $_GET['receipt_type']=='Metal')	{
    $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name', 
                           'debit_weight', 'purity', 'fine', 'narration');
  }elseif (!empty($_GET['receipt_type']) && $_GET['receipt_type']=='Finished Goods') {
    $required_fields=array('id', 'voucher_date', 'receipt_type', 
                           'debit_weight', 'factory_purity','factory_fine', 'purity', 'fine', 'narration');

  }else {
    $required_fields=array('id', 'voucher_date', 'receipt_type', 'account_name', 
                           'debit_weight', 'factory_purity','factory_fine', 'purity', 'fine', 'narration');

  }


  return ac_voucher_get_field_attribute($table,$field,$required_fields);
}