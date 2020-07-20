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
    //$this->data['account_names'] = $this->model->get('distinct(account_name) as name', array(), array(), array('order_by'=>'account_name asc'));
    //if(empty($this->data['account_names'])) return true;
    $this->data['company_name'] = (!empty($_GET['company_name'])) ? $_GET['company_name'] : 'All';
    $this->data['period'] = (!empty($_GET['period'])) ? $_GET['period'] : 'date';
    $this->data['detail'] = (!empty($_GET['detail'])) ? $_GET['detail'] : 'yes';
    $this->data['report_type'] = (!empty($_GET['report_type'])) ? $_GET['report_type'] : 'vadotar';
    $this->get_datewise_ledger_records($this->data['period']);
    $this->get_companywise_vadotar();
  }

  private function get_companywise_vadotar() {
    $company_vadotars = $this->model->get('receipt_type, sum(factory_fine - fine) as vadotar', 
                                           array('receipt_type' => array("ARC Finished Goods", "ARF Finished Goods", "ARF Software Finished Goods",
                                                                         "ARC Refresh", "ARF Refresh")),
                                           array(), array('group_by' => 'receipt_type'));
    $this->data['total_vadotar'] = $this->model->find('sum(factory_fine - fine) as vodator');

    $this->data['company_vadotars'] = array('ARF' => 0, 'ARC' => 0);
    foreach ($company_vadotars as $company_vadotar) {
      if ($company_vadotar['receipt_type'] == 'ARF Finished Goods'
          || $company_vadotar['receipt_type'] == 'ARF Software Finished Goods'
          || $company_vadotar['receipt_type'] == 'ARF Refresh')
        $this->data['company_vadotars']['ARF'] += $company_vadotar['vadotar'];
      elseif ($company_vadotar['receipt_type'] == 'ARC Finished Goods'
              || $company_vadotar['receipt_type'] == 'ARC Referesh')
        $this->data['company_vadotars']['ARC'] += $company_vadotar['vadotar'];
    }
  }
}
