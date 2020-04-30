<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_registers extends BaseController {  
  public function __construct(){
    $this->_model='Cash_register_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('reports/cash_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->start_date = (!empty($_GET['start_date'])) ? date('Y-m-d',strtotime($_GET['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['end_date'])) ? date('Y-m-d',strtotime($_GET['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['start_date'])) {
            $where['created_at>='] = $this->start_date;
        }
        if (!empty($_GET['end_date'])) {
            $where['created_at<'] = $this->end_date;
        }
        if (!empty($_GET['account_name'])) {
            $where['account_name'] = $_GET['account_name'];
        }
    
    if(isset($_GET['return']) && $_GET['return'] == 'json')
      echo json_encode($this->data);
    else
      $this->calculation_data();


    $this->load->render('registers/cash_registers/index',$this->data); 
  } 

  public function _get_form_data() {
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
            $where['created_at<'] = $this->end_date;
        }
        if (!empty($_GET['account_name'])) {
            $where['account_name']= $_GET['account_name'];
        }
        $where['where']='(suffix="CI" OR suffix="CR" OR suffix="RCPPIV" OR suffix = "RCPPRV" OR suffix="RCPWIV" OR suffix = "RCPWRV")';
        $where['company_id']=$this->session->userdata('company_id');


    $this->data['cash_registers'] = $this->voucher_model->get('',$where);
  }

  public function _after_save($formdata, $action){
  }


}
