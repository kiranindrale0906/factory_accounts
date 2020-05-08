<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Rate_cut_booking_weight_issue_voucher_client_model extends Voucher_model {
  protected $prefix = 'RCBWIV';
  protected $voucher_type = 'rate cut booking weight issue voucher';
  protected $account_type = 'account';
  function __construct($data=array()) {
    parent::__construct($data);
  }
}
