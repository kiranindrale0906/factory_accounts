<?php
require_once APPPATH . "modules/core_users/controllers/Core_user_mobile_verify.php";
class User_mobile_verify extends Core_user_mobile_verify {
  public function __construct() {
    parent::__construct();
    $this->load->helper('core_users/core_user_mobile_verify');
  }
}