<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Trial_balances extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model'));
  }

  public function index() {
    //$this->metal_receipt_voucher_model->delete_vodator_records(date('Y-m-d'));
    //$this->metal_issue_voucher_model->delete_vodator_records(date('Y-m-d'));

    $update_vadotar = isset($_GET['update_vadotar']) ? TRUE : FALSE;

    if ($update_vadotar) {
      $incorrect_vadotar_vouchers = $this->voucher_model->get('receipt_type, site_name, voucher_date, sum(credit_weight) as credit_weight, sum(debit_weight) as debit_weight',
                                           array('receipt_type' => array('Alloy Vodator', 'GPC Vodator', 'Stone Vatav')),
                                           array(), array('group_by' => 'receipt_type, site_name, voucher_date',
                                                          'having' => 'credit_weight != debit_weight'));
      foreach($incorrect_vadotar_vouchers as $incorrect_vadotar_voucher) {
        $this->voucher_model->delete('', array('receipt_type' => $incorrect_vadotar_voucher['receipt_type'],
                                               'site_name' => $incorrect_vadotar_voucher['site_name'],
                                               'voucher_date' => $incorrect_vadotar_voucher['voucher_date']));
        $this->ledger_model->delete('', array('parent_id not in (select id from ac_vouchers)' => NULL));
      }

//      $url = API_ARG_NOV2020_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
//      $records = json_decode(curl_post_request($url));
//      if (!empty($records)) {
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'AR Gold', 'Nov 2020');
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'AR Gold', 'Nov 2020');
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'AR Gold', 'Nov 2020');
//      }

//      $url = API_ARF_NOV2020_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
//      $records = json_decode(curl_post_request($url));
//      if (!empty($records)) {
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'ARF', 'Nov 2020');
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'ARF', 'Nov 2020');
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'ARF', 'Nov 2020');
//      }

//      $url = API_ARC_NOV2020_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
//      $records = json_decode(curl_post_request($url));
//      if (!empty($records)) {
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'ARC', 'Nov 2020');
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'ARC', 'Nov 2020');
//        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'ARC', 'Nov 2020');
//      }

      $url = API_ARG_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      $records = json_decode(curl_post_request($url));
      if (!empty($records)) {
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', 'AR Gold', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator', 'AR Gold', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav', 'AR Gold', 'Jan 2021');
      }

      $url = API_ARF_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      $records = json_decode(curl_post_request($url));
      if (!empty($records)) {
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'ARF', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'ARF', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'ARF', 'Jan 2021');
      }

      $url = API_ARC_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      $records = json_decode(curl_post_request($url));
      if (!empty($records)) {
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', 'ARC', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator', 'ARC', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav', 'ARC', 'Jan 2021');
      }
    }

    $this->data['layout']='application';

    $this->data['account_names'] = $this->model->get('distinct(account_name) as name', array(), array(), array('order_by'=>'account_name asc'));

    $this->get_factory_balance();
    $this->get_account_ledger_records();
    $this->get_alloy_vodator_balance();
    $this->get_gpc_vodator_balance();
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_factory_balance() {
    // $url=API_ARG_NOV2020_PATH."issue_and_receipts/ledger_balance/index";
    // $arg_nov2020_records=json_decode(curl_post_request($url));
    
    // $url=API_ARF_NOV2020_PATH."issue_and_receipts/ledger_balance/index";
    // $arf_nov2020_records=json_decode(curl_post_request($url));
    
    // $url=API_ARC_NOV2020_PATH."issue_and_receipts/ledger_balance/index";
    // $arc_nov2020_records=json_decode(curl_post_request($url));

    $url=API_ARG_JAN2021_PATH."issue_and_receipts/ledger_balance/index";
    $arg_jan2021_records=json_decode(curl_post_request($url));
    
    $url=API_ARF_JAN2021_PATH."issue_and_receipts/ledger_balance/index";
    $arf_jan2021_records=json_decode(curl_post_request($url));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/ledger_balance/index";
    $arc_jan2021_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = '(sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance';
    // $this->data['accounts_argold_nov2020_balance'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Software Nov 2020'))['balance'];
    // $this->data['accounts_arf_nov2020_balance']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Software Nov 2020'))['balance'];
    // $this->data['accounts_arc_nov2020_balance']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Software Nov 2020'))['balance'];
    
    $this->data['accounts_argold_jan2021_balance'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Software Jan 2021'))['balance'];
    $this->data['accounts_arf_jan2021_balance']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Software Jan 2021'))['balance'];
    $this->data['accounts_arc_jan2021_balance']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Software Jan 2021'))['balance'];
    // $this->data['live_argold_nov2020_balance'] = $arg_nov2020_records->data->record->argold;
    // $this->data['live_arf_nov2020_balance']    = $arf_nov2020_records->data->record->argold;
    // $this->data['live_arc_nov2020_balance']    = $arc_nov2020_records->data->record->argold;

    $this->data['live_argold_jan2021_balance'] = @$arg_jan2021_records->data->record->argold;
    $this->data['live_arf_jan2021_balance']    = @$arf_jan2021_records->data->record->argold;
    $this->data['live_arc_jan2021_balance']    = @$arc_jan2021_records->data->record->argold;
  }
  private function get_alloy_vodator_balance() {
    
    $url=API_ARG_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arg_jan2021_records=json_decode(curl_post_request($url));
    // pd($arg_jan2021_records);
    
    $url=API_ARF_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arf_jan2021_records=json_decode(curl_post_request($url));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arc_jan2021_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = 'sum(credit_weight) as balance';
     
     $this->data['accounts_argold_jan2021_alloy_vodator'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 Alloy Vodator'))['balance'];
     $this->data['accounts_arf_jan2021_alloy_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Alloy Vodator'))['balance'];
     $this->data['accounts_arc_jan2021_alloy_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Alloy Vodator'))['balance'];
    $this->data['live_argold_jan2021_alloy_vodator'] =!empty($arg_jan2021_records->data->alloy_vodator[0])? $arg_jan2021_records->data->alloy_vodator[0]->weight:0;
    $this->data['live_arf_jan2021_alloy_vodator']    = !empty($arf_jan2021_records->data->alloy_vodator[0])?$arf_jan2021_records->data->alloy_vodator[0]->weight:0;
    $this->data['live_arc_jan2021_alloy_vodator']    = !empty($arc_jan2021_records->data->alloy_vodator[0])?$arc_jan2021_records->data->alloy_vodator[0]->weight:0;
  } 

  private function get_gpc_vodator_balance() {
    
    $url=API_ARG_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arg_jan2021_records=json_decode(curl_post_request($url));
    // pd($arg_jan2021_records);
    
    $url=API_ARF_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arf_jan2021_records=json_decode(curl_post_request($url));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arc_jan2021_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = 'sum(credit_weight) as balance';
     
     $this->data['accounts_argold_jan2021_gpc_vodator'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 GPC Vodator'))['balance'];
     $this->data['accounts_arf_jan2021_gpc_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 GPC Vodator'))['balance'];
     $this->data['accounts_arc_jan2021_gpc_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 GPC Vodator'))['balance'];
    
    
    $this->data['live_argold_jan2021_gpc_vodator'] =!empty($arg_jan2021_records->data->gpc_vodator[0])? $arg_jan2021_records->data->gpc_vodator[0]->weight:0;
    $this->data['live_arf_jan2021_gpc_vodator']    = !empty($arf_jan2021_records->data->gpc_vodator[0])? $arf_jan2021_records->data->gpc_vodator[0]->weight:0;
    $this->data['live_arc_jan2021_gpc_vodator']    = !empty($arc_jan2021_records->data->gpc_vodator[0])? $arc_jan2021_records->data->alloy_vodator[0]->weight:0;
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
    $loss_account = array('account_name' => 'LOSS ACCOUNT',
                          'fine' => 0, 'vadotar' => 0, 'amount' => 0);
    $this->data['loss_account_records'] = array();
    $loss_account_names = array('AR Gold Nov 2020 Alloy Vodator', 'ARF Nov 2020 Alloy Vodator', 'ARC Nov 2020 Alloy Vodator',
                          'AR Gold Nov 2020 GPC Vodator', 'ARF Nov 2020 GPC Vodator', 'ARC Nov 2020 GPC Vodator',
                          'AR Gold Nov 2020 Stone Vatav', 'ARF Nov 2020 Stone Vatav', 'ARC Nov 2020 Stone Vatav',
                          'AR Gold Jan 2021 Alloy Vodator', 'ARF Jan 2021 Alloy Vodator', 'ARC Jan 2021 Alloy Vodator',
                          'AR Gold Jan 2021 GPC Vodator', 'ARF Jan 2021 GPC Vodator', 'ARC Jan 2021 GPC Vodator',
                          'AR Gold Jan 2021 Stone Vatav', 'ARF Jan 2021 Stone Vatav', 'ARC Jan 2021 Stone Vatav',
                          'HCL Loss', 'STONE VATAV ARF', 'TOUNCH LOSS FINE ARF', 
                          'Loss Account', 'Tounch & Castic Dep.Loss', 'Tounch Loss Fine',
                          'MEENA LOSS ARF', 'GPC Powder', 'Gpc Powder ARF', 'SISMA GHISS LOSS',
                          'ARG Stone Loss', 'TOUNCH LOSS FINE ARC', 'PASSAGE SEPT', 'ARF GHISS LOSS',
                          'BUFFING LOSS', 'GRINDING LOSS',
                          'SHAMPOO AND STEEL VIBRATOR LOSS/WALNUT SHAMPO', 'ARG GHISS LOSS', 'GPC POWDER LOSS ARC');
    foreach($this->data['trial_balance'] as $index => $trail_balance_record) {
      if (in_array($trail_balance_record['account_name'], $loss_account_names)) {
        $loss_account['fine'] += $trail_balance_record['fine'];
        // $loss_account['vadotar'] += $trail_balance_record['vadotar'];
        // $loss_account['amount'] += $trail_balance_record['amount']; 
        $this->data['loss_account_records'][] = $trail_balance_record;
        unset($this->data['trial_balance'][$index]);
      }
    }
    $this->data['trial_balance'][] = $loss_account;
    
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
