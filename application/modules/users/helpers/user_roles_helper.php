<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'User roles List',
    'primary_table'       => 'user_roles',
    'default_column'      => 'id',
    'table'               => 'user_roles',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id,(SELECT COUNT(id) FROM users_user_roles where user_role_id = user_roles.id) as role_count',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'user_roles',
    'add_title'           => 'Add User Role',
    'export_title'        => '',
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
    array("Name", "name", TRUE, "name", TRUE, TRUE),
    array("Created at", "created", TRUE, "Date(created_at)", TRUE, TRUE, "DATE_FORMAT(user_roles.created_at, '%d-%m-%Y') as created", 'masters', FALSE,'date',array('user_roles','created_at')),
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
 return coreuserroles_get_field_attribute($table, $field);
}

/*
Key-value options neccessary for below request's
1. http
  [0] => 'request'
  [1] => 'url'
  [2] => 'confirm_message'
  [3] => 'class'

2. js
  [0] => 'request'
  [1] => 'confirm_message'
  [2] => 'url'
  [3] => 'js_function'
  [4] => 'class'

3. ajax
  [0] => 'request'
  [1] => 'url'
  [2] => 'class'

3. ajax_post
  [0] => 'request'
  [1] => 'url'
  [2] => 'post_data'
  [3] => 'class'  
*/

function get_row_actions($row, $url, $select_url, $filter) {
  return coreuserroles_get_row_actions($row, $url, $select_url, $filter);
}

