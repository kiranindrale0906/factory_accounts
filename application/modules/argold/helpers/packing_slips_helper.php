<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Packing Slip List',
    'primary_table'       => 'packing_slips',
    'default_column'      => 'id',
    'table'               => 'packing_slips',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'packing_slips',
    'add_title'           => 'Add Packing Slip',
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
    array("Packing Slip No", "id", FALSE, "id", FALSE, FALSE),
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

  $attributes['packing_slips'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'site_name'     => array('Factory Name', '', TRUE, '', TRUE),
    'account_name'  => array('Account Name', 'Select', TRUE, '', TRUE),
    'chitti_id'     => array('Chitti', 'Enter Chitti.', TRUE, '', TRUE),
    'purity'        => array('Purity', 'Select Purity.', TRUE, '', TRUE),
    'date'          => array('Date', 'Enter Date.', TRUE, '', TRUE),
    'created_at'    => array('Created At', 'Enter Date.', TRUE, '', TRUE),
    'no_of_packets' => array('No. of Packets', '', TRUE, '', TRUE),
    'packet_gross_weight' => array('Packet Weight', '', TRUE, '', TRUE),
    'sale_type'     => array('Sale Type', '', TRUE, '', TRUE),
    'rate'          => array('Rate', '', TRUE, '', TRUE),
    'product_rate'          => array('Product Rate', '', TRUE, '', TRUE),
    'credit_weight' => array('Credit Weight', '', TRUE, '', TRUE),
    'debit_amount'  => array('Debit Amount', '', TRUE, '', TRUE),
    'sgst_amount'   => array('SGST', '', TRUE, '', TRUE),
    'cgst_amount'   => array('CGST', '', TRUE, '', TRUE),
    'taxable_amount'   => array('Taxable Amount', '', TRUE, '', TRUE),
    'stone_amount'   => array('Stone Amount', '', TRUE, '', TRUE),
    'manual_taxable_amount'   => array('Manual Taxable Amount', '', TRUE, '', TRUE),
    'ounce_rate'   => array('Ounce Rate', '', FALSE, '', TRUE),
    'stone'   => array('Stone', '', FALSE, '', TRUE),
    'premium_rate'   => array('Premium Rate', '', FALSE, '', TRUE),
    'colour'   => array('Colour', '', FALSE, '', TRUE),
    'description'   => array('Description', '', FALSE, '', TRUE),
    'net_weight'   => array('Net Weight', '', FALSE, '', TRUE),
    'quantity'   => array('Quantity', '', FALSE, '', TRUE),
    'making_charge'   => array('Making Charge', '', FALSE, '', TRUE),

  );
  
  $attributes['packing_slip_details'] = array(
    'packing_slip_id' => array('', '', TRUE, '', TRUE),
    'packing_slip_net_weight' => array('', '', TRUE, '', TRUE),
    'packing_slip_category_name' => array('', '', TRUE, '', TRUE),
    'packing_slip_description' => array('', '', TRUE, '', TRUE),
    'packing_slip_colour' => array('', '', TRUE, '', TRUE),
    'packing_slip_quantity' => array('', '', TRUE, '', TRUE),
    'packing_slip_making_charge' => array('', '', TRUE, '', TRUE),
    'packing_slip_stone' => array('', '', TRUE, '', TRUE),
    'packing_slip_code' => array('', '', TRUE, '', TRUE),
    'packing_slip_gross_weight' => array('', '', TRUE, '', TRUE),
    'voucher_id' => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'argold/packing_slips';
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