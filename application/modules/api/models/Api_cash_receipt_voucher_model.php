<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/transactions/models/Cash_receipt_voucher_model.php";
class Api_cash_receipt_voucher_model extends Cash_receipt_voucher_model {
  function __construct($data=array()) {
    parent::__construct($data);
  }
}