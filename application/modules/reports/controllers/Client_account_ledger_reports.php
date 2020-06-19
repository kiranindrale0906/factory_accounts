<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Client_ledgers.php";
class Client_account_ledger_reports extends Client_ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model'));
  }

  public function index() {
    $this->data['layout']='application';
    $this->get_form_data();
    $this->get_account_ledger_records();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function get_form_data() {
    $this->data['record']['company_id']=!empty($_GET['company_id'])?$_GET['company_id']:"";
    $this->data['account_names'] = $this->model->get('distinct(account_name) as name',
                          array('where_in' => array('voucher_type' => array("'metal issue voucher'", 
                                                                            "'metal receipt voucher'"))),
                          array(), array('order_by'=>'account_name asc'));
    $company_names = $this->company_model->get('name,id');
    if(!empty($company_names)){
    $this->data['company_names'] =array_merge(array(array('id'=>'All','name'=>'All')),$company_names);
    }
  }

  private function get_account_ledger_records() {
    $issue_data=array();
    $receipt_data=array();
    $where=array();
    $this->data['voucher_dates']=array();
    if(!empty($this->data['record']['company_id'])){
      $where['company_id']=$this->data['record']['company_id'];
    }
    // $company_id='';
    // if(!empty($_SESSION['company_id'])) $company_id = $_SESSION['company_id'];
    if(empty($this->data['account_names'])) return true;

    $select = "account_name`, IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*purity)/100),0) as fine,IFNULL((sum(debit_weight*factory_purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as factory_fine, IFNULL(sum(debit_weight),0) - IFNULL(sum(credit_weight),0) as receipt_weight, IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((purity-factory_purity)*credit_weight/100),0) as different";
    $this->data['trial_balance'] = $this->model->get($select,$where, array() , 
                                                      array('group_by'=>'account_name,',
                                                            'order_by'=>'account_name asc'));

  }      
}
