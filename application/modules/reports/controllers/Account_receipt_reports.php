<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Account_receipt_reports extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['report_type'] = (!empty($_GET['report_type'])) ? $_GET['report_type'] : 'Account Receipt Report';
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function _get_form_data() {
    $this->data['voucher_dates'] = array();
    $this->get_datewise_ledger_records();
  }
}
