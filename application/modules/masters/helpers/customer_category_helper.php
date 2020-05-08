<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL CUSTOMER CATEGORIES',
    'primary_table'       => 'ac_customer_category',
    'default_column'      => 'id',
    'table'               => 'ac_customer_category',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'customer_category',
    'add_title'           => 'Add Customer Category',
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
    array("Name", "category_name", TRUE, "category_name", TRUE, TRUE),
    array("Department Name", "department_name", TRUE, "department_name", TRUE, TRUE),
    array("Account Name", "account_name", TRUE, "account_name", TRUE, TRUE),
    array("Wastage", "wastage", TRUE, "wastage", TRUE, TRUE),
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

  $attributes['customer_category'] = array(
    'id'                      => array('', '', TRUE, '', TRUE),
    'category_name_id'        => array('Category Name', 'Enter Category Name.', TRUE, '', TRUE),
    'department_name_id'      => array('Department Name', 'Select Department.', TRUE, '', TRUE),
    'account_name'         => array('Account Name', 'Enter Account Name.', TRUE, '', TRUE),
    'wastage'                 => array('Wastage', 'Enter Wastage.', FALSE, '', TRUE),
    'company_id'              => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'masters/customer_category';
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