<?php
require_once APPPATH . "modules/core_users/models/Core_user_mobile_verify_model.php";
class User_mobile_verify_model extends Core_user_mobile_verify_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}