<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Bank_receipt_voucher_client_model.php";
class Bank_receipt_voucher_model extends Bank_receipt_voucher_client_model {
  public $router_class = "bank_receipt_vouchers";
  function __construct($data=array()) {
      parent::__construct($data);
  }
}

//class