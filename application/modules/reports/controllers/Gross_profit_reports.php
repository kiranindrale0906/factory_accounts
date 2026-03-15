<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Gross_profit_reports extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['report_type'] = (!empty($_GET['report_type'])) ? $_GET['report_type'] : 'Gross Profit Report';
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function _get_form_data() {
    $this->data['gross_profit_dates'] = array();
    $this->get_datewise_ledger_records();
    $this->get_companywise_gross_profit();
  }

  private function get_companywise_gross_profit() {
    $this->data['company_gross_profits'] = $this->model->get('site_name, sum(factory_fine - fine) as vadotar', 
                                                        array(), array(), array('group_by' => 'site_name'));
    $this->data['total_gross_profit'] = $this->model->find('sum(factory_fine - fine) as gross_profit');

    // $this->data['company_vadotars'] = array('ARF' => 0, 'ARC' => 0);
    // foreach ($company_vadotars as $company_vadotar) {
    //   if ($company_vadotar['receipt_type'] == 'ARF Finished Goods'
    //       || $company_vadotar['receipt_type'] == 'ARF Software Finished Goods'
    //       || $company_vadotar['receipt_type'] == 'ARF Refresh')
    //     $this->data['company_vadotars']['ARF'] += $company_vadotar['vadotar'];
    //   elseif ($company_vadotar['receipt_type'] == 'ARC Finished Goods'
    //           || $company_vadotar['receipt_type'] == 'ARC Referesh')
    //     $this->data['company_vadotars']['ARC'] += $company_vadotar['vadotar'];
    // }
  }
}
