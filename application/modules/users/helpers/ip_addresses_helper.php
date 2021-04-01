<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Ip Address List',
    'primary_table'       => 'ip_addresses',
    'default_column'      => 'id',
    'table'               => 'ip_addresses',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'ip_addresses',
    'add_title'           => 'Add Ip Address',
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
    array("Ip Address", "ip_address", TRUE, "ip_address", FALSE, TRUE, "ip_address as ip_address"),
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

  $attributes = array(
    'id'       => array('', '', TRUE, '', TRUE),
    'ip_address'     => array('Ip Address', 'Enter Ip Address.', TRUE, '', TRUE),
  );

  return $attributes[$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'users/ip_addresses';
  $actions["Edit"] = array('request' => "http",
                           'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'blue',
                           'data_title' =>'View',
                            'i_class'=>'fal fa-file-alt font20');
  $actions["Delete"] = array('request' => "http",
                            'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                            'class' => 'red',
                            'confirm_message' => "Do you want to delete",
                            'data_title' => "Delete",
                            'i_class' => 'far fa-trash-alt font20');
  return $actions;
}