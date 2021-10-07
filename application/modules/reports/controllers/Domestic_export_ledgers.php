<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Domestic_export_ledgers extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model', 'transactions/ledger_model'));
  }

  public function index() {

    if(!empty($_GET['report_type'])&&$_GET['report_type']=='export_purchase'){
    $this->data['report_type'] = 'Export Purchase Ledger';
    }elseif(!empty($_GET['report_type'])&&$_GET['report_type']=='export_sale'){
    $this->data['report_type'] = 'Export Sale Ledger';
    }elseif(!empty($_GET['report_type'])&&$_GET['report_type']=='domestic_purchase'){
    $this->data['report_type'] = 'Domestic Purchase Ledger';
    }else{
    $this->data['report_type'] = 'Domestic Sale Ledger';
    }
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
    $account_id = (!empty($_GET['domestic_export_ledgers']['account_id'])) ? $_GET['domestic_export_ledgers']['account_id'] : 0;
    $this->data['account_id'] = $account_id;
    $this->get_datewise_ledger_records();
  }
}
