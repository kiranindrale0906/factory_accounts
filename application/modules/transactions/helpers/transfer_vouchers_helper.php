<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Voucher List',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'id',
    'table'               => 'ac_vouchers',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => array(),
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id,',
    'actionFunction'      => '',
    'headingFunction'     => 'loss_accounts',
    'search_url'          => 'refresh',
    'add_title'           => 'ADD Transfer Records',
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
    array("Account Name", "account_name", FALSE, "account_name", FALSE, FALSE),
    array("Voucher Name", "voucher_number", FALSE, "voucher_number", FALSE, FALSE),
    array("Voucher Type", "voucher_Type", FALSE, "voucher_Type", FALSE, FALSE),
    array("Credit Weight", "credit_weight", FALSE, "credit_weight", FALSE, FALSE),
    array("Credit Weight", "credit_weight", FALSE, "credit_weight", FALSE, FALSE),
    array("Debit Weight", "debit_weight", FALSE, "credit_weight", FALSE, FALSE),
    array("Credit Amount", "credit_amount", FALSE, "credit_amount", FALSE, FALSE),
    array("Debit Amount", "debit_amount", FALSE, "debit_amount", FALSE, FALSE),
    array("Purity", "purity", FALSE, "purity", FALSE, FALSE),
    array("Fine", "fine", FALSE, "fine", FALSE, FALSE),
    array("Factory Purity", "factory_purity", FALSE, "factory_purity", FALSE, FALSE),
    array("Factory Fine", "factory_fine", FALSE, "fine", FALSE, FALSE),
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

  $attributes['transfer_vouchers'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'from_date'            => array('From Date', '', TRUE, '', TRUE),
    'to_date'            => array('To Date', '', TRUE, '', TRUE),
    'account_name'            => array('Account Name', '', TRUE, '', TRUE),
    'account_id'            => array('Account ID', '', TRUE, '', TRUE),
   );
  return $attributes[$table][$field];
}
