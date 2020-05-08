<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL ACCOUNTS',
    'primary_table'       => 'ac_account',
    'default_column'      => 'name',
    'table'               => 'ac_account',
    'join_conditions'     => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'accounts',
    'add_title'           => 'Add Account',
    'export_title'        => '',
    'edit'                => ''
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
    array("Name", "name", true, "name", true, true),
    array("Sub Group Name", "sub_group_code", true, "sub_group_code", true, true),
    array("Area", "area", true, "area", true, true),
    array("Group", "group_code", true, "group_code", true, true),
    array("Route Group", "route_group", true, "route_group", true, true),
    array("Salary", "salary", true, "salary", true, true),
    // array("Net Wt.", "", true, "", true, true),
    array("Action", "action", false, "action", false, false));
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

  $attributes['accounts'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'name'          => array('Name', 'Enter Name.', TRUE, '', TRUE),
    'sub_group_code'    => array('Sub Group Name', 'Enter Sub Group Name.', FALSE, '', TRUE),
    'payment_terms' => array('Payment Terms', 'Enter Payment Terms.', FALSE, '', TRUE),
    'cont_person'   => array('Contact Person', 'Enter Contact Person.', FALSE, '', TRUE),
    'off_tel'       => array('Office Tel.No', 'Enter Office Tel.No.', FALSE, '', TRUE),
    'city'          => array('City', 'Enter City.', FALSE, '', TRUE),
    'state'         => array('State', 'Enter State.', FALSE, '', TRUE),
    'salesman_code' => array('Salesman Code', 'Enter Salesman Code.', FALSE, '', TRUE),
    'address'       => array('Address', 'Enter Address.', FALSE, '', TRUE),
    'pin'           => array('Pincode', 'Enter Pincode.', FALSE, '', TRUE),
    'area'          => array('Area', 'Enter Area.', FALSE, '', TRUE),
    'res_tel'       => array('Residence Tel.No', 'Enter Residence Tel.No.', FALSE, '', TRUE),
    'coll_days'     => array('Call Days', 'Enter Call Days.', FALSE, '', TRUE),
    'cr_days'       => array('Cr. Days', 'Enter Cr. Days.', FALSE, '', TRUE),
    'interest_rate' => array('Interest Rate', 'Enter Interest Rate.', FALSE, '', TRUE),
    'salary'        => array('Salary', 'Enter Salary.', FALSE, '', TRUE),
    'email'         => array('Email', 'Enter Email.', FALSE, '', TRUE),
    'web_address'   => array('web_address', 'Enter web_address.', FALSE, '', TRUE),
    'cst_no'        => array('Cst. No', 'Enter Cst. No.', FALSE, '', TRUE),
    'mvat_lst_no'   => array('Mvat/Lst No', 'Enter Mvat/Lst No.', FALSE, '', TRUE),
    'pan_no'        => array('Pan No', 'Enter Pan No.', FALSE, '', TRUE),
    'srv_tax_no'    => array('Srv. Tax No', 'Enter Srv. Tax No.', FALSE, '', TRUE),
    'sms_mobile_no' => array('Sms Mobile No', 'Enter Sms Mobile No.', FALSE, '', TRUE),
    'fine_wt_limit' => array('Fine Weight Limit', 'Enter Fine Weight Limit.', FALSE, '', TRUE),
    'remark'        => array('Remark', 'Enter Remark.', FALSE, '', TRUE));
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'masters/accounts';
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