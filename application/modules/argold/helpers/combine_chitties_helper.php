<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Combine Chitti List',
    'primary_table'       => 'combine_chitties',
    'default_column'      => 'id',
    'table'               => 'combine_chitties',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'combine_chitties',
    'add_title'           => 'Add Combine Chitti',
    'chitti_hides'        => '',
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
    array("Combine chittie No", "id", FALSE, "id", FALSE, FALSE),
    array("Date", "date", FALSE, "date", FALSE, FALSE,'DATE_FORMAT(date, "%d-%m-%Y") as date'),
    array("Account Name", "account_name", FALSE, "account_name", FALSE, FALSE),
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

  $attributes['combine_chitties'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'account_name'  => array('Account Name', 'Select', TRUE, '', TRUE),
    'site_name'  => array('Site Name', 'Select', TRUE, '', TRUE),
    'purity'        => array('Purity', 'Select Purity.', TRUE, '', TRUE),
    'date'          => array('Date', 'Enter Date.', TRUE, '', TRUE),
    'created_at'    => array('Created At', 'Enter Date.', TRUE, '', TRUE)
  );
  
  $attributes['combine_chitti_details'] = array(
    'combine_chitti_id' => array('', '', TRUE, '', TRUE),
    'voucher_id' => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'argold/combine_chitties';
  $actions["View"] = array('request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/view/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'btn-sm green');
  
  $actions["Delete"] = array('request' => "http",
                               'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                               'confirm_message' => "Do you want to delete",
                               'js_function' => "",
                               'class' => 'text-danger text-uppercase');
  return $actions;
}