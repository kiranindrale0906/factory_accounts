<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_metal_issue_voucher_model extends Voucher_model {

  protected $prefix = 'MI';
  protected $voucher_type = 'metal issue voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true; 

  public $router_class = "metal_issue_vouchers";

  function __construct($data=array()) {
    parent::__construct($data);
  }

  function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    if (   $this->attributes['receipt_type'] != 'HCL Loss' 
        && $this->attributes['receipt_type'] != 'Tounch Loss Fine') 
      $rules[] = $this->get_purity_validation_rules();
    
    if (!in_array($this->attributes['receipt_type'], array('Alloy Vodator', 'GPC Vodator', 'Stone Vatav', 'Spring Vatav','Meena Vatav', 'Copper Vatav', 'Rhodium Vatav', 'HCL Loss', 'Tounch Loss Fine', 'AR Gold Loss Out', 'ARF Loss Out', 'ARC Loss Out', 'Ghiss Melting Loss', 'Castic Loss')))
      $rules[] = $this->get_credit_weight_validation_rules();
    if ($this->attributes['sale_type'] == 'Sale'){ 
      $rules[] = $this->get_gold_rate_validation_rules();
      $rules[] = $this->get_gold_rate_purity_validation_rules();
    }
    return $rules;
  }
}