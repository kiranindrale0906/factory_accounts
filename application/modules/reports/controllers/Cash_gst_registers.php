<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_gst_registers extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','ac_vouchers/voucher_model'));
  }
  public function index() {
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function _get_form_data() {
    $this->data['account_name']=(!empty($_GET['account_name']))?$_GET['account_name']:"PURCHASE ACCOUNT";
  	$this->data['cash_gst_register_records']=$this->voucher_model->get('', 
                                                                      array('voucher_type in ("cash receipt voucher","cash issue voucher")'=>NULL,
                                                                            'account_name' => $this->data['account_name']),
                                                                      array(),array('order_by'=>'id desc'));
    // lq();
  }
}
