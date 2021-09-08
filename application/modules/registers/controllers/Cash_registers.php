<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_registers extends BaseController {  
  public function __construct(){
    parent::__construct();
    $this->load->model(array('reports/cash_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/cash_registers/index',$this->data); 
  } 

  private function calculation_data() {
    $this->start_date = (!empty($_GET['cash_registers']['start_date'])) ? date('Y-m-d',strtotime($_GET['cash_registers']['start_date'])) : date('Y-m-d');

    $this->end_date = (!empty($_GET['cash_registers']['end_date'])) ? date('Y-m-d',strtotime($_GET['cash_registers']['end_date'])) : date('Y-m-d');
    $this->data['account_name'] = (!empty($_GET['cash_registers']['account_name'])) ? $_GET['cash_registers']['account_name'] : "";
    
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['cash_registers']['start_date'])) {
            $where['date(created_at)>='] = $this->start_date;
        }
        if (!empty($_GET['cash_registers']['end_date'])) {
            $where['date(created_at)<='] = $this->end_date;
        }
        if (!empty($_GET['cash_registers']['account_name'])) {
            $where['account_name']= $_GET['cash_registers']['account_name'];
        }

        //OR suffix="RCPPIV" OR suffix = "RCPPRV" OR suffix="RCPWIV" OR suffix = "RCPWRV
        $where['where']='(suffix="CI" OR suffix="CR")';
        $where['company_id']=$this->session->userdata('company_id');

    $this->data['cash_registers'] = $this->voucher_model->get('',$where);
    //lq();
    unset($where['created_at<=']);
    unset($where['created_at>=']);
    $where['created_at<'] = $this->start_date;
    $this->data['opening_balance'] = $this->voucher_model->find('sum(credit_amount)-sum(debit_amount) as opening_balance',$where);    
  }
}
