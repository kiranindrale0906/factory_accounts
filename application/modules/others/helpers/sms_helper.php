<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL SMS',
    'primary_table'       => 'ac_department',
    'default_column'      => 'id',
    'table'               => 'ac_sms',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'sms',
    'add_title'           => 'Add Sms',
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
    array("Name", "short_message", TRUE, "short_message", TRUE, TRUE),
    array("Tvariable", "tvariable", TRUE, "tvariable", TRUE, TRUE),
    array("Type", "type", TRUE, "type", TRUE, TRUE),
    array("Compnay Code", "company_code", TRUE, "company_code", TRUE, TRUE),
    array("Message", "message", TRUE, "message", TRUE, TRUE),
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

  $attributes['sms'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'short_message'      => array('Short Message', 'Select Short Message.', TRUE, '', TRUE),
    'tvariable'      => array('T Variable', 'Enter T Variable.', TRUE, '', TRUE),
    'type'      => array('Type', 'Enter Type.', TRUE, '', TRUE),
    'company_code'      => array('Type', 'Enter Compnay .', TRUE, '', TRUE),
    'message'      => array('Massage ', 'Enter Massage .', TRUE, '', TRUE),
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