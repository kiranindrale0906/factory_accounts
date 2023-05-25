<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings($table_setting_arg=array()) {
  $table_setting= array('page_title'          => 'Trial Balance Reports',
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
  $ci=&get_instance();
  $attributes = array();
  $attributes['trial_balances'] = array(
  'company_id'=>array('Company Name', 'Select Company Name', TRUE, '', TRUE),
  'account_id'=>array('Account Name', 'Select Account Name', TRUE, '', TRUE),
  'date_from'=>array('Date From', 'Enter Date From', TRUE, '', TRUE),
  'date'=>array('Date', '', TRUE, '', TRUE),
  'profit_and_loss_search_date'=>array('Date', '', TRUE, '', TRUE),
  'date_to'=>array('Date To', 'Enter Date To', TRUE, '', TRUE));


  return $attributes[$table][$field];
}

function get_current_gold_rate(){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://goldpricez.com/api/rates/currency/inr/measure/gram',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'X-API-Key: f6412fdf260d55b6cb460cb4e5bad69cf6412fdf'
    )
  ));

  $response = curl_exec($curl);
  curl_close($curl);

  $result = json_decode(json_decode($response),true);
  return $result['gram_in_inr'];
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
