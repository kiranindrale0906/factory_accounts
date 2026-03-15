<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/core_users/controllers/Core_change_password.php";
class Change_password extends Core_change_password {
  public function __construct() {
    parent::__construct();
    $this->load->helper('core_users/core_change_password');
  }
  public function index(){
  	parent::create();
  }
}