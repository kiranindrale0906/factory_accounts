<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
| https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = array(
  array(
    'class'    => 'Authentication',
    'function' => 'check_authentication',
    'filename' => 'Authentication.php',
    'filepath' => 'hooks',
    'params'   => ""
  ),
 
  array(
    'class'    => 'Authorization',
    'function' => 'check_url_authorization',
    'filename' => 'Authorization.php',
    'filepath' => 'hooks',
    'params'   => ""
  ),
 
  array(
    'class'    => 'Inapp_notification',
    'function' => 'check_notification',
    'filename' => 'Inapp_notification.php',
    'filepath' => 'hooks',
    'params'   => ""
  ),
  array(
    'class'    => 'Reset_password',
    'function' => 'is_password_expired',
    'filename' => 'Reset_password.php',
    'filepath' => 'hooks',
    'params'   => ""
  ),
  array(
    'class'    => 'latest_updated',
    'function' => 'get_latest_updated_date',
    'filename' => 'latest_updated.php',
    'filepath' => 'hooks'
  ),

 
  /*$hook['post_controller'] = array(
    array(
      'class'    => 'Api_authentication',
      'function' => 'check_api_authentication',
      'filename' => 'Api_authentication.php',
      'filepath' => 'hooks',
      'params'   => ""
    ),
 
  /*$hook['post_controller'] = array(
    array(
      'class'    => 'Notification',
      'function' => 'check_notification',
      'filename' => 'Notification.php',
      'filepath' => 'hooks',
      'params'   => ""
    ));
  */
 
 /* array(
    'class'    => 'Slack',
    'function' => 'check_slack_access_token_exists',
    'filename' => 'Slack.php',
    'filepath' => 'hooks',
    'params'   => ""
  )*/
); 

