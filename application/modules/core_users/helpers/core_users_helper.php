<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function coreusers_getTableSettings() {
  return array(
    'page_title'          => 'Users List',
    'primary_table'       => 'users',
    'default_column'      => 'id',
    'table'               => 'users',
    'join_conditions'     => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'users.id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'users',
    'add_title'           => 'Add User',
    'export_title'        => 'Export',
    'edit'                => '',
    'select_column'       => true,
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

function coreusers_list_settings() {
  return array(
    array("User Name", "user_name", TRUE, "user_name", TRUE, TRUE, 'users.name as user_name', 'masters', FALSE,'autocomplete',array('users','name')),
    array("User Contact No.", "contact_no", TRUE, "contact_no", TRUE, TRUE, 'users.mobile_no as contact_no', 'masters', FALSE,'autocomplete',array('users','mobile_no')),
    array("User Email id", "email_id", TRUE, "email_id", TRUE, TRUE, 'users.email_id as email_id', 'masters', FALSE,'autocomplete',array('users','name')),
    array("Created at", "created", TRUE, "users.created_at", TRUE, TRUE, "DATE_FORMAT(users.created_at, '%d-%m-%Y') as created", 'masters', FALSE,'date',array('users','created_at')),
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

function coreusers_get_field_attribute($table, $field) {
  $attributes = array();

  $attributes['users'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'srno'          => array('Srno', '', FALSE, '', TRUE),
    'id_no'         => array('ID_no', '', FALSE, '', TRUE),
    'arf_details'         => array('', '', FALSE, '', TRUE),
    'name'          => array('Name', 'Enter Name.', TRUE, '', TRUE),
    'mobile_no'    => array('Contact No', 'Enter contact number', TRUE, '', TRUE),
    'email_id'      => array('User Email ID ', 'Enter Email ID', TRUE, '', TRUE),
    'password'      => array('Password ', 'Enter Password', TRUE, '', TRUE),
    'confirm_password' => array('Confirm Password ', 'Enter Confirm Password', TRUE, '', TRUE),
    'department_id' => array('Department ', 'Select Department', TRUE, '', TRUE),
    // 'status'        => array('User Status ', 'Enter Status', TRUE, '', TRUE),
    'user_role_id'  => array('User Role ', 'Enter User Role', TRUE, '', TRUE),
  );
 
  $attributes['users_user_roles'] = array(
    'users_user_roles' => array('', '', FALSE, '', FALSE),
  );

  $attributes['user_departments'] = array(
    'department_id' => array('', '', FALSE, '', FALSE),
  );
  return $attributes[$table][$field];
}

function coreusers_get_row_actions($row, $url, $select_url, $filter) {
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
  if($row['id'] != $_SESSION['user_id'])
  {
    $actions["Logout"] = array('request' => "http",
                             'url' => BASE_URL.$controller.'/edit/'.$row['id'].'?delete_sessions=1',
                             'confirm_message' => "Are you sure?",
                             'js_function' => "",
                             'class' => 'red');
  }
  return $actions;
}