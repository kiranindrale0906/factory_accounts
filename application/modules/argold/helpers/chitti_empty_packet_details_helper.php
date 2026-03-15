<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  $show = (isset($_GET['show_all'])) ? $_GET['show_all'] : '';
  if($show=='yes') $where='';
  else $where='refresh_hide=0';
  return array(
    'page_title'          => 'Empty Packet Details List',
    'primary_table'       => 'chitti_empty_packet_details',
    'default_column'      => 'id',
    'table'               => 'chitti_empty_packet_details',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'chitti_empty_packet_details',
    'add_title'           => '',
    'hide_button'        => '',
    'export_title'        => '',
    'edit'                => '',
    'custom_table_header' => true,
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
    array("Factory Purity", "factory_purity", FALSE, "factory_purity", FALSE, FALSE),
    array("Factory Fine", "factory_fine", FALSE, "fine", FALSE, FALSE),
    array("Amount", "credit_amount", FALSE, "credit_amount", FALSE, FALSE),
    array("Site Name", "site_name", FALSE, "site_name", FALSE, FALSE),
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

  $attributes['chitti_empty_packet_details'] = array(
    'chitti_id'            => array('', '', TRUE, '', TRUE),
    );
  $attributes['empty_packet_details'] = array(
    'chitti_id' => array('', '', TRUE, '', TRUE),
    'weight' => array('', '', TRUE, '', TRUE),
    'quantity' => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();

  // $actions["Delete"] = array('request' => "http",
  //                              'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
  //                              'confirm_message' => "Do you want to delete",
  //                              'js_function' => "",
  //                              'class' => 'text-danger text-uppercase');
  return $actions;
}