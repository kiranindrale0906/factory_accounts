<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getTableSettings() {
  return array(
    'page_title'          => 'ALL Books',
    'primary_table'       => 'ac_book',
    'default_column'      => 'id',
    'table'               => 'ac_book',
    'join_columns'        => '',
    'join_type'           => '',
    'where'               => '',
    'where_ids'           => '',
    'order_by'            => '',
    'limit'               => "20",
    'extra_select_column' => 'id',
    'actionFunction'      => '',
    'headingFunction'     => 'list_settings',
    'search_url'          => 'books',
    'add_title'           => 'Add Book',
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
    array("Name", "name", TRUE, "name", TRUE, TRUE),
    array("Book Code", "book_code", TRUE, "book_code", TRUE, TRUE),
    array("PCS", "pcs", TRUE, "pcs", TRUE, TRUE),
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

  $attributes['books'] = array(
    'id'            => array('', '', TRUE, '', TRUE),
    'name'          => array("Name", 'Enter Name.', TRUE, '', TRUE),
    'book_code'          => array("Book Code", 'Enter Book Code.', TRUE, '', TRUE),
    'pcs'          => array("PCS", 'Enter PCS.', TRUE, '', TRUE),
    'gross_wt'          => array("Gross Weight", 'Enter Gross Weight.', TRUE, '', TRUE),
    'melting'          => array("Melting", 'Enter Melting.', TRUE, '', TRUE),
    'fine_wt'          => array("Fine Wt", 'Enter Fine Wt.', TRUE, '', TRUE),
    'amount'          => array("Amount", 'Enter Amount.', TRUE, '', TRUE),
    'wastage'      => array('Wastage', 'Enter Wastage', FALSE, '', TRUE),
    'company_id'    => array('', '', TRUE, '', TRUE),
  );
 
  return $attributes[$table][$field];
}
function get_row_actions($row, $url, $select_url, $filter) {
  $actions = array();
  $controller = 'others/books';
 $actions["Edit"] = array( 'request' => "http", 
                           'url' => ADMIN_PATH.$controller.'/edit/'.$row['id'],
                           'confirm_message' => "",
                           'class' => 'text-warning text-uppercase');

  $actions["Delete"] = array('request' => "http",
                               'url' => ADMIN_PATH.$controller.'/delete/'.$row['id'],
                               'confirm_message' => "Do you want to delete",
                               'js_function' => "",
                               'class' => 'text-danger text-uppercase');
  return $actions;
}