<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_cash_receipt_voucher_model extends Voucher_model {

  protected $prefix = 'CR';
  protected $voucher_type = 'cash receipt voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true; 

  public $router_class = "cash_receipt_vouchers";
  
  function __construct($data=array()) {
    parent::__construct($data);
  }

  function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    return $rules;
  }
}