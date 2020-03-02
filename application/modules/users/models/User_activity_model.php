<?php
require_once APPPATH . "modules/core_users/models/Core_user_activity_model.php";
class User_activity_model extends Core_user_activity_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}