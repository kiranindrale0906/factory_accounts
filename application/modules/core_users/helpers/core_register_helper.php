<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function coreregister_get_field_attribute($table, $field) {
  $attributes = array();

  $attributes = array(
    'name'       => array('Name', 'Enter Name', TRUE, '', TRUE),
    'email_id'         => array('Email Id', 'Enter Email Id', TRUE, '', TRUE),
    'mobile_no'       => array('Contact No', 'Enter Mobile Number', TRUE, '', TRUE),
    'encrypted_password' 			   => array('Password', 'Enter Password', TRUE, '', TRUE),
    'confirm_password' => array('Confirm Password', 'Enter Confirm Password', TRUE, '', TRUE),
  );
  return $attributes[$field];
}

