<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Purchase_price_receipt_voucher_clients.php";
class Purchase_price_receipt_vouchers extends Purchase_price_receipt_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('purchase_price_receipt_vouchers', 'voucher_date'));
  }

  
}
