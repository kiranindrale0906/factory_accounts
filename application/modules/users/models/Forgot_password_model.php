<?php
require_once APPPATH . "modules/core_users/models/Core_forgot_password_model.php";
class  Forgot_password_model extends Core_forgot_password_model {
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}
