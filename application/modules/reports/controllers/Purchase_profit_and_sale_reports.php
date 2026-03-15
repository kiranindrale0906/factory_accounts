<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_profit_and_sale_reports extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('argold/chitti_model','masters/account_model','ac_vouchers/voucher_model'));
  }
  public function index() {
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function _get_form_data() {
  	$this->data['is_export']=(!empty($_GET['is_export']) && $_GET['is_export']==1)?1:0;
    $this->data['from_date']=!empty($_GET['from_date'])?$_GET['from_date']:'';
    $this->data['to_date']=!empty($_GET['to_date'])?$_GET['to_date']:'';
    $profit_loss_with_vadotar_records=$this->model->get_purchase_records($this->data);
    $this->data['profit_and_sale_records']=$profit_loss_with_vadotar_records;
  }
}
