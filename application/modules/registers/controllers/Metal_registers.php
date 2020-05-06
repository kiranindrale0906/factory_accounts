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

    $this->start_date = (!empty($_GET['start_date'])) ? date('Y-m-d',strtotime($_GET['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['end_date'])) ? date('Y-m-d',strtotime($_GET['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
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
    foreach ($all_purities as $key => $purity) {
            $param['purity'] = $purity['purity'];
            $opening_param['purity'] = $purity['purity'];
            $metal_register = array();
            $pre_metal_register = array(); 
    
            $where['where']='(suffix="MI" OR suffix="MR")';
            $where['company_id'] = $this->session->userdata('company_id');
            $where['purity'] = abs($param['purity']);
            $where['voucher_date >='] = date('Y-m-d', strtotime($param['start_date']));  
            $where['voucher_date <='] = date('Y-m-d', strtotime($param['end_date']));  
            $metal_register = $this->metal_register_model->get('*', $where, array(),array('order_by'=>'voucher_date asc'));

            $where['voucher_date >='] = $opening_param['start_date'];  
            $where['voucher_date <'] = $opening_param['end_date'];
            $pre_metal_register = $this->metal_register_model->get('*', $where, array(),array('order_by'=>'voucher_date asc'));
            
           
            if (empty($metal_register)) {
                unset($all_purities[$key]);
                continue;
            }
            $total_opening_credit = $total_opening_debit = 0;
            $total_debit = $total_credit = 0;
            foreach ($metal_register as $cr) {
                $total_credit = $total_credit + $cr['credit_weight'];
                $total_debit = $total_debit + $cr['debit_weight'];
            }

            foreach ($pre_metal_register as $pcr) {
                $total_opening_credit = $total_opening_credit + $pcr['credit_weight'];
                $total_opening_debit = $total_opening_debit + $pcr['debit_weight'];
            }
            $all_purities[$key]['metal_register'] = $metal_register;

            $all_purities[$key]['total_debit'] = $total_debit;
            $all_purities[$key]['total_credit'] = $total_credit;
            $all_purities[$key]['total_opening_credit'] = $total_opening_credit;
            $all_purities[$key]['total_opening_debit'] = $total_opening_debit;
            $all_purities[$key]['balance'] = ($total_debit - $total_credit);
      }
      
      $this->data['all_purities'] = array_values($all_purities);
  }
}
