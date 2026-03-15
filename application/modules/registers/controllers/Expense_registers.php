<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_registers extends BaseController {  
  public function __construct(){
    parent::__construct();
    $this->load->model(array('reports/expense_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/expense_registers/index',$this->data); 
  } 

  private function calculation_data() {

    $this->start_date = (!empty($_GET['expense_registers']['start_date'])) ? date('Y-m-d',strtotime($_GET['expense_registers']['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['expense_registers']['end_date'])) ? date('Y-m-d',strtotime($_GET['expense_registers']['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['expense_registers']['start_date'])) {
            $where['date(created_at)>='] = $this->start_date;
    }

    if (!empty($_GET['expense_registers']['end_date'])) {
        $where['date(created_at)<='] = $this->end_date;
    }
    if (!empty($_GET['expense_registers']['account_name'])) {
      $where['account_name']= $_GET['expense_registers']['account_name'];
      $this->data['account_name'] = $_GET['expense_registers']['account_name'];
    }    
    
    $where['where']='(suffix="EV")';
    $where['company_id']=$this->session->userdata('company_id');

    $this->data['expense_registers'] = $this->voucher_model->get('',$where);
  }

}
