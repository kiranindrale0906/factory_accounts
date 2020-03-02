<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'All Metal Receipt Voucher',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'id',
    'table'               => 'ac_vouchers',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => 'voucher_type="metal receipt voucher"',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'metal_receipt_voucher',
    'add_title'           => '',
    'export_title'        => '',
    'edit'                => '',
    'custom_table_header' => true,
    'clear_filter'        => true,
  );
}
//Add Cash Issue Voucher
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
    array("Date", "voucher_date", TRUE, "voucher_date", TRUE, TRUE),
    array("Voucher", "voucher_number", FALSE, "voucher_number", TRUE, FALSE),
    array("Account", "account_name", TRUE, "account_name", TRUE, TRUE),
    array("Credit Wt.", "debit_weight", TRUE, "debit_weight", FALSE, TRUE),
    array("Purity", "purity", TRUE, "purity", FALSE, TRUE),
    array("Pure Gold", "pure_gold_debit", TRUE, "pure_gold_debit", FALSE, TRUE),
    array("Narration", "narration", FALSE, "narration", TRUE, TRUE),
    array("Action", "action", FALSE, "action", FALSE, FALSE),
  );
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

  $attributes['metal_receipt_voucher'] = array(
    'id'              => array('', '', TRUE, '', TRUE),
    'voucher_date'    => array('Date', 'Enter Date.', TRUE, '', TRUE),
    'purity'          => array('Purity', 'Enter Purity', TRUE, '', TRUE),
    'account_name'    => array('Account Name', 'Enter Account Name', TRUE, '', TRUE),
    'debit_weight'    => array('Debit Weight', 'Enter Debit Weight', TRUE, '', TRUE),
    'narration'       => array('Narration', 'Enter Narration', FALSE, '', TRUE),
    'account_id'      => array('', '', TRUE, '', TRUE),
    'company_id'      => array('', '', TRUE, '', TRUE),
    'document'        => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'transaction/metal_receipt_voucher'; 
  $actions["Edit"] =  array('request' => "http", 
                            'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                            'confirm_message' => "",
                            'class' => 'text-warning text-uppercase');
  $actions["Delete"] = array('request' => "http",
                             'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                             'confirm_message' => "Do you want to delete",
                             'js_function' => "",
                             'class' => 'text-danger text-uppercase');
  $actions["Print Voucher"] = array('request' => "http", 
                                    'url' => ADMIN_PATH.$controller.'/print_voucher/'.$row['id'],
                                    'confirm_message' => "",
                                    'class' => 'btn_green');
  return $actions;
}