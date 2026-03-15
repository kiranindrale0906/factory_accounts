<?php defined('BASEPATH') OR exit('No direct script access allowed.');
function getTableSettings() {
  return array(
    'page_title'          => 'Migrations List',
    'primary_table'       => 'migrations',
    'default_column'      => 'id',
    'table'               => 'migrations',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'migrations',
    'add_title'           => 'Add Migrations',
    'export_title'        => '',
    'edit'                => '',
    'custom_table_header' => true,
  );
}

/*
  0 => Title of column displayed on table header
  1 => Database field Name
  2 => Order flag
  3 => Order by field name
  4 => Filter Flag
  5 => Expand Text Flag
  6 => Select alias column
  7 => Module Name
  8 => Exact Match Flag
  9 => Filter Type  //static_dropdown, dynamic_dropdown, static_multiselect, dynamic_multiselect, autocomplete, 
                     range, daterange, date, text
       Image Type   //if image is to be shown set Filter Type = 'image'
  10 => Filter Values //For static values use array. eg: array(1,2,3).
                      //For autocomplete use array(<table name>, <field_name)
                      //For dynamic dropdown / multiselect use SQL query
       Image Path     //Set path of image if Filter Type = 'image'
  11 => Default Image Path //if Filter Type='image' set default image full path                      
*/

function list_settings() {
  return array(
    array("ID", "id", TRUE, "id", TRUE, FALSE, "id", "ID", FALSE,"text"),
    array("File Name", "file_name", TRUE, "file_name", TRUE, FALSE, "file_name", "Name","","",),
    array("Module Name", "module_name", TRUE, "module_name", TRUE, FALSE, "module_name", "Name","","",),
    array("Created At", "created", TRUE, "migrations.created_at", TRUE, FALSE, "DATE_FORMAT(migrations.created_at,'%d-%m-%Y') as created", "Created At","","",),
  );
}

function get_field_attribute($table, $field) {
  $attributes = array();
  $attributes['migrations'] = array(
    'id' => array('', '', FALSE, '', FALSE),
    'occupation_name'  => array('Name', 'Enter Occupation Name ', TRUE, '', TRUE),
    'module_name' => array('Module Name', 'Enter Module Name', TRUE, '', TRUE),
    'file_name'  => array('File Name', 'Enter File Name ', TRUE, '', TRUE),
  );
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  return array();
}

