<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings($table_setting_arg=array()) {
  $table_setting= array('page_title'          => 'Purchase Registers',
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
  $attributes = array(
    'id'            => array('', '', FALSE, '', TRUE),
    'start_date'       => array('Start date', '', FALSE, '', TRUE),
    'end_date'          => array('End date', '', FALSE, '', TRUE),
    'custome_order'          => array('Custome Order', '', FALSE, '', TRUE),
  );

  return $attributes[$field];
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
