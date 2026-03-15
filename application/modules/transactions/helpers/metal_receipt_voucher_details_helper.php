<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Metal Receipt Details',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'name',
    'table'               => 'ac_vouchers',
    'join_conditions'     => '',
    'join_type'           => '',
    'where'               => 'voucher_type="Metal Receipt Voucher"',
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'ac_vouchers',
    'add_title'           => '',
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
    array("Voucher Date", "voucher_date", true, "voucher_date", true, true),
    array("Account Name", "account_name", true, "account_name", true, true),
    array("Voucher No", "voucher_number", true, "voucher_number", true, true),
    array("Voucher Type", "voucher_type", true, "voucher_type", true, true),
    array("Debit Weight", "debit_weight", true, "debit_weight", true, true),
    array("Factory Purity", "factory_purity", true, "factory_purity", true, true),
    array("Factory Fine", "factory_fine", true, "factory_fine", true, true),
    array("Purity", "purity", true, "purity", true, true),
    array("Fine", "fine", true, "fine", true, true),
    array("Action", "action", false, "action", false, false));
}

/*
  | [0] => Label
  | [1] => Placeholder
  | [2] => Mandatory/Not Mandatory
  | [3] => Class
  | [4] => Autofocus
  | [5] => Readonly
  | [6] => disabled
*/

function get_field_attribute($table, $field) {
  $attributes = array();

  $attributes['metal_receipt_voucher_details'] = array(
     'id'            => array('', '', TRUE, '', TRUE),
    'voucher_number'          => array('Voucher number', 'Enter Name.', TRUE, '', TRUE),
    'debit_weight'    => array('Debit Weight', 'Enter Debit Weight.', FALSE, '', TRUE),
    'factory_purity' => array('Factory Purity', 'Enter Factory Purity.', FALSE, '', TRUE),
    'factory_fine'   => array('Factory Fine', 'Enter Factory Fine', FALSE, '', TRUE),
    'purity'       => array('Purity', 'Enter Purity.', FALSE, '', TRUE),
    'fine'          => array('Fine', 'Enter Fine.', FALSE, '', TRUE),
    'company_id'          => array('Company Id', 'Enter Company Id.', FALSE, '', TRUE),
    'account_name'          => array('Account Name', 'Enter Account Name', FALSE, '', TRUE),
    'account_id'          => array('Voucher Date', 'Enter Voucher Date', FALSE, '', TRUE),
    'voucher_date'          => array('Voucher Date', 'Enter Voucher Date', FALSE, '', TRUE),
    'description'         => array('description', 'Enter State.', FALSE, '', TRUE),);
  return $attributes[$table][$field];
}
function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'transactions/metal_receipt_voucher_details';
 $actions["Edit"] = array( 'request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'text-warning text-uppercase');

  $actions["Delete"] = array('request' => "http",
                               'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                               'confirm_message' => "",
                               'js_function' => "",
                               'class' => 'text-danger text-uppercase');
   // $actions["View"] = array('request' => "http",
   //                             'url' => ADMIN_PATH.'argold/voucher_details/view/'.$row['id'],
   //                             'confirm_message' => "",
   //                             'js_function' => "",
   //                             'class' => 'text-success text-uppercase');
  return $actions;
}