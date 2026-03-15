<?php defined("BASEPATH") OR exit("No direct script access allowed.");
function getTableSettings($data = array(), $where = array()) {
  return  array(
    'page_title'          => 'Product Rolling List',
    'primary_table'       => 'product_rollings',
    'default_column'      => 'product_rollings.id',
    'table'               => array('product_rollings'),
    'join_conditions'     => array(),
    'join_type'           =>'',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "50",
    'filter'              => ' ',
    'extra_select_column' => 'product_rollings.id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'product_rollings',
    'add_title'           => '',
    'export_title'        => '',
    'import_title'        => '',
    'select_column'       => true,                // Can user select columns on the table
    'arrange_column'      => true,                // Can user arrange columns on the table  
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
    array("Date", "created_at", false, "created_at", TRUE, TRUE,'created_at'),
    array("Chain Name", "chain_name", false, "chain_name", TRUE, TRUE,'chain_name'),
    array("Balance Gross", "balance_gross", false, "balance_gross", TRUE, TRUE,'balance_gross'),
    
  );
}

function get_field_attribute($table, $field) {
  $attributes = array(
    'id'            => array('', '', FALSE, '', TRUE),
    'chain_name'       => array('Chain Name', 'Select Chain Name', FALSE, '', TRUE),
    'balance_gross'          => array('Balance Gross', 'Enter Balance Gross', FALSE, '', TRUE),
  );

  return $attributes[$field];
}
