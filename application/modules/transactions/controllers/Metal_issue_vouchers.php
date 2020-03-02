<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "modules/ac_vouchers/controllers/Vouchers.php";
class Metal_issue_vouchers extends Vouchers {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('metal_issue_vouchers', 'voucher_date'));
  }
}
