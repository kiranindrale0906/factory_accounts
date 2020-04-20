<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Bank_receipt_voucher_clients.php";
class Bank_receipt_vouchers extends Bank_receipt_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('bank_receipt_vouchers', 'voucher_date'));
  }

  
}
