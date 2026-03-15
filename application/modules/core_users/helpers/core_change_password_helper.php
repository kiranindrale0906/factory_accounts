<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function corechangepassword_get_field_attribute($table, $field) {
  $attributes = array();

  $attributes = array(
    'old_password'     => array('', 'Enter Old Password', TRUE, '', TRUE),
    'new_password' 		 => array('', 'Enter New Password', TRUE, '', TRUE),
    'confirm_password' => array('', 'Enter Confirm Password', TRUE, '', TRUE),
  );
  return $attributes[$field];
}

