<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/transactions/controllers/Cash_issue_vouchers.php';

class Api_cash_issue_vouchers extends Cash_issue_vouchers {
  public function __construct() {
    parent::__construct();
  }
}