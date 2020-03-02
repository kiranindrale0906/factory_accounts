<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function corelogin_get_field_attribute($table, $field) {
  $attributes = array();

  $attributes = array(
    'email_id' => array('Email/Username', 'Email/Username', TRUE, '', TRUE),
    'password' => array('Password ', 'Enter Password', TRUE, '', TRUE),
  );
  return $attributes[$field];
}

