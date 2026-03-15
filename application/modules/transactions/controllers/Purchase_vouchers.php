<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Purchase_voucher_clients.php";
class Purchase_vouchers extends Purchase_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('purchase_vouchers', 'voucher_date'));
    $this->load->model(array('masters/department_category_model','masters/purity_model','masters/setting_model'));
  }
}
