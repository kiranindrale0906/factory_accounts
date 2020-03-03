<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account_ledger_reports extends BaseController {

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
    $this->data['account_names'] = $this->account_model->get('ac_account.name as name,
                                                              ac_account.id as id',
                                                              array('where'=>array('ac_account.name!=""'=>'')),
                                                              array(array('ac_groups',
                                                                          'ac_account.group_code=ac_groups.name','')),
                                                              array('order_by'=>'ac_account.name asc'));
  }

  private function get_account_ledger_records(){
    
    $account_id=(!empty($_GET['account_ledger_reports']['account_id']))?$_GET['account_ledger_reports']['account_id']:'0';

    $date_from=(!empty($_GET['account_ledger_reports']['date_from']))?strtotime('Y-m-d',$_GET['account_ledger_reports']['date_from']):date('Y-m-d');

    $date_to=(!empty($_GET['account_ledger_reports']['date_to']))?strtotime('Y-m-d',$_GET['account_ledger_reports']['date_to']):date('Y-m-d');

    $this->data['account_ledger']=array();
    $this->data['record']['account_id'] = $account_id;
    $this->data['record']['date_from'] = (!empty($_GET['account_ledger_reports']['date_from']))?$_GET['account_ledger_reports']['date_from']:'';
    $this->data['record']['date_to'] = (!empty($_GET['account_ledger_reports']['date_to']))?$_GET['account_ledger_reports']['date_to']:'';

    if(!empty($account_id)) {
      $where['account_id']=$account_id;
      $where['voucher_date >='] = $date_from;
      $where['voucher_date <='] = $date_to;

      $this->data['account_ledger'] = $this->model->get('date_format(voucher_date,"%d-%m-%Y") as 
                                                        voucher_date,voucher_type,voucher_number,credit_amount,debit_amount,credit_weight,debit_weight',
                                                        $where);
      
    }
  }
}
