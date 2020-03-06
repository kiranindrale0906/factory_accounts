<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Metal_receipt_voucher_model extends Voucher_model {
  protected $prefix = 'MR';
  protected $voucher_type = 'metal receipt voucher';
  protected $account_type = 'account';
  public $router_class = "metal_receipt_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
      parent::__construct($data);
  }
  public function before_save($action) {
    $purity = $this->attributes['purity'];
    $factory_purity = $this->attributes['factory_purity'];
    $credit_weight = $this->attributes['debit_weight'];
    $purity_margin=$credit_weight*($purity-$factory_purity)/100;
    $this->formdata[$this->router_class]['purity_margin'] = $purity_margin;
    parent::before_save($action);
  }
}

//class