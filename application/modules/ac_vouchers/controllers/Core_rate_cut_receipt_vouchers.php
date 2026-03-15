<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/controllers/Vouchers.php";

class Core_rate_cut_receipt_vouchers extends Vouchers {
  
  public function __construct() {
    $this->load_helper = FALSE;
    parent::__construct();
    $this->date_fields = array(array('rate_cut_receipt_vouchers', 'voucher_date'));
    $this->load->model(array('masters/department_category_model', 'masters/purity_model', 'masters/setting_model'));

    $this->load->helper('ac_vouchers/ac_vouchers');
    if (file_exists(APPPATH . "modules/".CLIENT_NAME."/helpers/client_rate_cut_receipt_vouchers.php"))
      $this->load->helper(CLIENT_NAME.'/client_rate_receipt_vouchers');
    $this->load->helper('ac_vouchers/core_rate_cut_receipt_vouchers');
  }
}