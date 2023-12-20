<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/transactions/controllers/Metal_receipt_vouchers.php';

class Api_metal_receipt_vouchers extends Metal_receipt_vouchers {
  public function __construct() {
    parent::__construct();
  }
public function store(){
pd($_POST);
}
}
