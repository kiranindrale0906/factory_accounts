<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Purchase_weight_issue_voucher_clients.php";
class Purchase_weight_issue_vouchers extends Purchase_weight_issue_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('purchase_weight_issue_vouchers', 'voucher_date'));
  }

  
}