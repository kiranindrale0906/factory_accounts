<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function coreuseremailverify_getTableSettings() {
  return array();
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

function coreuseremailverify_list_settings() {
  return array();
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

function coreuseremailverify_get_field_attribute($table, $field) {

  $attributes['user_email_verify'] = array(
    'id'               => array('', '', TRUE, '', TRUE),
    'verify_code'      => array('Verification Code', 'Enter Verification Code', TRUE, '', TRUE));

  return $attributes[$table][$field];
}