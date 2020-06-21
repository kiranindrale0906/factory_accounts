<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/models/Metal_issue_voucher_client_model.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/models/Metal_issue_voucher_client_model.php";  
  class Metal_issue_voucher_model extends Metal_issue_voucher_client_model {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} else {
  
  require_once APPPATH . "modules/ac_vouchers/models/Metal_issue_voucher_core_model.php";  
  class Metal_issue_voucher_model extends Metal_issue_voucher_core_model {
    function __construct($data=array()) {
      parent::__construct($data);
    }
  } 

}
?>