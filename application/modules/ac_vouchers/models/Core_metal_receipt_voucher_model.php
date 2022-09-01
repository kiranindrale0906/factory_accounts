<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_metal_receipt_voucher_model extends Voucher_model {

  protected $prefix = 'MR';
  protected $voucher_type = 'metal receipt voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true; 

  public $router_class = "metal_receipt_vouchers";
  
  function __construct($data=array()) {
    parent::__construct($data);
  }

  function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    $rules[] = $this->get_purity_validation_rules();
    if (!in_array($this->attributes['receipt_type'], array('Alloy Vodator', 'GPC Vodator', 'Stone Vatav', 'Meena Vatav', 'Copper Vatav', 'Rhodium Vatav', 'HCL Loss', 'Tounch Loss Fine', 'AR Gold Loss Out', 'ARF Loss Out', 'ARC Loss Out', 'Ghiss Melting Loss', 'Castic Loss')))
      $rule[] = $this->get_debit_weight_validation_rules();
    return $rules;
  }
}