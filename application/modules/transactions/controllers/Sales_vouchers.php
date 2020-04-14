<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Sales_voucher_clients.php";
class Sales_vouchers extends Sales_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('sales_vouchers', 'voucher_date'));
  }
}
