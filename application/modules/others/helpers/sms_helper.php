<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL DEPARTMENTS',
    'primary_table'       => 'ac_department',
    'default_column'      => 'id',
    'table'               => 'ac_department',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'department',
    'add_title'           => 'Add Department',
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
    array("Taggable", "taggable", TRUE, "taggable", TRUE, TRUE),
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

  $attributes['department'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'name'          => array('Name', 'Enter Name.', TRUE, '', TRUE),
    'short_message'      => array('Short Message', 'Select Short Message.', FALSE, '', TRUE),
    'tvariable'      => array('T Variable', 'Enter T Variable.', FALSE, '', TRUE),
    'type'      => array('Type', 'Enter Type.', FALSE, '', TRUE),
    'company_code'      => array('Type', 'Enter Compnay .', FALSE, '', TRUE),
    'message'      => array('Massage ', 'Enter Massage .', FALSE, '', TRUE),
    'company_id'    => array('', '', TRUE, '', TRUE),
  );
  
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'others/sms';
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