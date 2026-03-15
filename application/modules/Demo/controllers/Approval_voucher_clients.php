<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/controllers/Vouchers.php";
class Approval_voucher_clients extends Vouchers {
  public function __construct() {
    parent::__construct();
  }
}
