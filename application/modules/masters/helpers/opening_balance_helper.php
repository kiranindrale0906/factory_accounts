<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL OPENING BALANCE',
    'primary_table'       => 'ac_opening_balance',
    'default_column'      => 'id',
    'table'               => 'ac_opening_balance',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'opening_balance',
    'add_title'           => 'Add Opening Balance',
    'export_title'        => '',
    'edit'                => '',
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
    array("Date", "date", TRUE, "date", TRUE, TRUE),
    array("Account", "account_name", true, "account_name", true, true),
    array("Credit Amt.", "credit_amount", true, "credit_amount", true, true),
    array("debit Amt.", "debit_amount", true, "debit_amount", true, true),
    array("Credit Wt.", "credit_weight", true, "credit_weight", true, true),
    array("Debit Wt.", "debit_weight", true, "debit_weight", true, true),
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

  $attributes['opening_balance'] = array(
    'id'                => array('', '', TRUE, '', TRUE),
    'date'              => array('Date', 'Enter Date.', TRUE, '', TRUE),
    'account_name'   => array('Account Name', 'Enter Account Name.', TRUE, '', TRUE),
    'group_code'        => array('Group code', 'Enter Group Code.', TRUE, '', TRUE),
    'credit_amount'     => array('Credit Amount', 'Enter Credit Amount.', FALSE, '', TRUE),
    'debit_amount'      => array('Debit Amount', 'Enter Debit Amount.', FALSE, '', TRUE),
    'credit_weight'     => array('Credit Weight', 'Enter Credit Weight.', FALSE, '', TRUE),
    'debit_weight'      => array('Debit Weight', 'Enter Debit Weight.', FALSE, '', TRUE),
    'narration'         => array('Narration', 'Enter Narration.', FALSE, '', TRUE),
    'cash_bill_type'    => array('Cash Bill Type', 'Enter Cash Bill Type.', FALSE, '', TRUE),
    'gst_number'        => array('GST Number', 'Enter GST Number.', FALSE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'masters/opening_balance';
  $actions["Edit"] = array( 'request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'text-warning text-uppercase');

  $actions["Delete"] = array('request' => "http",
                               'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                               'confirm_message' => "Do you want to delete",
                               'js_function' => "",
                               'class' => 'text-danger text-uppercase');
  return $actions;
}