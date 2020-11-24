<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_rate_cut_receipt_voucher_model extends Voucher_model {

  protected $prefix = 'RCRV';
  protected $voucher_type = 'rate cut receipt voucher';   //weight IN, amount OUT
  protected $account_type = 'account';
  
  public $router_class = "rate_cut_receipt_vouchers";
  
  function __construct($data=array()) {
    parent::__construct($data);
  }

  function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    $rules[] = $this->get_account_validation_rules();
    $rules[] = $this->get_gold_rate_validation_rules();
    $rules[] = $this->get_gold_rate_purity_validation_rules();
    $rules[] = $this->get_debit_weight_validation_rules();
    $rules[] = $this->get_purity_validation_rules();
    $rules[] = $this->get_credit_amount_validation_rules();
    return $rules;
  }

  function before_validate() {
    $this->attributes['receipt_type'] = '';
    $this->attributes['fine'] = $this->attributes['debit_weight'] * $this->attributes['purity'] / 100;
    $this->attributes['factory_purity'] = $this->attributes['purity'];
    $this->attributes['factory_fine'] = $this->attributes['fine'];
    //$this->set_credit_amount();
    parent::before_validate();
  }

  private function set_credit_amount() {
    if ($this->attributes['gold_rate_purity'] == 0) 
      $this->attributes['credit_amount'] = 0;
    else {
      $gold_rate = $this->attributes['gold_rate'] / $this->attributes['gold_rate_purity'] * 100;
      $this->attributes['credit_amount'] = $this->attributes['fine'] * $gold_rate;
    }
  }
}
