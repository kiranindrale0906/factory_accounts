<?php
require_once APPPATH . "modules/core_users/models/Core_users_user_role_model.php";
class Users_user_role_model extends Core_users_user_role_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}
