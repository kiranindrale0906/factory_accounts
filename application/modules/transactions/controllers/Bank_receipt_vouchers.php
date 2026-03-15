<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/controllers/Client_bank_receipt_vouchers.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Client_bank_receipt_vouchers.php";
  class Bank_receipt_vouchers extends Client_bank_receipt_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} else {
  
  require_once APPPATH . "modules/ac_vouchers/controllers/Core_bank_receipt_vouchers.php";
  class Bank_receipt_vouchers extends Core_bank_receipt_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

}
?>