<?php
require_once APPPATH . "modules/core_users/models/Core_register_model.php";
class  Register_model extends Core_register_model {
  //protected $load_trigger = true;
  public function __construct($data=array()) {
    parent::__construct($data);
    if(EMAIL_VERIFICATION || MOBILE_VERIFICATION){
    	$this->load_trigger = true;
    }
  }
}
