<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings($table_setting_arg=array()) {
  $table_setting= array('page_title'          => 'Outstanding Report',
                        // 'primary_table'       => 'ac_vouchers',
                        // 'default_column'      => 'id',
                        // 'table'               => 'ac_vouchers',
                        // 'join_columns'        => '',
                        // 'join_type'           => '',
                        // 'where'               => '',
                        // 'where_ids'           => '',
                        // 'order_by'            => 'id desc',
                        // 'limit'               => "20",
                        // 'extra_select_column' => 'id',
                        // 'actionFunction'      => '',
                        // 'headingFunction'     => 'list_settings',
                        // 'search_url'          => 'bank_issue_voucher',
                        // 'add_title'           => '',
                        // 'export_title'        => '',
                        // 'edit'                => '',
                        // 'custom_table_header' => true,
                        // 'clear_filter'        => true,
                      );
  
  return $table_setting;
}
//Add Cash Issue Voucher
/*
  0 => column title
  1 => column name
  2 => order flag
  3 => order column
  4 => filter flag
  5 => expand text flag
  6 => select column
*/



function list_settings($list_setting_arg=array()) {
  $list_setting = array();
  return $list_setting;
}

function get_field_attribute($table, $field) {
  // $ci=&get_instance();
  // $attributes = array();
  // $attributes['account_ledger_reports'] = array(
  // 'account_id'=>array('Account Name', 'Select Account Name', TRUE, '', TRUE),
  // 'date_from'=>array('Date From', 'Enter Date From', TRUE, '', TRUE),
  // 'date_to'=>array('Date To', 'Enter Date To', TRUE, '', TRUE));


  // return $attributes[$table][$field];
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
