<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Cash_issue_voucher_client_model extends Voucher_model {
  protected $prefix = 'CI';
  protected $voucher_type = 'cash issue voucher';
  protected $account_type = 'account';
  function __construct($data=array()) {
    parent::__construct($data);
  }
}

//class