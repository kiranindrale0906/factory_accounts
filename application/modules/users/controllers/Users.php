<?php
require_once APPPATH . "modules/core_users/controllers/Core_users.php";
class Users extends Core_users {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'index'; 
    $this->load->helper('core_users/core_users');
  }
}
