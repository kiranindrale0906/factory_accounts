<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL COMPANIES',
    'primary_table'       => 'ac_company',
    'default_column'      => 'id',
    'table'               => 'ac_company',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'company',
    'add_title'           => 'Add Companies',
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
    array("Address Line1", "address_line1", TRUE, "address_line1", TRUE, TRUE),
    array("Address Line2", "address_line2", TRUE, "address_line2", TRUE, TRUE),
    array("City", "city", TRUE, "city", TRUE, TRUE),
    array("State", "state", TRUE, "state", TRUE, TRUE),
    array("Pincode", "pincode", TRUE, "pincode", TRUE, TRUE),
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

  $attributes['company'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'name'          => array('Company Name', 'Enter Company Name.', TRUE, '', TRUE),
    'api_url'       => array('Domain Url', 'Enter Domain Url', TRUE, '', TRUE),
    'address_line1' => array('Address Line1', 'Enter Address Line1.', FALSE, '', TRUE),
    'address_line2' => array('Address Line2', 'Enter Address Line2.', FALSE, '', TRUE),
    'city'          => array('City', 'Enter City.', FALSE, '', TRUE),
    'state'         => array('State', 'Enter State.', FALSE, '', TRUE),
    'pincode'       => array('Pincode', 'Enter Pincode.', FALSE, '', TRUE),
    'logo'          => array('Select logo', 'Please select logo.', FALSE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'masters/company';
 $actions["Edit"] = array( 'request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'text-warning text-uppercase');

  // $actions["Delete"] = array('request' => "http",
  //                              'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
  //                              'confirm_message' => "Do you want to delete",
  //                              'js_function' => "",
  //                              'class' => 'text-danger text-uppercase');
  return $actions;
}