<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Interest_receipt_voucher_clients.php";
class Interest_receipt_vouchers extends Interest_receipt_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('interest_receipt_vouchers', 'voucher_date'));
    $this->load->model(array('masters/department_category_model','masters/purity_model','masters/setting_model'));
  }

  
}
