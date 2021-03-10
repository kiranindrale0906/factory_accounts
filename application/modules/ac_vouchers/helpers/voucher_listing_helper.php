<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  $where=array();
  if(!empty($_GET['parent_id'])){
    $where=array('parent_id'=>$_GET['parent_id']);
  }
  return array(
    'page_title'          => 'Vouchers',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'name',
    'table'               => 'ac_vouchers',
    'join_conditions'     => '',
    'join_type'           => '',
    'where'               => $where,
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'ac_vouchers',
    'add_title'           => 'Add Account',
    'export_title'        => '',
    'edit'                => ''
  );
}

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
  return array(
    array("Voucher Number", "voucher_number", true, "voucher_number", true, true),
    array("Account Name", "account_name", true, "account_name", true, true),
    array("Receipt Type", "receipt_type", true, "receipt_type", true, true),
    array("Credit Weight", "credit_weight", true, "credit_weight", true, true),
    array("Debit Weight", "debit_weight", true, "debit_weight", true, true),
    array("Purity", "purity", true, "purity", true, true),
    array("Factory Purity", "factory_purity", true, "factory_purity", true, true),
    // array("Net Wt.", "", true, "", true, true),
    // array("Action", "action", false, "action", false, false)
    );
}
