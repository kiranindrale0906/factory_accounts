<?php
require_once APPPATH . "modules/core_users/controllers/Core_user_roles.php";
class User_roles extends Core_user_roles {
  public function __construct($data=array()) {
    parent::__construct($data);
    $this->load->helper('core_users/core_user_roles');
  }
}