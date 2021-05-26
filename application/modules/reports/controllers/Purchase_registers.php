<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_registers extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','ac_vouchers/voucher_model'));
  }
  public function index() {
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function _get_form_data() {
  	$this->data['is_export']=(!empty($_GET['is_export']) && $_GET['is_export']==1)?1:0;
  	$this->data['purchase_register_records']=$this->voucher_model->get('', array('gold_rate !='=>0,'debit_amount  !='=>0,'is_export'=>$this->data['is_export'],'voucher_type !='=>'rate cut issue voucher'));
  }
}
