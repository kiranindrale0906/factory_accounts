<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Sales_return_voucher_clients.php";
class Sales_return_vouchers extends Sales_return_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('sales_return_vouchers', 'voucher_date'));
    $this->load->model(array('masters/cash_bill_model','masters/purity_model'));
   
  }
}
