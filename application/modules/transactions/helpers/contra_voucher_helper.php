<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'All CONTRA VOUCHERS',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'id',
    'table'               => 'ac_vouchers',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => 'voucher_type="contra voucher"',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'contra_voucher',
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
    array("From Account", "from_account_name", TRUE, "from_account_name", TRUE, TRUE),
    array("To Account", "account_name", TRUE, "account_name", TRUE, TRUE),
    array("Amount", "amount", TRUE, "amount", FALSE, TRUE),
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

  $attributes['contra_voucher'] = array(
    'id'                => array('', '', TRUE, '', TRUE),
    'voucher_date'      => array('Date', 'Enter Date.', TRUE, '', TRUE),
    'from_account_name' => array('From Account', 'Enter From Account', TRUE, '', TRUE),
    'from_group_name'   => array('From Group Name', 'Enter From Group Name', FALSE, '', TRUE),
    'account_name'      => array('To Account', 'Enter To Account', TRUE, '', TRUE),
    'to_group_name'     => array('To Group Name', 'Enter To Group Name', FALSE, '', TRUE),
    'amount'            => array('Amount', 'Enter Amount', TRUE, '', TRUE),
    'narration'         => array('Narration', 'Enter Narration', FALSE, '', TRUE),
    'from_account_id'   => array('', '', TRUE, '', TRUE),
    'account_id'        => array('', '', TRUE, '', TRUE),
    'company_id'        => array('', '', TRUE, '', TRUE),
    'document'          => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'transaction/contra_voucher'; 
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