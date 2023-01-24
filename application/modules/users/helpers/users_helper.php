<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Users List',
    'primary_table'       => 'ac_users',
    'default_column'      => 'id',
    'table'               => 'ac_users',
    'join_conditions'     => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'ac_users.id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'ac_users',
    'add_title'           => 'Add User',
    'export_title'        => 'Export',
    'edit'                => '',
    'clear_filter'        => true,
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
    array("User Name", "name", TRUE, "name", TRUE, TRUE, 'name', 'masters', FALSE,'autocomplete',array('ac_users','name')),
    array("User Contact No.", "mobile_no", TRUE, "mobile_no", TRUE, TRUE, 'ac_users.mobile_no as mobile_no', 'masters', FALSE,'autocomplete',array('ac_users','mobile_no')),
    array("User Email id", "email_id", TRUE, "email_id", TRUE, TRUE, 'ac_users.email_id as email_id', 'masters', FALSE,'autocomplete',array('ac_users','email_id')),
    array("Created at", "created", TRUE, "Date(created_at)", TRUE, TRUE, "DATE_FORMAT(ac_users.created_at, '%d-%m-%Y') as created", 'masters', FALSE,'date',array('users','created_at')),
    // array("Status", "status", TRUE, "status", FALSE, TRUE, 'users.name as department_name', 'masters', FALSE,'autocomplete',array('users','name')),
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

  $attributes['users'] = array(
    'id'               => array('', '', TRUE, '', TRUE),
    'all_details'               => array('', '', TRUE, '', TRUE),
    'arf_details'               => array('', '', TRUE, '', TRUE),
    'arg_details'               => array('', '', TRUE, '', TRUE),
    'arc_details'               => array('', '', TRUE, '', TRUE),
    'do_not_check_ip'               => array('', '', TRUE, '', TRUE),
    'vodator_report'               => array('', '', TRUE, '', TRUE),
    'gross_profit_report'               => array('', '', TRUE, '', TRUE),
    'production_report'               => array('', '', TRUE, '', TRUE),
    'srno'             => array('Srno', '', FALSE, '', TRUE),
    'name'             => array('Name', 'Enter Name.', TRUE, '', TRUE),
    'mobile_no'        => array('Contact No', 'Enter contact number', TRUE, '', TRUE),
    'email_id'         => array('User Email ID ', 'Enter Email ID', TRUE, '', TRUE),
    'password'         => array('Password ', 'Enter Password', TRUE, '', TRUE),
    'confirm_password' => array('Confirm Password ', 'Enter Confirm Password', TRUE, '', TRUE),
    // 'status'        => array('User Status ', 'Enter Status', TRUE, '', TRUE),
    'user_role_id'     => array('User Role ', 'Enter User Role', TRUE, '', TRUE),
  );
 
  $attributes['users_user_roles'] = array(
    'users_user_roles' => array('', '', FALSE, '', FALSE),
  );

  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'users';
  $actions["Edit"] = array('request' => "http", 
                           'url' => BASE_URL.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'green');
  $actions["Delete"] = array('request' => "js",
                             'url' => BASE_URL.$controller.'/delete/'.$row['id'],
                             'confirm_message' => "Do you want to delete",
                             'js_function' => "",
                             'class' => 'red');
  return $actions;
}