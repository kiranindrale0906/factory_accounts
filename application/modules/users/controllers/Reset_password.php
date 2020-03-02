<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/core_users/controllers/Core_reset_password.php";
class Reset_password extends Core_reset_password {
  public function __construct() {
    parent::__construct();
    $this->load->helper('core_users/core_reset_password');
  }
}
?>  
