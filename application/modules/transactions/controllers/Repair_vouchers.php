<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Repair_voucher_clients.php";
class Repair_vouchers extends Repair_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('repair_vouchers', 'voucher_date'));
  }
}
