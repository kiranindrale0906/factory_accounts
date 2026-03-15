<?php
require_once APPPATH . "modules/core_users/models/Core_reset_password_model.php";
class  Reset_password_model extends Core_reset_password_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}
