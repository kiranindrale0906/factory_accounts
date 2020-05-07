<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_registers extends BaseController {  
  public function __construct(){
    $this->_model='Expense_register_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('reports/expense_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/expense_registers/index',$this->data); 
  } 

  private function calculation_data() {

    $this->start_date = (!empty($_GET['start_date'])) ? date('Y-m-d',strtotime($_GET['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['end_date'])) ? date('Y-m-d',strtotime($_GET['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['start_date'])) {
            $where['created_at>='] = $this->start_date;
        }
        if (!empty($_GET['end_date'])) {
            $where['created_at<='] = $this->end_date;
        }
        $where['where']='(suffix="EV")';
        $where['company_id']=$this->session->userdata('company_id');


    $this->data['expense_registers'] = $this->voucher_model->get('',$where);
  }

}
