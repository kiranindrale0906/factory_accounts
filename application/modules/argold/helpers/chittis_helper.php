<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
    $show = (isset($_GET['show_all'])) ? $_GET['show_all'] : '';
  if($show=='yes') $where='account_name in ("OUTSIDE PARTY", "AQUA GOLD", "SWARN SHILP 1", "CHAIN AND JWELLERY")';
  else $where='chitti_hide=0 and account_name in ("OUTSIDE PARTY", "AQUA GOLD", "SWARN SHILP 1", "CHAIN AND JWELLERY")';
 
  return array(
    'page_title'          => 'Chittis List',
    'primary_table'       => 'chitties',
    'default_column'      => 'id',
    'table'               => 'chitties',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => $where,
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id,chitti_hide',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'chittis',
    'add_title'           => 'Add Chittis',
    'chitti_hides'        => 'Add Chittis',
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
    array("Id", "id", FALSE, "id", FALSE, FALSE),
    array("Date", "date", FALSE, "date", FALSE, FALSE,'DATE_FORMAT(date, "%d-%m-%Y") as date'),
    
    // array("Packet No", "packet_no", TRUE, "packet_no", TRUE, TRUE),
    array("Factory", "site_name", FALSE, "site_name", FALSE, FALSE),
    array("Account Name", "account_name", FALSE, "account_name", FALSE, FALSE),
    array("Weight", "weight", FALSE, "weight", FALSE, FALSE),
    // array("Purity", "purity", FALSE, "purity", FALSE, FALSE),
    array("Fine", "fine", FALSE, "fine", FALSE, FALSE),
    array("Issue Fine", "factory_fine", FALSE, "factory_fine", FALSE, FALSE),
    array("Amount", "debit_amount", FALSE, "debit_amount", FALSE, FALSE),
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

  $attributes['chittis'] = array(
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
    'usd_rate'   => array('USD Rate', '', FALSE, '', TRUE),
    'premium_rate'   => array('Premium Rate', '', FALSE, '', TRUE),
    'premium_usd_amount'   => array('Premium USD Amount', '', FALSE, '', TRUE),
    'labour_rate'   => array('Labour Rate', '', FALSE, '', TRUE),
    'labour_usd_amount'   => array('Labour USD Amount', '', FALSE, '', TRUE),
    'freight_usd_amount'   => array('Freight USD Amount', '', FALSE, '', TRUE),

  );
  
  $attributes['chitti_details'] = array(
    'chitti_id' => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}

function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'argold/chittis';
  $actions["View"] = array('request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/view/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'btn-sm green');
  $actions["Hide"] = array('request' => "http", 
                           'url' => ADMIN_PATH.'argold/chitti_hides/update/'.$row['id'].'?from=view',
                           'confirm_message' => "",
                           'class' => 'btn-sm blue');
 
  $actions["Edit"] = array('request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'btn-sm');
  $actions["Detail"] = array('request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/view/'.$row['id'].'?detail=1',
                           'confirm_message' => "",
                           'class' => 'btn-sm');
  $actions["Delete"] = array('request' => "http",
                               'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                               'confirm_message' => "Do you want to delete",
                               'js_function' => "",
                               'class' => 'text-danger text-uppercase');
  return $actions;
}