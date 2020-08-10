<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/models/Core_cash_issue_voucher_model.php";
class Client_cash_issue_voucher_model extends Core_cash_issue_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('argold/client_cash_receipt_voucher_model', 'masters/narration_model'));
  }
  
  public function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    $rules[] = $this->get_account_validation_rules();
    $rules[] = $this->get_credit_amount_validation_rules();
    
    return $rules;
  }

  

  public function after_validate() {
    $this->attributes['fine']=$this->attributes['credit_weight']*$this->attributes['purity']/100;
  }
}

//class