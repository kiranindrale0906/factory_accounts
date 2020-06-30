<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Trial_balances extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model'));
  }

  public function index() {
    $this->data['layout']='application';
    $url=API_ARG_BASE_PATH."issue_and_receipts/ledger_balance/index";
    $arg_records=json_decode(curl_post_request($url));
    $url=API_LIVE_BASE_PATH."issue_and_receipts/ledger_balance/index";
    $records=json_decode(curl_post_request($url));
    $this->data['argold_balance']=$arg_records->data->record;
    $this->data['live_balance']=$records->data->record;
    $this->get_form_data();
    $this->get_account_ledger_records();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function get_form_data() {
    $this->data['account_names'] = $this->model->get('distinct(account_name) as name', array(), array(), array('order_by'=>'account_name asc'));
  }

  private function get_account_ledger_records() {
    $this->data['voucher_dates']=array();
    if(empty($this->data['account_names'])) return true;

    $select = "account_name, 
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar";
    $this->data['trial_balance'] = $this->model->get($select, array(), array() , 
                                                      array('group_by'=>'account_name,',
                                                            'order_by'=>'account_name asc'));
  }      
}
