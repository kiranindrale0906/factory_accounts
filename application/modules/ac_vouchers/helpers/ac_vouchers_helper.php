<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function ac_vouchers_getTableSettings($table_setting_arg=array()) {
  $table_setting= array('page_title'          => '',
                        'primary_table'       => 'ac_vouchers',
                        'default_column'      => 'id',
                        'table'               => 'ac_vouchers',
                        'join_columns'        => '',
                        'join_type'           => '',
                        'where'               => '',
                        'where_ids'           => '',
                        'order_by'            => 'id desc',
                        'limit'               => "20",
                        'extra_select_column' => 'id',
                        'actionFunction'      => '',
                        'headingFunction'     => 'list_settings',
                        'search_url'          => 'bank_issue_voucher',
                        'add_title'           => '',
                        'export_title'        => '',
                        'edit'                => '',
                        'custom_table_header' => true,
                        'clear_filter'        => true,
                      );
  if(!empty($table_setting_arg)){
    $table_setting=array_merge($table_setting,$table_setting_arg);
  }
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



function ac_vouchers_list_settings($list_setting_arg=array()) {
  $list_setting['voucher_date'] = array("Date", "voucher_date", TRUE, "voucher_date", TRUE, TRUE);
  $list_setting['voucher_number'] = array("Voucher", "voucher_number", FALSE, "voucher_number", TRUE, FALSE);
  $list_setting['bank_name'] = array("Bank Name", "bank_name", TRUE, "bank_name", TRUE, TRUE);
  $list_setting['account_name'] = array("Account", "account_name", TRUE, "account_name", TRUE, TRUE);
  $list_setting['debit_amount'] = array("Credit", "debit_amount", TRUE, "debit_amount", FALSE, TRUE);
  $list_setting['credit_amount'] = array("Debit Amt.", "credit_amount", TRUE, "credit_amount", FALSE, TRUE);
  $list_setting['narration'] = array("Narration", "narration", FALSE, "narration", TRUE, TRUE);

  $list_setting['credit_weight'] = array("Debit Wt.", "credit_weight", FALSE, "credit_weight", TRUE, TRUE);
  $list_setting['debit_weight'] = array("Credit Wt.", "debit_weight", FALSE, "debit_weight", TRUE, TRUE);
  $list_setting['purity'] = array("Purity", "purity", FALSE, "purity", TRUE, TRUE);
  $list_setting['Pure Gold'] = array("Narration", "pure_gold_credit", FALSE, "pure_gold_credit", TRUE, TRUE);

  $list_setting['action'] = array("Action", "action", FALSE, "action", FALSE, FALSE);

  if(!empty($list_setting_arg)) {
    $list_setting = array_intersect_key($list_setting, array_flip($list_setting_arg));
  }
  return $list_setting;
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

function ac_voucher_get_field_attribute($table, $field,$required_field) {
  $ci=&get_instance();
  $attributes = array();
  $attributes['id'] = array('', '', TRUE, '', TRUE);
  $attributes['voucher_date'] = array('Date', 'Enter Date.', TRUE, '', TRUE);
  $attributes['account_name'] = array('Account Name', 'Enter Account Name', TRUE, '', TRUE);
  $attributes['credit_amount'] = array('Credit Amount', 'Enter Credit Amount', TRUE, '', TRUE);
  $attributes['debit_amount'] = array('Debit Amount', 'Enter Debit Amount', TRUE, '', TRUE);
  $attributes['narration'] = array('Narration', 'Enter Narration', FALSE, '', TRUE);
  $attributes['vouchersamount'] = array('vouchersamount', 'Enter vouchersamount', FALSE, '', TRUE);
  $attributes['company_id'] = array('', '', TRUE, '', TRUE);
  $attributes['account_id'] = array('', '', TRUE, '', TRUE);
  $attributes['document'] = array('', '', TRUE, '', TRUE);

  $attributes['purity'] = array('Purity', 'Enter Purity', TRUE, '', TRUE);
  $attributes['credit_weight'] = array('Credit Weight', 'Enter Credit Weight', TRUE, '', TRUE);
  $attributes['debit_weight'] = array('Debit Weight', 'Enter Debit Weight', TRUE, '', TRUE);
  
  if(!empty($required_field)) {
    $attributes[$ci->router->class] = array_intersect_key($attributes, array_flip($required_field));
  }
  
  return $attributes[$table][$field];

  // $attributes = array();


  // $attributes['cash_issue_vouchers'] = array(
  //   'id'              => array('', '', TRUE, '', TRUE),
  //   'voucher_date'    => array('Date', 'Enter Date.', TRUE, '', TRUE),
  //   'account_name'    => array('Account Name', 'Enter Account Name', TRUE, '', TRUE),
  //   'credit_amount'   => array('Credit Amount', 'Enter Credit Amount', TRUE, '', TRUE),
  //   'narration'       => array('Narration', 'Enter Narration', FALSE, '', TRUE),
  //   'vouchersamount'  => array('vouchersamount', 'Enter vouchersamount', FALSE, '', TRUE),
  //   'company_id'      => array('', '', TRUE, '', TRUE),
  //   'account_id'      => array('', '', TRUE, '', TRUE),
  //   'document'      => array('', '', TRUE, '', TRUE),
  // );
 
  // return $attributes[$table][$field];
}

function ac_voucher_get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $ci=&get_instance();
  $controller = 'transactions/'.$ci->router->class; 
  $actions["Edit"] =  array('request' => "http", 
                            'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                            'confirm_message' => "",
                            'class' => 'text-warning text-uppercase');
  $actions["Delete"] = array('request' => "http",
                             'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                             'confirm_message' => "Do you want to delete",
                             'js_function' => "",
                             'class' => 'text-danger text-uppercase');
  $actions["Print Voucher"] = array('request' => "http", 
                                    'url' => ADMIN_PATH.$controller.'/view/'.$row['id'],
                                    'confirm_message' => "",
                                    'class' => 'btn_green');
  return $actions;
}