<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');

/*
  | [0] => Label
  | [1] => Placeholder
  | [2] => Mandatory/Not Mandatory
  | [3] => Class
  | [4] => Autofocus
  | [5] => Readonly
  | [6] => disabled
 */

function get_form_title($table, $action, $event_name ='') {

  if (!empty($event_name))
    $form_title = $event_name;
  else
    $form_title = $table . ' ' . $action;
  return ucwords($form_title);
}

function get_form_action($table, $action, $record = array()) {
  $form_action = base_url($table) . '/store';
  if ($action == 'edit' || $action == 'update') {
    $form_action = base_url($table) . '/update/' . $record['id'];
  }
  return $form_action;
}

function get_image_url($key, $value) {
  $ci         = &get_instance();
  $controller = $ci->router->fetch_class();
  $path       = base_url('uploads');
  $path       .= '/' . $controller . '/' . $key . '/' . $value;
  return $path;
}


