<?php
require_once APPPATH . "modules/core_users/models/Core_change_password_model.php";
class  Change_password_model extends Core_change_password_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}
