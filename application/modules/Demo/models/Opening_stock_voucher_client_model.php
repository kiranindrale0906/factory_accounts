<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Opening_stock_voucher_client_model extends Voucher_model {
  protected $prefix = 'OSV';
  protected $voucher_type = 'opening stock voucher';
  protected $account_type = 'account';
  function __construct($data=array()) {
    parent::__construct($data);
  }
}
