<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Rate_cut_booking_weight_receipt_voucher_client_model extends Voucher_model {
  protected $prefix = 'RCBWRV';
  protected $voucher_type = 'rate cut booking weight receipt voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true;	
  function __construct($data=array()) {
    parent::__construct($data);
  }
}

//class