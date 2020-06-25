<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Vadotar_reports extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function _get_form_data() {
    $this->data['voucher_dates']=array();
    $this->data['account_names'] = $this->model->get('distinct(account_name) as name', array(), array(), array('order_by'=>'account_name asc'));
    if(empty($this->data['account_names'])) return true;
    $this->get_datewise_ledger_records();
    $this->get_companywise_vadotar();
  }

  private function get_companywise_vadotar() {
    $this->data['company_vadotars'] = $this->model->get('receipt_type, sum(factory_fine - fine) as vadotar', 
                                               array('receipt_type' => array("ARC Finished Goods", "ARF Finished Goods"),
                                                     'voucher_type' => 'metal issue voucher'),
                                               array(), array('group_by' => 'receipt_type'));
    $this->data['total_vadotar'] = $this->model->find('sum(factory_fine - fine) as vodator');
  }
}
