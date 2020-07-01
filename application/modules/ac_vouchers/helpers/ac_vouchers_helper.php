<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function ac_vouchers_getTableSettings($table_setting_arg=array()) {
  $ci = &get_instance();
  if(!empty($table_setting_arg['where'])) {
    $table_setting_arg['where'] = 'company_id='.(!empty($ci->session->userdata('company_id'))?$ci->session->userdata('company_id'):-1)." AND ".$table_setting_arg['where'];
  }else{
    $table_setting_arg['where'] = 'company_id='.(!empty($ci->session->userdata('company_id'))?$ci->session->userdata('company_id'):-1);
 
  }
  
  $table_setting= array('page_title'          => '',
                        'primary_table'       => 'ac_vouchers',
                        'default_column'      => 'ac_vouchers.id',
                        'table'               => array('ac_vouchers','ac_company'),
                        'join_conditions'     => array('ac_vouchers.company_id=ac_company.id'),
                        'join_type'           => '',
                        'where'               => '',
                        'where_ids'           => '',
                        'order_by'            => 'ac_vouchers.id desc',
                        'limit'               => "20",
                        'extra_select_column' => 'ac_vouchers.id',
                        'actionFunction'      => '',
                        'headingFunction'     => 'list_settings',
                        'search_url'          => 'bank_issue_voucher',
                        'add_title'           => '',
                        'export_title'        => '',
                        'edit'                => '',
                        'custom_table_header' => true,
                        'clear_filter'        => true,
                      );
  if(!empty($_GET['from']) && !empty($_GET['to'])){
    $table_setting_arg['where'] .=' and ac_vouchers.created_at >= "'.date('Y-m-d',strtotime($_GET['from'])).'" and ac_vouchers.created_at <"'.date('Y-m-d',strtotime($_GET['to'])).'"';
  }
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
  $ci=&get_instance();

  $list_setting['voucher_date'] = array("Date", "voucher_date", TRUE, "voucher_date", TRUE, TRUE,
                                        "DATE_FORMAT(ac_vouchers.created_at, '%d-%m-%Y') as voucher_date");
  $list_setting['created_time'] = array("Time", "created_at", FALSE, "created_at", FALSE, TRUE,
                                        "date_format(ac_vouchers.created_at,'%H:%i:%s') as created_at");
  $list_setting['voucher_number'] = array("Voucher", "voucher_number", FALSE, "voucher_number", TRUE, FALSE);
  $list_setting['gold_rate'] = array("Gold Rate", "gold_rate", FALSE, "gold_rate", TRUE, FALSE);
  $list_setting['rate'] = array("Rate", "rate", FALSE, "rate", TRUE, FALSE);
  $list_setting['cash_amount'] = array("Cash Amount", "cash_amount", FALSE, "cash_amount", TRUE, FALSE,"FORMAT(ac_vouchers.cash_amount,ac_company.decimal_no) as cash_amount",
                                      '','','','text-right');
  $list_setting['gold_weight'] = array("Gold Weight", "gold_weight", FALSE, "gold_weight", TRUE, FALSE);
  $list_setting['gold_rate_purity'] = array("Gold Rate Purity", "gold_rate_purity", FALSE, "gold_rate_purity", TRUE, FALSE);
  $list_setting['gold_weight_purity'] = array("Gold Weight Purity", "gold_weight_purity", FALSE, "gold_weight_purity", TRUE
                                              , FALSE);
  $list_setting['transaction_type'] = array("Transaction Type", "transaction_type", TRUE, "transaction_type", TRUE, TRUE);
  $list_setting['bank_name'] = array("Bank Name", "bank_name", TRUE, "bank_name", TRUE, TRUE);
  $list_setting['cheque_number'] = array("Check Number", "cheque_number", TRUE, "cheque_number", TRUE, TRUE);
  
  if ($ci->router->class=='metal_issue_vouchers') {
    $list_setting['receipt_type'] = array("Issue Type", "receipt_type", FALSE, "receipt_type", TRUE, TRUE);
  } else {
    $list_setting['receipt_type'] = array("Type", "receipt_type", FALSE, "receipt_type", TRUE, TRUE);
  }


  $list_setting['account_name'] = array("Account", "account_name", TRUE, "account_name", TRUE, TRUE);
  $list_setting['from_account_name'] = array("From Account Name", "from_account_name", TRUE, "from_account_name", TRUE, TRUE);

  $list_setting['from_group_name'] = array("From Group Name", "from_group_name", TRUE, "from_group_name", TRUE, TRUE);
  $list_setting['to_group_name'] = array("To Group Name", "to_group_name", TRUE, "to_group_name", TRUE, TRUE);
  
  
  $list_setting['amount'] = array("Amount.", "amount", TRUE, "FORMAT(ac_vouchers.amount,ac_company.decimal_no) as amount", FALSE, TRUE,"amount",'','','','text-right');

  $list_setting['hook_kdm_purity'] = array("Hook KDM Purity", "hook_kdm_purity", TRUE, 
                                           "hook_kdm_purity", FALSE, TRUE);
  $list_setting['quantity'] = array("Quantity", "quantity", TRUE, "quantity", FALSE, TRUE);
  $list_setting['lumpsum_amount'] = array("Lumpsum Amount", "lumpsum_amount", FALSE, "lumpsum_amount", TRUE, TRUE,
                                          "FORMAT(ac_vouchers.lumpsum_amount,ac_company.decimal_no) as lumpsum_amount",'','','','text-right');
  $list_setting['interest_per_day'] = array("Interest per Day", "interest_per_day", FALSE, "interest_per_day", TRUE, TRUE);

  $list_setting['debit_weight'] = array("Debit Wt.", "debit_weight", FALSE, "debit_weight", TRUE, TRUE);
  $list_setting['credit_weight'] = array("Credit Wt.", "credit_weight", FALSE, "credit_weight", TRUE, TRUE);

  if ($ci->router->class=='metal_issue_vouchers') {
    $list_setting['purity'] = array("Factory Purity", "purity", FALSE, "purity", TRUE, TRUE);
    $list_setting['fine'] = array("Factory Fine", "fine", FALSE, "fine", TRUE, TRUE);
    $list_setting['factory_purity'] = array("Issue Purity", "factory_purity", FALSE, "factory_purity", TRUE, TRUE);
    $list_setting['factory_fine'] = array("Issue Fine", "factory_fine", FALSE, "factory_fine", TRUE, TRUE);
  } else {
    $list_setting['purity'] = array("Purity", "purity", FALSE, "purity", TRUE, TRUE);
    $list_setting['fine'] = array("Fine", "fine", FALSE, "fine", TRUE, TRUE);
    $list_setting['factory_purity'] = array("Factory Purity", "factory_purity", FALSE, "factory_purity", TRUE, TRUE);
    $list_setting['factory_fine'] = array("Factory Fine", "factory_fine", FALSE, "factory_fine", TRUE, TRUE);
  }

  
  $list_setting['Pure Gold'] = array("Narration", "pure_gold_credit", FALSE, "pure_gold_credit", TRUE, TRUE);
  $list_setting['department_name'] = array("Department Name", "department_name", FALSE, "department_name", TRUE, TRUE);
  $list_setting['debit_amount'] = array("Debit Amt", "debit_amount", TRUE, "debit_amount", FALSE, TRUE,"FORMAT(ac_vouchers.debit_amount,ac_company.decimal_no) as debit_amount",
                                        '','','','text-right');
  $list_setting['credit_amount'] = array("Credit Amt.", "credit_amount", TRUE, "credit_amount", FALSE, TRUE,"FORMAT(ac_vouchers.credit_amount,ac_company.decimal_no) as credit_amount",     
                                        '','','','text-right');
  $list_setting['total_gross_weight'] = array("Total Gross Wt", "total_gross_weight", FALSE, "total_gross_weight", TRUE, TRUE);
  $list_setting['total_net_weight'] = array("Total Net Wt", "total_net_weight", FALSE, "total_net_weight", TRUE, TRUE);
  $list_setting['total_fine_weight'] = array("Total Fine Wt", "total_fine_weight", FALSE, "total_fine_weight", TRUE, TRUE);
  $list_setting['total_amount'] = array("Total Amount", "total_amount", FALSE, "total_amount", TRUE, TRUE,"FORMAT(ac_vouchers.total_amount,ac_company.decimal_no) as total_amount",    
                                        '','','','text-right');



  $list_setting['narration'] = array("Narration", "narration", FALSE, "narration", TRUE, TRUE);
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
  $attributes['voucher_date'] = array('Date', 'Enter Date.', TRUE, '', TRUE,TRUE);
  $attributes['account_name'] = array('Account', 'Enter Account', TRUE, '', TRUE);
  $attributes['from_account_name'] = array('From Account', 'Enter From Account', TRUE, '', TRUE);
  $attributes['from_group_name'] = array('From Group Name', 'Enter From Group', TRUE, '', TRUE);
  $attributes['to_group_name'] = array('To Group Name', 'Enter To Group', TRUE, '', TRUE);
  $attributes['amount'] = array('Amount', 'Enter Amount', TRUE, '', TRUE);
  $attributes['credit_amount'] = array('Credit Amount', 'Enter Credit Amount', TRUE, '', TRUE);
  $attributes['bank_name'] = array("Bank Name", "Enter Bank Name", TRUE,'', TRUE);
  $attributes['gold_weight'] = array("Gold Weight", "Enter Gold Weight", TRUE,'', TRUE);
  $attributes['gold_rate'] = array("Gold Rate", "Enter Gold Rate", TRUE,'', TRUE);
  $attributes['rate'] = array("Rate", "Enter Rate", TRUE,'', TRUE);
  $attributes['cash_amount'] = array("Cash Amount", "Enter Cash Amount", TRUE,'', TRUE);
  $attributes['gold_weight_purity'] = array("Gold Weight Purity", "Enter Gold Weight Purity", TRUE,'', TRUE);
  $attributes['gold_rate_purity'] = array("Gold Rate Purity", "Enter Gold Weight Purity", TRUE,'', TRUE);
  $attributes['transaction_type'] = array("Transaction Type", "Select Transaction Type", FALSE,'', TRUE);
  $attributes['lumpsum_amount'] = array("Lumpsum Amount", "Enter Lumpsum Amount", FALSE,'', TRUE);
  $attributes['interest_per_day'] = array("Interest Per Day", "Enter Interest Per Day", FALSE,'', TRUE);

  $attributes['cheque_number'] = array("Check Number", "Enter Check Number", FALSE,'', FALSE);
  $attributes['debit_amount'] = array('Debit Amount', 'Enter Debit Amount', TRUE, '', TRUE);
  $attributes['receipt_type'] = array('Type', 'Select Type', TRUE, '', TRUE);
  $attributes['factory_purity'] = array('Factory Purity', 'Enter factory purity', TRUE, '', TRUE);
  $attributes['hook_kdm_purity'] = array('Hook KDM Purity', 'Enter hook kdm purity', TRUE, '', TRUE);
  $attributes['quantity'] = array('Quantity', 'Enter quantity', TRUE, '', TRUE);
  
  

  $attributes['type'] = array('Type', 'Type', TRUE, '', TRUE);

  $attributes['narration'] = array('Narration', 'Enter Narration', FALSE, '', TRUE);
  $attributes['vouchersamount'] = array('vouchersamount', 'Enter vouchersamount', FALSE, '', TRUE); 
  $attributes['total_gross_weight'] = array('Gross Weight', 'Gross Weight', FALSE, '', TRUE); 
  $attributes['total_net_weight'] = array('Net Weight', 'Net Weight', FALSE, '', TRUE); 
  $attributes['total_fine_weight'] = array('Fine Weight', 'Fine Weight', FALSE, '', TRUE); 
  $attributes['total_amount'] = array('Value', 'Value', FALSE, '', TRUE);
  $attributes['company_id'] = array('', '', TRUE, '', TRUE);
  $attributes['account_id'] = array('', '', TRUE, '', TRUE);
  $attributes['from_account_id'] = array('', '', TRUE, '', TRUE);
  $attributes['from_group_id'] = array('', '', TRUE, '', TRUE);
  $attributes['to_group_id'] = array('', '', TRUE, '', TRUE);
  $attributes['document'] = array('', '', TRUE, '', TRUE);

  $attributes['credit_weight'] = array('Credit Weight', 'Enter Credit Weight', TRUE, '', TRUE);
  $attributes['debit_weight'] = array('Debit Weight', 'Enter Weight', TRUE, '', TRUE);

  if ($ci->router->class=='metal_issue_vouchers') {
    $attributes['purity'] = array('Factory Purity', 'Enter Purity', TRUE, '', TRUE);
    $attributes['fine'] = array('Factory Fine', '', FALSE, '', TRUE,TRUE);
    $attributes['factory_purity'] = array('Issue Purity', 'Enter factory purity', TRUE, '', TRUE);
    $attributes['factory_fine'] = array('Issue Fine', '', FALSE, '', TRUE,TRUE);
    $attributes['type'] = array('Type', ' Type', TRUE, '', TRUE);
  } else {
    $attributes['purity'] = array('Purity', 'Enter Purity', TRUE, '', TRUE);
    $attributes['fine'] = array('Fine', '', FALSE, '', TRUE,TRUE);
    $attributes['factory_purity'] = array('Factory Purity', 'Enter factory purity', TRUE, '', TRUE);
    $attributes['factory_fine'] = array('Factory Fine', '', FALSE, '', TRUE,TRUE);    
    $attributes['type'] = array('Type', ' Type', TRUE, '', TRUE);
    $attributes['dd_type'] = array('Daily Drawer Type', 'Select Daily Drawer Type', TRUE, '', TRUE);
  }

  $attributes['arg_weight'] = array('ARG Weight', 'ARG Weight', FALSE, '', FALSE,TRUE);
  $attributes['department_name'] = array('Department Name', 'Department', FALSE, '', TRUE);
  $attributes['department_id'] = array('Department', ' Department', FALSE, '', FALSE,TRUE);
  
  $attributes['group_name'] = array('Group Name', ' Group Name', TRUE, '', TRUE);
  $attributes['gst_number'] = array('GST Number', ' GST Number', TRUE, '', TRUE);
  $attributes['cash_bill'] = array('Cash/Bill', 'Cash Bill', TRUE, '',TRUE);
  $attributes['payment_term'] = array('Payment Term', 'Payment Term', TRUE, '', TRUE);
  $attributes['hallmark_number'] = array('Hallmark Number', 'Hallmark Number', false, '', TRUE);
  $attributes['has_hallmark'] = array('', 'Has Hallmark', TRUE, '', TRUE);
  $attributes['total_value'] = array('Value', 'Value', FALSE, '',TRUE);

  $attributes['add_more'] = array('', 'add_more', FALSE, '',TRUE);
  if(!empty($required_field)) {
    $attributes[$ci->router->class] = array_intersect_key($attributes, array_flip($required_field));
  }
  
  return !empty($attributes[$table][$field])?$attributes[$table][$field]:false;
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