<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/transactions/controllers/Cash_receipt_vouchers.php';

class Api_cash_receipt_vouchers extends Cash_receipt_vouchers {
  public function __construct() {
    parent::__construct();
  }
}