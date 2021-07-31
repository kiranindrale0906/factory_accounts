<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings($data=array(),$where=array()) {
  return array(
    'page_title'          => 'packing slip List',
    'primary_table'       => 'packing_slip_details',
    'default_column'      => 'id',
    'table'               => 'packing_slip_details',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => $where,
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'packing_slip_details',
    'add_title'           => '',
    'export_title'        => 'Export',
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
    array("Tag no", "sr_no", FALSE, "sr_no", FALSE, FALSE),
    array("Quantity", "quantity", FALSE, "quantity", FALSE, FALSE),
    array("Gross Wt", "gross_weight", FALSE, "gross_weight", FALSE, FALSE),
    array("Net Wt", "net_weight", FALSE, "net_weight", FALSE, FALSE),
    array("Stone", "stone", FALSE, "stone", FALSE, FALSE),
    array("Melting", "purity", FALSE, "purity", FALSE, FALSE),
    array("Pure", "pure", FALSE, "pure", FALSE, FALSE),
    array("Category Name", "category_name", FALSE, "category_name", FALSE, FALSE),
    array("Category 2", "category_2", FALSE, "category_2", FALSE, FALSE),
    array("Description", "description", FALSE, "description", FALSE, FALSE),
    array("Colour", "colour", FALSE, "colour", FALSE, FALSE),
    array("Making Charge", "making_charge", FALSE, "making_charge", FALSE, FALSE),
    array("Code", "code", FALSE, "code", FALSE, FALSE),
    array("Total", "total", FALSE, "total", FALSE, FALSE),
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

  // $attributes['refresh'] = array(
  //   'id'            => array('', '', TRUE, '', TRUE),
  //   'weight'            => array('Weight', '', TRUE, '', TRUE),
  //   'fine'          => array('Fine', 'Enter Chitti.', TRUE, '', TRUE),
  //   'purity'          => array('Purity', 'Select Purity.', TRUE, '', TRUE),
  //  );
  $attributes['packing_slip_details'] = array(
    'packing_slip_id' => array('', '', TRUE, '', TRUE),
    'net_weight' => array('Net weight', '', TRUE, '', TRUE),
    'stone' => array('Stone', '', TRUE, '', TRUE),
    'colour' => array('Colour', '', TRUE, '', TRUE),
    'code' => array('Code', '', TRUE, '', TRUE),
    'description' => array('Description', '', TRUE, '', TRUE),
  );
 
  return $attributes;
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'argold/packing_slip_details';
  $actions["Edit"] = array('request' => "http", 
                           'url' => ADMIN_PATH.'argold/metal_issue_packing_slips/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'btn-sm text-success');

  $actions["Delete"] = array('request' => "http",
                               'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                               'confirm_message' => "Do you want to delete",
                               'js_function' => "",
                               'class' => 'text-danger text-uppercase');
  return $actions;
}