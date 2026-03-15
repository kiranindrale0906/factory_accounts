<?php
require_once APPPATH . "modules/core_users/controllers/Core_user_activities.php";
class User_activities extends Core_user_activities {
  public function __construct() {
    parent::__construct();
    $this->load->helper('core_users/core_user_activities');
  }
}
