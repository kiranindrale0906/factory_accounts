<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_registers extends BaseController {  
  public function __construct(){
    $this->_model='Bank_register_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('reports/bank_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/bank_registers/index',$this->data); 
  } 
  
  private function calculation_data() {

    $this->start_date = (!empty($_GET['bank_registers']['start_date'])) ? date('Y-m-d',strtotime($_GET['bank_registers']['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['bank_registers']['end_date'])) ? date('Y-m-d',strtotime($_GET['bank_registers']['end_date'])) : date('Y-m-d');
    $this->data['bank_name'] = (!empty($_GET['bank_registers']['bank_name'])) ? $_GET['bank_registers']['bank_name'] : "";
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['bank_registers']['start_date'])) {
            $where['created_at>='] = $this->start_date;
        }
        if (!empty($_GET['bank_registers']['end_date'])) {
            $where['created_at<='] = $this->end_date;
        }
        if (!empty($_GET['bank_registers']['bank_name'])) {
            $where['bank_name']= $_GET['bank_registers']['bank_name'];
        }
        //OR suffix="RCPPIV" OR suffix = "RCPPRV" OR suffix="RCPWIV" OR suffix = "RCPWRV"
        $where['where']='(suffix="BI" OR suffix="BR")';
        $where['company_id']=$this->session->userdata('company_id');


    $this->data['bank_registers'] = $this->voucher_model->get('',$where);
    //lq();
    //pd($this->data['bank_registers']);
    unset($where['created_at<=']);
    unset($where['created_at>=']);
    $where['created_at<'] = $this->start_date;
    $this->data['opening_balance'] = $this->voucher_model->find('sum(credit_amount)-sum(debit_amount) as opening_balance',$where);
  }
}
