<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL Item Name',
    'primary_table'       => 'ac_narration',
    'default_column'      => 'id',
    'table'               => 'ac_narration',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'narrations',
    'add_title'           => 'Add Item Name',
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
    array("Chain Purity", "chain_purity", TRUE, "chain_purity", TRUE, TRUE),
    array("Chitti Purity", "chitti_purity", TRUE, "chitti_purity", TRUE, TRUE),
    array("Wastage", "chain_margin", TRUE, "chain_margin", TRUE, TRUE),
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

  $attributes['narrations'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'name'        => array('Narration', 'Enter Narration.', TRUE, '', TRUE),
    'chain_purity'        => array('Chain Purity', 'Enter Chain Purity.', TRUE, '', TRUE),
    'chitti_purity'        => array('Chitti Purity', 'Enter Chitti Purity.', TRUE, '', TRUE),
    'chain_margin'        => array('Wastage', 'Enter Wastage', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'masters/narrations';
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