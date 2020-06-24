<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/models/Core_bank_issue_voucher_model.php";
class Client_bank_issue_voucher_model extends Core_bank_issue_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
  }
  
  public function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    return $rules;
  }

  public function after_validate() {
    $this->attributes['fine']=$this->attributes['credit_weight']*$this->attributes['purity']/100;
  }
}