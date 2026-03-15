<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Quator wise Loss Reports',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'id',
    'table'               => 'ac_vouchers',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'ac_vouchers',
    'add_title'           => '',
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
    array("Date", "created_at", TRUE, "created_at", TRUE, TRUE,'DATE_FORMAT(created_at, "%d-%m-%Y") as created_at'),
    array("AR Gold", "arg_balance_gross", TRUE, "arg_balance_gross", TRUE, TRUE),
    array("ARF", "arf_balance_gross", TRUE, "arf_balance_gross", TRUE, TRUE),
    array("ARC", "arc_balance_gross", TRUE, "arc_balance_gross", TRUE, TRUE),
    array("Overall Factory", "overall_factory", TRUE, "overall_factory", TRUE, TRUE,'(arg_balance_gross+arf_balance_gross+arc_balance_gross) as overall_factory'),
    array("W Gross", "w_gross", TRUE, "w_gross", TRUE, TRUE),
    array("Difference", "b_gross", TRUE, "b_gross", TRUE, TRUE),
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
    'arg_balance_gross'          => array('ARG Balance Gross', 'Enter Balance Gross.', TRUE, '', TRUE),
    'arf_balance_gross'          => array('ARF Balance Gross', 'Enter Balance Gross.', TRUE, '', TRUE),
    'arc_balance_gross'          => array('ARC Balance Gross', 'Enter Balance Gross.', TRUE, '', TRUE),
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
                           'class' => 'green');
  $actions["Delete"] = array( 'request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'red');
  return $actions;
}