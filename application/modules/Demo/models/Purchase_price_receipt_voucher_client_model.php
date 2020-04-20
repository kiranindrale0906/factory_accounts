<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Purchase_price_receipt_voucher_client_model extends Voucher_model {
  protected $prefix = 'RCPPRV';
  protected $voucher_type = 'rate cute purchase price receipt voucher';
  protected $account_type = 'account';
  function __construct($data=array()) {
    parent::__construct($data);
  }
}