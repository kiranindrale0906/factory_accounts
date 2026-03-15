<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'List',
    'primary_table'       => 'packing_slip_details',
    'default_column'      => 'id',
    'table'               => 'packing_slip_details',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => '',
    'add_title'           => '',
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
    array("Factory Purity", "factory_purity", FALSE, "factory_purity", FALSE, FALSE),
    array("Factory Fine", "factory_fine", FALSE, "fine", FALSE, FALSE),
    array("Amount", "credit_amount", FALSE, "credit_amount", FALSE, FALSE),
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

  $attributes['metal_issue_packing_slips'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'packing_slip_id'            => array('', '', TRUE, '', TRUE),
    'net_weight' => array('Net weight', '', TRUE, '', TRUE),
    'gross_weight' => array('Gross weight', '', TRUE, '', TRUE),
    'making_charge' => array('Making Charge', '', TRUE, '', TRUE),
    'stone' => array('Stone', '', TRUE, '', TRUE),
    'colour' => array('Colour', '', False, '', False),
    'code' => array('Code', '', False, '', False),
    'description' => array('Description', '', False, '', False),
    'category_name' => array('Category Name', '', False, '', False),
    'category_2' => array('Category Two', '', False, '', False),
    'site_name' => array('Site Name', '', False, '', False),
    'sr_no' => array('Tag No', '', False, '', False),
    'quantity' => array('Quantity', '', False, '', False),
  );
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  return $actions;
}