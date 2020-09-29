<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'BW Accounts',
    'primary_table'       => 'bw_accounts',
    'default_column'      => 'id',
    'table'               => 'bw_accounts',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'bw_accounts',
    'add_title'           => 'Add BW Accounts',
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
    array("Date", "created_at", TRUE, "created_at", TRUE, TRUE),
    array("Factory Name", "factory_name", TRUE, "factory_name", TRUE, TRUE),
    array("Balance Gross", "balance_gross", TRUE, "balance_gross", TRUE, TRUE),
    array("B Gross", "b_gross", TRUE, "b_gross", TRUE, TRUE),
    array("W Gross", "w_gross", TRUE, "w_gross", TRUE, TRUE),
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

  $attributes['bw_accounts'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'factory_name'          => array('Factory Name', 'Enter Factory Name.', TRUE, '', TRUE),
    'balance_gross'          => array('Balance Gross', 'Enter Balance Gross.', TRUE, '', TRUE),
    'b_gross'          => array('B Gross', 'Enter B Gross', TRUE, '', TRUE),
    'w_gross'          => array('W Gross', 'Enter W Gross', TRUE, '', TRUE),
    );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'reports/bw_accounts';
 $actions["Edit"] = array( 'request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'text-warning text-uppercase');
  return $actions;
}