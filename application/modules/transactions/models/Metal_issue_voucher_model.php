<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/models/Client_metal_issue_voucher_model.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/models/Client_metal_issue_voucher_model.php";  
  class Metal_issue_voucher_model extends Client_metal_issue_voucher_model {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} else {
  
  require_once APPPATH . "modules/ac_vouchers/models/Core_metal_issue_voucher_model.php";  
  class Metal_issue_voucher_model extends Core_metal_issue_voucher_model {
    function __construct($data=array()) {
      parent::__construct($data);
    }
  } 

}
?>