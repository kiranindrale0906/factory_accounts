<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Summary_reports extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['report_type'] = (!empty($_GET['report_type'])) ? $_GET['report_type'] : 'Summary Report';
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function _get_form_data() {
    $this->data['voucher_dates'] = array();
    $select = "account_name, 
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount,
               IFNULL(sum(usd_debit_amount),0) - IFNULL(sum(usd_credit_amount),0) as usd_amount,0 as id";
    $this->data['trial_balance'] = $this->model->get($select,$where, array() , 
                                                      array('group_by'=>'account_name,',
                                                            'order_by'=>'account_name asc'));
    $this->data['loss_account_records'] = array();
    $loss_account_names =  $this->account_model->get('name', array('group_id' => 3));
    $loss_account_names = array_column($loss_account_names, 'name');
    
    foreach($this->data['trial_balance'] as $index => $trail_balance_record) {
        $account_data=$this->account_model->find('unrecoverable_account_name',array('name'=>$trail_balance_record['account_name']));
       $this->data['trial_balance'][$index]['unrecoverable_account_name']= !empty($account_data)?$account_data['unrecoverable_account_name']:'';
      if (in_array($trail_balance_record['account_name'], $loss_account_names)) {
        $loss_account['fine'] += $trail_balance_record['fine'];
        $account_data=$this->account_model->find('unrecoverable_account_name',array('name'=>$trail_balance_record['account_name']));
        $trail_balance_record['unrecoverable_account_name'] =$account_data['unrecoverable_account_name'] ;
        $this->data['loss_account_records'][] = $trail_balance_record;
        unset($this->data['trial_balance'][$index]);
      }
    }
    $this->data['trial_balance'][] = $loss_account;

    $this->get_datewise_ledger_records();
    $this->get_companywise_vadotar();
  }

  private function get_companywise_vadotar() {
    $this->data['company_vadotars'] = $this->model->get('site_name, sum(factory_fine - fine) as vadotar', array(), array(), array('group_by' => 'site_name'));
    $this->data['total_vadotar'] = $this->model->find('sum(factory_fine - fine) as vodator');

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
