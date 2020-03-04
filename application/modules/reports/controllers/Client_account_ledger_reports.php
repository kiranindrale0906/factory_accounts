<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client_account_ledger_reports extends BaseController {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['layout']='application';
    $this->get_account_ledger_records();
    
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_account_ledger_records(){
    $get_account=$this->account_model->get('id,name');
    $client_account_ledger=array();
    foreach ($get_account as $key => $account) {
      $account_ledger_data=$this->model->get('date_format(voucher_date,"%d-%m-%Y") as voucher_date,
                                              voucher_type,voucher_number,credit_amount,debit_amount,credit_weight,debit_weight,purity_margin',
                                             array('account_id'=>$account['id']), array() ,
                                             array('order_by'=>'voucher_date asc'));
      $client_account_ledger[$account['name']]=$account_ledger_data;
    }
    $this->data['client_account_ledger'] = $client_account_ledger;
  }
}
