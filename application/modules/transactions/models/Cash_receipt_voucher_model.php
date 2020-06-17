<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Cash_receipt_voucher_client_model.php";
class Cash_receipt_voucher_model extends Cash_receipt_voucher_client_model {
  public $router_class = "cash_receipt_vouchers";
  function __construct($data=array()) {
      parent::__construct($data);
  }
}

//class