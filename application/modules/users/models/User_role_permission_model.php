<?php
require_once APPPATH . "modules/core_users/models/Core_user_role_permission_model.php";
class User_role_permission_model extends Core_user_role_permission_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}
