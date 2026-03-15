<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/controllers/Vouchers.php";
class Core_opening_stock_vouchers extends Vouchers {

  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('opening_stock_vouchers', 'voucher_date'));
    $this->load->model(array('masters/department_category_model','masters/purity_model','masters/setting_model'));

    $this->load->helper('ac_vouchers/ac_vouchers');
    if (file_exists(APPPATH . "modules/".CLIENT_NAME."/helpers/client_opening_stock_vouchers_helper.php")) {
      $this->load->helper(CLIENT_NAME.'/client_opening_stock_vouchers');
    }
    $this->load->helper('ac_vouchers/core_opening_stock_vouchers');
  }

  public function _get_form_data() {
    $this->data['record']['voucher_date'] = '2025-04-01';
    parent::_get_form_data();
  }
}
