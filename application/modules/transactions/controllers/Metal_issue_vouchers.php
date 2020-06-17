<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Metal_issue_voucher_clients.php";
class Metal_issue_vouchers extends Metal_issue_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('metal_issue_vouchers', 'voucher_date'));
    $this->load->model(array('masters/department_category_model','masters/purity_model','masters/setting_model'));
  }
}
