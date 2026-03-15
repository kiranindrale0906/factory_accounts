<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/transactions/controllers/Metal_issue_vouchers.php';

class Api_metal_issue_vouchers extends Metal_issue_vouchers {
  public function __construct() {
    parent::__construct();
  }
}