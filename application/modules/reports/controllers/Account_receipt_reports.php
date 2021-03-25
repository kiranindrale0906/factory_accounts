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
    $this->data['account_name'] = (!empty($_GET['account_name'])) ? $_GET['account_name'] : '';
    
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function _get_form_data() {

    $this->data['voucher_dates'] = array();
    $this->data['account_name'] = (!empty($_GET['account_name'])) ? $_GET['account_name'] : '';
    $where_receipt=array('(debit_weight != 0 or debit_amount != 0)'=>NULL,
                         'account_name not in ("MAIN VADOTAR","PURCHASE ACCOUNT","ARF Software Jan 2021","ARC Software Jan 2021","AR Gold Software Jan 2021")'=>NULL,
                         'purity>='=>98,
                         'purity<='=>100);
    $this->data['account_names'] = $this->ledger_model->get('account_name', $where_receipt);
    $this->data['account_names']=array_unique(array_column($this->data['account_names'], 'account_name'));
    $this->get_datewise_ledger_records();
  }
}
