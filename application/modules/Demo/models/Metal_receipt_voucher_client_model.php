<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Metal_receipt_voucher_client_model extends Voucher_model {
  protected $prefix = 'MR';
  protected $voucher_type = 'metal receipt voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true;	
  function __construct($data=array()) {
    parent::__construct($data);
  }
}

//class