<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Metal_registers extends BaseController {  
  public function __construct(){
    parent::__construct();
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/metal_registers/index',$this->data); 
  } 

  
  private function calculation_data() {

    $this->start_date = (!empty($_GET['metal_registers']['start_date'])) ? date('Y-m-d',strtotime($_GET['metal_registers']['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['metal_registers']['end_date'])) ? date('Y-m-d',strtotime($_GET['metal_registers']['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    if (!empty($_GET['metal_registers']['account_name'])) {
      $this->data['account_name'] = $_GET['metal_registers']['account_name'];
    }
    $param = $this->data;
    $this->data['purities'] = $this->get_purity();
    $this->get_metal_register_data($this->data['purities'],$param);
  }

  private function get_purity() {
    $purity_list = array();
    $where['where']='(suffix="MI" OR suffix="MR")';
    $where['company_id']=$this->session->userdata('company_id');
    $metal_purities = $this->metal_register_model->get('distinct(purity) purity' , $where , array(),
                                                      array('order_by'=>'purity desc'));
    return $metal_purities;
  }

  private function get_metal_register_data($all_purities,$param) {
    if(empty($param['start_date'])) return false;
    $opening_param['end_date'] = date('Y-m-d', strtotime('-1 day', strtotime($param['start_date'])));
    $opening_param['start_date'] = date('1990-04-01');

    $where['where']='(suffix="MI" OR suffix="MR")';
    $where['company_id'] = $this->session->userdata('company_id');
    $where['date(created_at) >='] = date('Y-m-d', strtotime($param['start_date']));  
    $where['date(created_at) <='] = date('Y-m-d', strtotime($param['end_date'])); 
    if(!empty($param['account_name'])) {
      $where['account_name'] = $param['account_name']; 
    }
    $this->data['metal_register'] = $this->metal_register_model->get('*', $where, array(),
                                                                     array('order_by'=>'date(created_at) asc'));
    $where['date(created_at) <'] = date('Y-m-d', strtotime($param['start_date'])); 
    unset($where['date(created_at) <=']);
    unset($where['date(created_at) >=']);
    $this->data['opening_balance'] = $this->metal_register_model->find('sum(credit_weight)-sum(debit_weight) as opening_balance', 
                                                                       $where, array(),
                                                                       array('order_by'=>'date(created_at) asc'));
    //lq();
    //pd($this->data['opening_balance']);
    //lq();
  }
}
