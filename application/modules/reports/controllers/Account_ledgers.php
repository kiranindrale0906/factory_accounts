<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Account_ledgers extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model', 'transactions/ledger_model'));
  }

  public function index() {
    $this->data['report_type'] = 'Account Ledger';
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function create() {
    ini_set('max_execution_time', '0');
    $this->ledger_model->regenerate_ledger_records();
  }

  public function _get_form_data() {
    $this->data['voucher_dates']=array();
    $this->data['account_names'] = $this->account_model->get('distinct(ac_account.name) as name, ac_account.id as id',
                                                              array('where' => array('ac_account.name!=""' => '')),
                                                              array(),
                                                              array('order_by' => 'ac_account.name asc'));
    $account_id = (!empty($_GET['account_ledgers']['account_id'])) ? $_GET['account_ledgers']['account_id'] : 0;
    $this->data['account_id'] = $account_id;  
    if ($this->data['account_id'] != 0)
      $this->get_datewise_ledger_records();
  }
}
