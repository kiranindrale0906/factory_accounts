<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL Items',
    'primary_table'       => 'ac_item',
    'default_column'      => 'id',
    'table'               => 'ac_item',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'items',
    'add_title'           => 'Add Items',
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
    array("Name", "name", TRUE, "name", TRUE, TRUE),
    array("Item Code", "item_code", TRUE, "item_code", TRUE, TRUE),
    array("Avg. Melting", "avg_melting", TRUE, "avg_melting", TRUE, TRUE),
    array("Melting From", "melting_from", TRUE, "melting_from", TRUE, TRUE),
    array("Melting To", "melting_to", TRUE, "melting_to", TRUE, TRUE),
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

  $attributes['items'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'name'          => array('Name', 'Enter name.', TRUE, '', TRUE),
    'item_code'      => array('Item Code', 'Enter Item Code', FALSE, '', TRUE),
    'avg_melting'      => array('Avg. Melting', 'Enter Avg. Melting', FALSE, '', TRUE),
    'melting_from'      => array('Melting From', 'Enter Melting From', FALSE, '', TRUE),
    'melting_to'      => array('Melting To', 'Enter Melting To', FALSE, '', TRUE),
    'company_id'    => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'others/items';
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
