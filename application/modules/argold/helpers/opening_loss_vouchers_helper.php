<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Opening Loss Voucher',
    'primary_table'       => 'opening_loss_vouchers',
    'default_column'      => 'id',
    'table'               => 'opening_loss_vouchers',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'opening_loss_vouchers',
    'add_title'           => 'Add Opening Loss Voucher',
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
    array("Date", "date", TRUE, "date", TRUE, TRUE),
    array("Type of Loss", "type_of_loss", TRUE, "type_of_loss", TRUE, TRUE),
    array("Factory Name", "factory_name", TRUE, "factory_name", TRUE, TRUE),
    array("Loss", "loss", TRUE, "loss", TRUE, TRUE),
    array("Purity", "purity", TRUE, "purity", TRUE, TRUE),
    array("Out Weight", "out_weight", TRUE, "out_weight", TRUE, TRUE),
    array("Metal Receive After Recovery", "recovered_loss", TRUE, "recovered_loss", TRUE, TRUE),
    array("Unrecoverable", "unrecovered_loss", TRUE, "unrecovered_loss", TRUE, TRUE),
    array("Quator", "quator", TRUE, "quator", TRUE, TRUE),
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

  $attributes['opening_loss_vouchers'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'date'            => array('Date', '', TRUE, '', TRUE),
    'loss'          => array('Loss', 'Enter Loss', TRUE, '', TRUE),
    'purity'      => array('Purity', 'Enter Purity', FALSE, '', TRUE),
    'quator'      => array('quator', 'Enter quator', FALSE, '', TRUE),
    'factory_name'      => array('Factory name', 'Factory Name', FALSE, '', TRUE),
    'type_of_loss'      => array('Type of Loss', 'Enter Type of Loss', FALSE, '', TRUE),
    'out_weight'      => array('Out Weight', 'Enter Out Weight', FALSE, '', TRUE),
    'recovered_loss'      => array('Metal Receive After Recovery', 'Enter Metal Receive After Recovery', FALSE, '', TRUE),
    'unrecovered_loss'      => array('Unrecoverable', 'Enter Unrecoverable', FALSE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'argold/opening_loss_vouchers';
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