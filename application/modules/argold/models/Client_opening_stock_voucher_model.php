<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/models/Core_opening_stock_voucher_model.php";
class Client_opening_stock_voucher_model extends Core_opening_stock_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
  }

  function before_validate() {
    if (!isset($this->attributes['debit_weight']) || empty($this->attributes['debit_weight'])) $this->attributes['debit_weight']=0;
    if (!isset($this->attributes['credit_weight']) || empty($this->attributes['credit_weight'])) $this->attributes['credit_weight']=0;
    $this->attributes['purity'] = 100;
    if ($this->attributes['debit_weight'] > 0 && $this->attributes['credit_weight'] > 0)
      $this->attributes['credit_weight'] = 0;
    parent::before_validate();
  }

  public function before_save($action) {
    $this->attributes['fine'] = ($this->attributes['debit_weight'] + $this->attributes['credit_weight']) * $this->attributes['purity'] / 100;
    $this->attributes['factory_purity'] = $this->attributes['purity'];
    $this->attributes['factory_fine'] = $this->attributes['fine'];
    parent::before_save($action);
  }
}