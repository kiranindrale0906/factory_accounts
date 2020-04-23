<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Interest_issue_voucher_clients.php";
class Interest_issue_vouchers extends Interest_issue_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('interest_issue_vouchers', 'voucher_date'));
  }

  
}