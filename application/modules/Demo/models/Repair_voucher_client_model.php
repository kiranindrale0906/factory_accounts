<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Repair_voucher_client_model extends Voucher_model {
  protected $prefix = 'RV';
  protected $voucher_type = 'sales repair voucher';
  protected $account_type = 'account';
  function __construct($data=array()) {
    parent::__construct($data);
  }
}
