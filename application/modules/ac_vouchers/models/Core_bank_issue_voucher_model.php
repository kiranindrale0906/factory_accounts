<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_bank_issue_voucher_model extends Voucher_model {

  protected $prefix = 'BI';
  protected $voucher_type = 'bank issue voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true; 

  public $router_class = "bank_issue_vouchers";

  function __construct($data=array()) {
    parent::__construct($data);
  }

  function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    // $rules[] = $this->get_purity_validation_rules();
    // $rules[] = $this->get_credit_weight_validation_rules();
    return $rules;
  }
}