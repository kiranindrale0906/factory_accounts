<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_opening_stock_voucher_model extends Voucher_model {

  protected $prefix = 'OSV';
  protected $voucher_type = 'opening stock voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true; 

  public $router_class = "opening_stock_vouchers";
  
  function __construct($data=array()) {
    parent::__construct($data);
    $this->formdata[$this->router_class]['voucher_type'] = $this->voucher_type;
  }
}