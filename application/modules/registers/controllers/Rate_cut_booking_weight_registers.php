<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rate_cut_booking_weight_registers extends BaseController {  
  public function __construct(){
    parent::__construct();
    $this->load->model(array('reports/rate_cut_booking_weight_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/rate_cut_booking_weight_registers/index',$this->data); 
  } 

  private function calculation_data() {

    $this->start_date = (!empty($_GET['rate_cut_booking_weight_registers']['start_date'])) ? date('Y-m-d',strtotime($_GET['rate_cut_booking_weight_registers']['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['rate_cut_booking_weight_registers']['end_date'])) ? date('Y-m-d',strtotime($_GET['rate_cut_booking_weight_registers']['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['rate_cut_booking_weight_registers']['start_date'])) {
            $where['date(created_at)>='] = $this->start_date;
    }
    
    if (!empty($_GET['rate_cut_booking_weight_registers']['end_date'])) {
        $where['date(created_at)<='] = $this->end_date;
    }
        
    if (!empty($_GET['rate_cut_booking_weight_registers']['account_name'])) {
        $where['account_name']= $_GET['rate_cut_booking_weight_registers']['account_name'];
        $this->data['account_name'] = $_GET['rate_cut_booking_weight_registers']['account_name'];
    }

    $where['where']='(suffix="RCBWIV" or suffix="RCBWRV")';
    $where['company_id']=$this->session->userdata('company_id');


    $this->data['rate_cut_booking_weight_registers'] = $this->voucher_model->get('',$where);
  }
}
