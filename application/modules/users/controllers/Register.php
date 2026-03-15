<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/core_users/controllers/Core_register.php";
class Register extends Core_register {

  public function __construct() {
    parent::__construct();
    $this->load->helper('core_users/core_register');
  }
}
