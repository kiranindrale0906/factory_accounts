<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Client_ledgers.php";
class Client_account_ledger_reports extends Client_ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['layout']='application';
    $this->get_form_data();
    $this->get_account_ledger_records();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function get_form_data() {
    $this->data['account_names'] = $this->model->get('distinct(account_name) as name',
                          array('where_in' => array('voucher_type' => array("'metal issue voucher'", 
                                                                            "'metal receipt voucher'"))),
                          array(), array('order_by'=>'account_name asc'));
  }

  private function get_account_ledger_records() {
    $issue_data=array();
    $receipt_data=array();
    $this->data['voucher_dates']=array();

    $company_id='';
    if(!empty($_SESSION['company_id'])) $company_id = $_SESSION['company_id'];
    if(empty($this->data['account_names'])) return true;

    $select = "account_name`, (sum(debit_weight*purity)/100) - (sum(credit_weight*purity)/100) as fine, sum(debit_weight) -sum(credit_weight) as receipt_weight";
    $this->data['trial_balance'] = $this->model->get($select, array(), array() , 
                                                      array('group_by'=>'account_name',
                                                            'order_by'=>'account_name asc'));
  }      
}
