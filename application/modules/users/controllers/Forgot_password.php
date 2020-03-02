<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/core_users/controllers/Core_forgot_password.php";
class Forgot_password extends Core_forgot_password {
  public function __construct() {
    parent::__construct();
    $this->load->helper('core_users/core_forgot_password');
  }
  
}
?>