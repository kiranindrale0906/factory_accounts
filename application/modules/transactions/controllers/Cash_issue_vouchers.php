<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Cash_issue_voucher_clients.php";
class Cash_issue_vouchers extends Cash_issue_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('cash_issue_vouchers', 'voucher_date'));
  }

  
}
