<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Average_reports extends BaseController {  
  public function __construct(){
    parent::__construct();
    $this->load->model(array('reports/sales_register_model',
                             'ac_vouchers/voucher_model',
                             'argold/chitti_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('reports/average_reports/index',$this->data); 
  } 

  private function calculation_data() {
    $where['rate!=']=0;
    $this->data['sales_records'] = $this->chitti_model->get('',$where);
    $this->data['purchase_records'] = $this->voucher_model->get('', array('gold_rate !=' => 0), array(),array('order_by'=>'voucher_date'));
    pd($this->data['sales_records']);
  
  }
}
