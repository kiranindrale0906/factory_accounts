<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Metal Receipt Gold Rate List',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'id',
    'table'               => 'ac_vouchers',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => 'voucher_type="metal receipt vouchers"',
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id,metal_receipt_id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'refresh',
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

  $attributes['metal_receipt_gold_rates'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'gold_rate'     => array('Gold Rate', '', TRUE, '', TRUE),
    'sale_type'     => array('Sale Type', '', TRUE, '', TRUE),
   );
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  return $actions;
}