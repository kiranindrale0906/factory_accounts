<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  $app_autoload['libraries'] = array('ldap'); 
  $app_autoload['helper'] = array('config/upload_helper', 'config/dropdown_helper','authentication/authentication');

  $app_autoload['config'] = array();
  $app_autoload['libraries'] = array('ldap');

  $app_autoload['language'] = array();

  $app_autoload['model'] = array();
?>