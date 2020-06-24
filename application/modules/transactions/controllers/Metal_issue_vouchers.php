<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/controllers/Client_metal_issue_vouchers.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Client_metal_issue_vouchers.php";
  class Metal_issue_vouchers extends Client_metal_issue_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} else {
  
  require_once APPPATH . "modules/ac_vouchers/controllers/Core_metal_issue_vouchers.php";
  class Metal_issue_vouchers extends Core_metal_issue_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

}
?>