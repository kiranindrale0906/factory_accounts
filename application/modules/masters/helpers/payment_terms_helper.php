<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  $ci = &get_instance();
  return array(
    'page_title'          => 'ALL PAYMENT TERMS',
    'primary_table'       => 'ac_payment_terms',
    'default_column'      => 'id',
    'table'               => 'ac_payment_terms',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => 'company_id='.(!empty($ci->session->userdata('company_id'))?$ci->session->userdata('company_id'):1),
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'payment_terms',
    'add_title'           => 'Add Payment Terms',
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
    array("Name", "terms", TRUE, "terms", TRUE, TRUE),
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

  $attributes['payment_terms'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'terms'        => array('Payment terms', 'Enter payment Terms.', TRUE, '', TRUE),
    'company_id'  => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'masters/payment_terms';
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