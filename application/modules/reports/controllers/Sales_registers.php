<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_registers extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }
  public function index() {
    $this->_get_form_data();
    // $this->get_loss_details();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function _get_form_data() {
  	$this->data['is_export']=(!empty($_GET['is_export']) && $_GET['is_export']==1)?1:0;
  	$this->data['sales_register_records']=$this->voucher_model->get('', array('gold_rate !='=>0, 
                                                                              'debit_amount !='=>0,
                                                                              'is_export'=>$this->data['is_export'],
                                                                              'account_name' => 'SALES ACCOUNT'),array(),
                                                                              array('order_by'=>'voucher_date desc'));
  
  }
}