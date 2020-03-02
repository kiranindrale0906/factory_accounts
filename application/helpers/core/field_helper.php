<?php defined('BASEPATH') OR exit('No direct script access allowed.');

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

// function get_client_ip() {
//     $ipaddress = '';
//     if (getenv('HTTP_CLIENT_IP'))
//         $ipaddress = getenv('HTTP_CLIENT_IP');
//     else if(getenv('HTTP_X_FORWARDED_FOR'))
//         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
//     else if(getenv('HTTP_X_FORWARDED'))
//         $ipaddress = getenv('HTTP_X_FORWARDED');
//     else if(getenv('HTTP_FORWARDED_FOR'))
//         $ipaddress = getenv('HTTP_FORWARDED_FOR');
//     else if(getenv('HTTP_FORWARDED'))
//        $ipaddress = getenv('HTTP_FORWARDED');
//     else if(getenv('REMOTE_ADDR'))
//         $ipaddress = getenv('REMOTE_ADDR');
//     else
//         $ipaddress = 'UNKNOWN';
//     return $ipaddress;
// }

// function get_role(){
//   $role = array('Super Admin' =>1,'Planning Admin'=>2,'Planning Supervisor'=>3,
//             'Operator'=>4
//         );
//   return $role;
// }


