<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function core_resetpassword_get_field_attribute($table, $field) {
  $attributes = array();

  $attributes = array(
    'password'=> array('Password', 'Enter Password', TRUE, '', TRUE),
    'confirm_password'  => array('Confirm Password', 'Enter Confirm Password', TRUE, '', TRUE),
    'reset_token'  => array('', '', FALSE, '', TRUE),
    'email'  => array('', '', FALSE, '', TRUE),
  );
  return $attributes[$field];
}
