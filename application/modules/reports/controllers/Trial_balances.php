<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Trial_balances extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model', 
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model'));
  }

  public function index() {
    $url = API_ARG_BASE_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";

    $this->metal_receipt_voucher_model->delete_vodator_records(date('Y-m-d'));
    $this->metal_issue_voucher_model->delete_vodator_records(date('Y-m-d'));
    $records = json_decode(curl_post_request($url));
    if (!empty($records)) {
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'AR Gold');
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'AR Gold');
    }

    $url = API_ARF_BASE_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $records = json_decode(curl_post_request($url));
    if (!empty($records)) {
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'ARF');
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'ARF');
    }

    $url = API_ARC_BASE_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $records = json_decode(curl_post_request($url));
    if (!empty($records)) {
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'ARC');
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'ARC');
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'ARC');
    }

    $this->data['layout']='application';

    $this->data['account_names'] = $this->model->get('distinct(account_name) as name', array(), array(), array('order_by'=>'account_name asc'));

    $this->get_factory_balance();
    $this->get_account_ledger_records();

    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_factory_balance() {
    $url=API_ARG_BASE_PATH."issue_and_receipts/ledger_balance/index";
    $arg_records=json_decode(curl_post_request($url));
    
    $url=API_ARF_BASE_PATH."issue_and_receipts/ledger_balance/index";
    $arf_records=json_decode(curl_post_request($url));
    
    $url=API_ARC_BASE_PATH."issue_and_receipts/ledger_balance/index";
    $arc_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = '(sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance';
    $this->data['accounts_argold_balance'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Software'))['balance'];
    $this->data['accounts_arf_balance']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Software'))['balance'];
    $this->data['accounts_arc_balance']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Software'))['balance'];
    
    $this->data['live_argold_balance'] = $arg_records->data->record->argold;
    $this->data['live_arf_balance']    = $arf_records->data->record->argold;
    $this->data['live_arc_balance']    = $arc_records->data->record->argold;
  }

  private function get_account_ledger_records() {
    $this->data['voucher_dates']=array();
    if(empty($this->data['account_names'])) return true;

  
    $select = "account_name, 
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount";
    $this->data['trial_balance'] = $this->model->get($select, array(), array() , 
                                                      array('group_by'=>'account_name,',
                                                            'order_by'=>'account_name asc'));
    
    // $query = $this->db->query("select account_name, sum(fine) as fine, sum(vadotar) as vadotar, sum(amount) as amount
    //           from (
    //             (select account_name, 
    //                     IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
    //                     IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
    //                     IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount from ac_vouchers group by account_name)
    //             UNION
    //               (select account_name, 
    //                       sum(credit_weight) as fine,
    //                       0 as vadotar,
    //                       -1 * sum(debit_amount) as amount from chitties group by account_name)) t
    //           group by account_name
    //           order by account_name");
    //$this->data['trial_balance'] = $query->result_array();

  }      
}
