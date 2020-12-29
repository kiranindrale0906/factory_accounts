<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/models/Client_rate_cut_issue_voucher_model.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/models/Client_rate_cut_issue_voucher_model.php";  
  class Rate_cut_issue_voucher_model extends Client_rate_cut_issue_voucher_model {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} else {
  
  require_once APPPATH . "modules/ac_vouchers/models/Core_rate_cut_issue_voucher_model.php";  
  class Rate_cut_issue_voucher_model extends Core_rate_cut_issue_voucher_model {
    function __construct($data=array()) {
      parent::__construct($data);
    }
  } 

}
?>