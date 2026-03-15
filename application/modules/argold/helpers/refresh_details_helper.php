<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Refresh List',
    'primary_table'       => 'refresh_details',
    'default_column'      => 'id',
    'table'               => 'refresh_details',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'refresh_details',
    'add_title'           => 'Add Refresh',
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
    array("Id", "id", FALSE, "id", FALSE, FALSE),
    array("Date", "created_at", FALSE, "created_at", FALSE, FALSE,'DATE_FORMAT(created_at, "%d-%m-%Y") as created_at'),
    array("Weight", "weight", FALSE, "weight", FALSE, FALSE),
    array("Purity", "purity", FALSE, "purity", FALSE, FALSE),
    array("Fine", "fine", FALSE, "fine", FALSE, FALSE),
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
  $attributes["refresh"] = array(
    "id" => array("", "", FALSE, "", FALSE),
  );
  $attributes["refresh_details"] = array(
    "id" => array("", "", FALSE, "", FALSE),
    "refresh_id"  => array("", "", FALSE, "", TRUE),
    "item_name"  => array("Item Name", "", FALSE, "", TRUE),
  );
  return $attributes[$table][$field];
}



function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'argold/refresh_details';
  // $actions["View"] = array('request' => "http", 
  //                          'url' => ADMIN_PATH.$controller.'/view/'.$row['id'],
  //                          'confirm_message' => "",
  //                          'class' => 'btn-sm btn_green');

  // $actions["Delete"] = array('request' => "http",
  //                              'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
  //                              'confirm_message' => "Do you want to delete",
  //                              'js_function' => "",
  //                              'class' => 'text-danger text-uppercase');
  return $actions;
}
