<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rojmel_reports extends BaseController {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['layout']='application';
    $this->get_rojmel_reports();
    
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_rojmel_reports(){
    $rojmel_reports=array();
    $company_id='';
    if(!empty($_SESSION['company_id']))
      $company_id=$_SESSION['company_id'];
  
    $this->data['rojmel_reports'] = $this->model->get('date_format(voucher_date,"%d-%m-%Y") as
                                                      voucher_date,ac.name as account_name,voucher_type,voucher_number,credit_amount,debit_amount,credit_weight,debit_weight,purity_margin', 
                                                      array('voucher_type!=""'=>NULL,
                                                            'ac_vouchers.company_id'=>$company_id), 
                                                      array(
                                                        array('ac_account ac',
                                                              'ac.id=ac_vouchers.account_id')) ,
                                                      array('order_by'=>'voucher_date asc'));
  }
}
