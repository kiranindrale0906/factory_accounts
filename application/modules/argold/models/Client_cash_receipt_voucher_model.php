<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/models/Core_cash_receipt_voucher_model.php";
class Client_cash_receipt_voucher_model extends Core_cash_receipt_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    $rules[] = $this->get_account_validation_rules();
    $rules[] = $this->get_debit_amount_validation_rules();
    return $rules;
  }
}