<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Bank_issue_voucher_model extends Voucher_model {
  protected $prefix = 'BI';
  protected $voucher_type = 'bank issue voucher';
  protected $account_type = 'account';
  public $router_class = "bank_issue_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }
}
