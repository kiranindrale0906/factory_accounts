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
    $this->data['loss_date']=!empty($_GET['loss_date'])?$_GET['loss_date']:'';
    $update_vadotar = isset($_GET['update_vadotar']) ? TRUE : FALSE;
    $gold_rate_response = get_web_page("http://spngoldlivebroadcast.noip.us:8888/VOTSBroadcast/Services/xml/a/%20mumbai?_=1617860765592");
    $string = explode('GOLD MUMBAI 99.50 WITH GST & TCS RTGS', $gold_rate_response);
    $this->data['gold_rate'] = @explode(',', $string[1])[3];

    if ($update_vadotar) {
      $incorrect_vadotar_vouchers = $this->voucher_model->get('receipt_type, site_name, voucher_date, sum(credit_weight) as credit_weight, sum(debit_weight) as debit_weight',
                                           array('receipt_type' => array('Alloy Vodator', 'GPC Vodator', 'Stone Vatav')),
                                           array(), array('group_by' => 'receipt_type, site_name, voucher_date',
                                                          'having' => 'credit_weight != debit_weight'));
      foreach($incorrect_vadotar_vouchers as $incorrect_vadotar_voucher) {
        //if ($incorrect_vadotar_voucher['site_name']=='AR Gold Nov 2020') continue;
        //if ($incorrect_vadotar_voucher['site_name']=='ARC Nov 2020') continue;
        //if ($incorrect_vadotar_voucher['site_name']=='ARF Nov 2020') continue;
        $this->voucher_model->delete('', array('receipt_type' => $incorrect_vadotar_voucher['receipt_type'],
                                               'site_name' => $incorrect_vadotar_voucher['site_name'],
                                               'voucher_date' => $incorrect_vadotar_voucher['voucher_date']));
        $this->ledger_model->delete('', array('parent_id not in (select id from ac_vouchers)' => NULL));
      }

      $url = API_ARG_NOV2020_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      $records = json_decode(curl_post_request($url));
      if (!empty($records)) {
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'AR Gold', 'Nov 2020');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'AR Gold', 'Nov 2020');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'AR Gold', 'Nov 2020');
      }

      $url = API_ARF_NOV2020_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      $records = json_decode(curl_post_request($url));
      if (!empty($records)) {
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'ARF', 'Nov 2020');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'ARF', 'Nov 2020');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'ARF', 'Nov 2020');
      }

      $url = API_ARC_NOV2020_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      $records = json_decode(curl_post_request($url));
      if (!empty($records)) {
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator, 'Alloy Vodator', 'ARC', 'Nov 2020');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator, 'GPC Vodator', 'ARC', 'Nov 2020');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav, 'Stone Vatav', 'ARC', 'Nov 2020');
      }

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
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', 'ARF', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator', 'ARF', 'Jan 2021');
        $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav', 'ARF', 'Jan 2021');
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
    $this->get_stone_vatav_balance();
    $this->get_overall_rolling();
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
    
    $url=API_ARF_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arf_jan2021_records=json_decode(curl_post_request($url));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arc_jan2021_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = '(sum(debit_weight) - sum(credit_weight)) as balance,(sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance_fine';
     
     $this->data['accounts_argold_jan2021_alloy_vodator'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 Alloy Vodator'))['balance'];
     $this->data['accounts_arf_jan2021_alloy_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Alloy Vodator'))['balance'];
     $this->data['accounts_arc_jan2021_alloy_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 Alloy Vodator'))['balance'];

     $this->data['accounts_argold_jan2021_alloy_vodator_fine'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 Alloy Vodator'))['balance_fine'];
     $this->data['accounts_arf_jan2021_alloy_vodator_fine']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Alloy Vodator'))['balance_fine'];
     $this->data['accounts_arc_jan2021_alloy_vodator_fine']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 Alloy Vodator'))['balance_fine'];

    $this->data['live_argold_jan2021_alloy_vodator'] =!empty($arg_jan2021_records->data->alloy_vodator[0])? $arg_jan2021_records->data->alloy_vodator[0]->weight:0;
    $this->data['live_arf_jan2021_alloy_vodator']    = !empty($arf_jan2021_records->data->alloy_vodator[0])?$arf_jan2021_records->data->alloy_vodator[0]->weight:0;
    $this->data['live_arc_jan2021_alloy_vodator']    = !empty($arc_jan2021_records->data->alloy_vodator[0])?$arc_jan2021_records->data->alloy_vodator[0]->weight:0;

    $this->data['live_argold_jan2021_alloy_vodator_fine'] =!empty($arg_jan2021_records->data->alloy_vodator[0])? $arg_jan2021_records->data->alloy_vodator[0]->fine:0;
    $this->data['live_arf_jan2021_alloy_vodator_fine']    = !empty($arf_jan2021_records->data->alloy_vodator[0])?$arf_jan2021_records->data->alloy_vodator[0]->fine:0;
    $this->data['live_arc_jan2021_alloy_vodator_fine']    = !empty($arc_jan2021_records->data->alloy_vodator[0])?$arc_jan2021_records->data->alloy_vodator[0]->fine:0;
  } 

  private function get_gpc_vodator_balance() {
    
    $url=API_ARG_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arg_jan2021_records=json_decode(curl_post_request($url));
    // pd($arg_jan2021_records);
    
    $url=API_ARF_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arf_jan2021_records=json_decode(curl_post_request($url));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arc_jan2021_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = '(sum(debit_weight) - sum(credit_weight)) as balance,(sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance_fine';
     
     $this->data['accounts_argold_jan2021_gpc_vodator'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 GPC Vodator'))['balance'];
     $this->data['accounts_arf_jan2021_gpc_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 GPC Vodator'))['balance'];
     $this->data['accounts_arc_jan2021_gpc_vodator']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 GPC Vodator'))['balance'];
    $this->data['accounts_argold_jan2021_gpc_vodator_fine'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 GPC Vodator'))['balance_fine'];
     $this->data['accounts_arf_jan2021_gpc_vodator_fine']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 GPC Vodator'))['balance_fine'];
     $this->data['accounts_arc_jan2021_gpc_vodator_fine']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 GPC Vodator'))['balance_fine'];
    
    
    $this->data['live_argold_jan2021_gpc_vodator'] =!empty($arg_jan2021_records->data->gpc_vodator[0])? $arg_jan2021_records->data->gpc_vodator[0]->weight:0;
    $this->data['live_arf_jan2021_gpc_vodator']    = !empty($arf_jan2021_records->data->gpc_vodator[0])? $arf_jan2021_records->data->gpc_vodator[0]->weight:0;
    $this->data['live_arc_jan2021_gpc_vodator']    = !empty($arc_jan2021_records->data->gpc_vodator[0])? $arc_jan2021_records->data->gpc_vodator[0]->weight:0;

    $this->data['live_argold_jan2021_gpc_vodator_fine'] =!empty($arg_jan2021_records->data->gpc_vodator[0])? $arg_jan2021_records->data->gpc_vodator[0]->fine:0;
    $this->data['live_arf_jan2021_gpc_vodator_fine']    = !empty($arf_jan2021_records->data->gpc_vodator[0])? $arf_jan2021_records->data->gpc_vodator[0]->fine:0;
    $this->data['live_arc_jan2021_gpc_vodator_fine']    = !empty($arc_jan2021_records->data->gpc_vodator[0])? $arc_jan2021_records->data->gpc_vodator[0]->fine:0;
  }
  private function get_stone_vatav_balance() {
    
    $url=API_ARG_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arg_jan2021_records=json_decode(curl_post_request($url));
    // pd($arg_jan2021_records);
    
    $url=API_ARF_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arf_jan2021_records=json_decode(curl_post_request($url));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $arc_jan2021_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = '(sum(debit_weight) - sum(credit_weight)) as balance,(sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance_fine';
     
     $this->data['accounts_argold_jan2021_stone_vatav'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 Stone Vatav'))['balance'];
     $this->data['accounts_arf_jan2021_stone_vatav']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Stone Vatav'))['balance'];
     $this->data['accounts_arc_jan2021_stone_vatav']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 Stone Vatav'))['balance'];

     $this->data['accounts_argold_jan2021_stone_vatav_fine'] = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 Stone Vatav'))['balance_fine'];
     $this->data['accounts_arf_jan2021_stone_vatav_fine']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Stone Vatav'))['balance_fine'];
     $this->data['accounts_arc_jan2021_stone_vatav_fine']    = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 Stone Vatav'))['balance_fine'];
    
    
    $this->data['live_argold_jan2021_stone_vatav'] =!empty($arg_jan2021_records->data->stone_vatav[0])? $arg_jan2021_records->data->stone_vatav[0]->weight:0;
    $this->data['live_arf_jan2021_stone_vatav']    = !empty($arf_jan2021_records->data->stone_vatav[0])? $arf_jan2021_records->data->stone_vatav[0]->weight:0;
    $this->data['live_arc_jan2021_stone_vatav']    = !empty($arc_jan2021_records->data->stone_vatav[0])? $arc_jan2021_records->data->stone_vatav[0]->weight:0;

    $this->data['live_argold_jan2021_stone_vatav_fine'] =!empty($arg_jan2021_records->data->stone_vatav[0])? $arg_jan2021_records->data->stone_vatav[0]->fine:0;
    $this->data['live_arf_jan2021_stone_vatav_fine']    = !empty($arf_jan2021_records->data->stone_vatav[0])? $arf_jan2021_records->data->stone_vatav[0]->fine:0;
    $this->data['live_arc_jan2021_stone_vatav_fine']    = !empty($arc_jan2021_records->data->stone_vatav[0])? $arc_jan2021_records->data->stone_vatav[0]->fine:0;
  }

    private function get_overall_rolling() {
    
    $url=API_ARG_JAN2021_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arg_jan2021_rolling_records=json_decode(curl_post_request($url));
    
    $this->data['live_argold_jan2021_rolling_balance'] =!empty($arg_jan2021_rolling_records->data->balance)?$arg_jan2021_rolling_records->data->balance:0;
    $this->data['live_argold_jan2021_rolling_gpc_balance']=!empty($arg_jan2021_rolling_records->data->gpc_out_balance)? $arg_jan2021_rolling_records->data->gpc_out_balance:0;
    
    
    $url=API_ARF_JAN2021_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arf_jan2021_rolling_records=json_decode(curl_post_request($url));
    $this->data['live_arf_jan2021_rolling_balance'] =!empty($arf_jan2021_rolling_records->data->balance)? $arf_jan2021_rolling_records->data->balance:0;
    $this->data['live_arf_jan2021_rolling_gpc_balance']=!empty($arf_jan2021_rolling_records->data->gpc_out_balance)? $arf_jan2021_rolling_records->data->gpc_out_balance:0;
    
    $url=API_ARC_JAN2021_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arc_jan2021_rolling_records=json_decode(curl_post_request($url));
    $this->data['live_arc_jan2021_rolling_balance'] =!empty($arc_jan2021_rolling_records->data->balance)?$arc_jan2021_rolling_records->data->balance:0;
    $this->data['live_arc_jan2021_rolling_gpc_balance']=!empty($arc_jan2021_rolling_records->data->gpc_out_balance)? $arc_jan2021_rolling_records->data->gpc_out_balance:0;
  }
  
  private function get_account_ledger_records() {
    $this->data['voucher_dates']=array();
    if (empty($this->data['account_names'])) return true;
    
    $where=array();
    if(!empty($this->data['loss_date'])){
      $where['date(voucher_date) <=']=date('Y-m-d',strtotime($this->data['loss_date']));
    }

    $select = "account_name, 
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount,0 as id";
    $this->data['trial_balance'] = $this->model->get($select,$where, array() , 
                                                      array('group_by'=>'account_name,',
                                                            'order_by'=>'account_name asc'));

    $this->calculate_gst_of_purchase_accounts(1);
    $this->calculate_gst_of_purchase_accounts(0);
    $this->calculate_gst_of_sales_accounts();

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
        $this->data['loss_account_records'][] = $trail_balance_record;
        unset($this->data['trial_balance'][$index]);
      }
    }
    $this->data['trial_balance'][] = $loss_account;
  }      

  private function calculate_gst_of_purchase_accounts($export = 0) {
    $where_export = array();           

    $where_export['account_name'] = 'PURCHASE ACCOUNT';
    $where_export['is_export'] = $export;
    $data_key = ($export == 1) ? 'purchase_account_export' : 'purchase_account_domestic';
    
    $purchases = $this->model->get('debit_weight, credit_weight,
                             IFNULL((debit_amount),0) - IFNULL((credit_amount),0) as amount,
                             IFNULL(((debit_weight*purity)/100),0) - IFNULL(((credit_weight*factory_purity)/100),0) as amount_fine,
                             factory_fine, fine,
                             sale_type,
                             gold_rate_purity, gold_rate,
                             purity,
                             created_at', $where_export);

    $this->data[$data_key] = array('debit_weight' => 0, 'credit_weight' => 0,
                                   'fine' => 0,
                                   'amount' => 0, 'taxable_amount' => 0,
                                   'cgst_amount' => 0, 'sgst_amount' => 0, 'tcs_amount' => 0);

    foreach ($purchases as $index => $purchase) {
      $factory_fine = $purchase['factory_fine'];
      $fine         = $purchase['fine'];
      $sale_type    = $purchase['sale_type'];
      $gold_rate    = $purchase['gold_rate'];
      $gold_rate_purity = $purchase['gold_rate_purity'];
      $created_at   = $purchase['created_at'];

      $tax_fields = get_tax_fields($factory_fine, $fine, $sale_type, $gold_rate, $gold_rate_purity, $created_at);

      $this->data[$data_key]['debit_weight'] += $purchase['debit_weight'];
      $this->data[$data_key]['credit_weight'] += $purchase['credit_weight'];
      $this->data[$data_key]['fine'] += $purchase['amount_fine'];
      $this->data[$data_key]['amount'] += $purchase['amount'];
      $this->data[$data_key]['taxable_amount'] += $tax_fields['taxable_amount'];
      $this->data[$data_key]['cgst_amount'] += $tax_fields['cgst_amount'];
      $this->data[$data_key]['sgst_amount'] += $tax_fields['sgst_amount'];
      $this->data[$data_key]['tcs_amount'] += $tax_fields['tcs_amount'];
    }
  }

  private function calculate_gst_of_sales_accounts($where){               
    $where['ac_vouchers.account_name']='SALES ACCOUNT';
    $sales_accounts = $this->model->get('ac_vouchers.debit_weight as debit_weight,
                                         ac_vouchers.credit_weight as credit_weight,
                                         IFNULL((ac_vouchers.debit_amount),0) - IFNULL((ac_vouchers.credit_amount),0) as amount,
                                         IFNULL(((ac_vouchers.debit_weight*ac_vouchers.purity)/100),0) - IFNULL(((ac_vouchers.credit_weight*ac_vouchers.factory_purity)/100),0) as amount_fine,
                                         ac_vouchers.factory_fine as factory_fine,
                                         ac_vouchers.fine as fine,ac_vouchers.sale_type as sale_type,
                                         ac_vouchers.gold_rate_purity as gold_rate_purity,
                                         ac_vouchers.gold_rate as gold_rate,
                                         ac_vouchers.chitti_id as chitti_id,
                                         ac_vouchers.purity as purity,
                                         ac_vouchers.created_at as created_at,
                                         chitties.taxable_amount as taxable_amount,
                                         chitties.sgst_amount as sgst_amount,
                                         chitties.cgst_amount as cgst_amount,
                                         ',$where,array(array('chitties',  'ac_vouchers.chitti_id=chitties.id')));
    $total_taxable_export=$total_credit_weight_export=$total_debit_weight_export=$cgst_amount_export=$sgst_amount_export=$tcs_amount_export=$fine=$total_fine=$amount=$total_amount=0;
    $sales=array();
    foreach ($sales_accounts as $index => $sales_account) {
      $fine=($sales_account['amount_fine']);
      $amount=($sales_account['amount']);
      $total_fine+=$fine;
      $total_amount+=$amount;
      $total_debit_weight_export+=$sales_account['debit_weight'];
      $total_credit_weight_export+=$sales_account['credit_weight'];
      $total_taxable_export+=$sales_account['taxable_amount'];
      $cgst_amount_export+=$sales_account['cgst_amount'];
      $sgst_amount_export+=$sales_account['sgst_amount'];
      $this->data['sales_accounts']['debit_weight']=$total_debit_weight_export;
      $this->data['sales_accounts']['credit_weight']=$total_credit_weight_export;
      $this->data['sales_accounts']['fine']=$total_fine;
      $this->data['sales_accounts']['amount']=$total_amount;
      $this->data['sales_accounts']['taxable_amount']=$total_taxable_export;
      $this->data['sales_accounts']['cgst_amount']=$cgst_amount_export;
      $this->data['sales_accounts']['sgst_amount']=$sgst_amount_export;
    }
  }
  
}
