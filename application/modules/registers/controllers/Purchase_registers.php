<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_registers extends BaseController {  
  public function __construct(){
    $this->_model='Purchase_register_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('reports/purchase_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/purchase_registers/index',$this->data); 
  } 

  private function calculation_data() {
    $this->start_date = (!empty($_GET['purchase_registers']['start_date'])) ? date('Y-m-d',strtotime($_GET['purchase_registers']['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['purchase_registers']['end_date'])) ? date('Y-m-d',strtotime($_GET['purchase_registers']['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['purchase_registers']['start_date'])) {
      $where['date(created_at)>='] = $this->start_date;
    }
    
    if (!empty($_GET['purchase_registers']['end_date'])) {
        $where['date(created_at)<='] = $this->end_date;
    }

    if (!empty($_GET['purchase_registers']['account_name'])) {
      $where['account_name']= $_GET['purchase_registers']['account_name'];
      $this->data['account_name'] = $_GET['purchase_registers']['account_name'];
    }
  
    $where['voucher_type']="purchase voucher";
    $where['company_id']=$this->session->userdata('company_id');
    $this->data['purchase_registers'] = $this->voucher_model->get('',$where);
  }
}
