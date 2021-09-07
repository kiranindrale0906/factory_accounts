<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'Loss Account List',
    'primary_table'       => 'ac_vouchers',
    'default_column'      => 'id',
    'table'               => 'ac_vouchers',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => array('account_name'=>'Loss Account'),
    'where_ids'           => '',
    'order_by'            => 'id desc',
    'limit'               => "20",
    'extra_select_column' => 'id,',
    'actionFunction'      => '',
    'headingFunction'     => 'loss_accounts',
    'search_url'          => 'refresh',
    'add_title'           => '',
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
    array("Weight", "credit_weight", FALSE, "credit_weight", FALSE, FALSE),
    array("Purity", "purity", FALSE, "purity", FALSE, FALSE),
    array("Fine", "fine", FALSE, "fine", FALSE, FALSE),
    array("Factory Purity", "factory_purity", FALSE, "factory_purity", FALSE, FALSE),
    array("Factory Fine", "factory_fine", FALSE, "fine", FALSE, FALSE),
    array("Amount", "credit_amount", FALSE, "credit_amount", FALSE, FALSE),
    // array("Site Name", "site_name", FALSE, "site_name", FALSE, FALSE),
    // array("Action", "action", FALSE, "action", FALSE, FALSE),
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

  $attributes['loss_accounts'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'weight'            => array('Weight', '', TRUE, '', TRUE),
    'fine'          => array('Fine', '', TRUE, '', TRUE),
    'factory_fine'          => array('Factory Fine', '', TRUE, '', TRUE),
    'purity'          => array('Purity', '', TRUE, '', TRUE),
    'factory_purity'          => array('Factory Purity', '', TRUE, '', TRUE),
    'site_name'          => array('Site Name', 'Select Site Name', TRUE, '', TRUE),
    'rate'          => array('Rate', '', TRUE, '', TRUE),
   );
  return $attributes[$table][$field];
}

// function get_row_actions($row, $url, $select_url, $filter) {
//   $actions = array();
//   $controller = 'argold/refresh';
//   $actions["View"] = array('request' => "http", 
//                            'url' => ADMIN_PATH.$controller.'/view/'.$row['id'],
//                            'confirm_message' => "",
//                            'class' => 'green');
//   $actions["Edit"] = array('request' => "http", 
//                            'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
//                            'confirm_message' => "",
//                            'class' => '');
//   if($row['metal_receipt_id']==0){
//     $actions["Create metal receipt"] = array('request' => "http", 
//                            'url' => ADMIN_PATH.'transactions/metal_receipt_vouchers?refresh_id='.$row['id'],
//                            'confirm_message' => "",
//                            'class' => 'orange');
//   }else{
//     $actions["Metal receipt view"] = array('request' => "http", 
//                            'url' => ADMIN_PATH.'argold/voucher_details/view/'.$row['metal_receipt_id'],
//                            'confirm_message' => "",
//                            'class' => 'red');
//   }

//   // $actions["Delete"] = array('request' => "http",
//   //                              'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
//   //                              'confirm_message' => "Do you want to delete",
//   //                              'js_function' => "",
//   //                              'class' => 'text-danger text-uppercase');
//   return $actions;
// }