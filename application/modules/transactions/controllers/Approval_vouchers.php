<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Approval_voucher_clients.php";
class Approval_vouchers extends Approval_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('approval_vouchers', 'voucher_date'));
  }
}
