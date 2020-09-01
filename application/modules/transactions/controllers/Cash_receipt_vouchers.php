<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists(APPPATH . "modules/".CLIENT_NAME."/controllers/Client_cash_receipt_vouchers.php")) {

  require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Client_cash_receipt_vouchers.php";
  class Cash_receipt_vouchers extends Client_cash_receipt_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

} else {
  
  require_once APPPATH . "modules/ac_vouchers/controllers/Core_cash_receipt_vouchers.php";
  class Cash_receipt_vouchers extends Core_cash_receipt_vouchers {
    function __construct($data=array()) {
      parent::__construct($data);
    } 
  }

}
?>
