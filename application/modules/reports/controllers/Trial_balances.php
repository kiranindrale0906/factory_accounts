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
    $this->data['loss_date']=!empty($_GET['loss_date'])?$_GET['loss_date']:'';

    $this->get_gold_rate_from_myspn();
    $this->update_alloy_gpc_stone_vadotar();

    $this->data['account_names'] = $this->model->get('distinct(account_name) as name', array(), array(), 
                                                      array('order_by'=>'account_name asc'));

    $this->get_account_ledger_records();
    $this->get_factory_balance();
    $this->get_rhodium_balance();
    $this->calculate_gst_of_purchase_accounts(0,'Sale');
    $this->calculate_gst_of_purchase_accounts(0,'Labour');
    $this->calculate_gst_of_purchase_accounts(1, 'Sale');
    $this->calculate_gst_of_sales_accounts(0, 'Sale');
    $this->calculate_gst_of_sales_accounts(0, 'Labour');
    $this->calculate_profit_loss_of_export_sales_accounts('Sale');
    $this->calculate_profit_loss_of_export_sales_accounts('Labour');

    $this->get_vadotar_from_factory();
    $this->get_alloy_vodator_balance();
    $this->get_gpc_vodator_balance();
    $this->get_stone_vatav_balance();

    $this->get_overall_rolling();

    $this->data['layout']='application';
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
    
    $this->data['accounts_argold_jan2021_balance'] = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'AR Gold Software Jan 2021'))['balance'];
    $this->data['accounts_arf_jan2021_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARF Software Jan 2021'))['balance'];
    $this->data['accounts_arc_jan2021_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARC Software Jan 2021'))['balance'];
    // $this->data['live_argold_nov2020_balance'] = $arg_nov2020_records->data->record->argold;
    // $this->data['live_arf_nov2020_balance']    = $arf_nov2020_records->data->record->argold;
    // $this->data['live_arc_nov2020_balance']    = $arc_nov2020_records->data->record->argold;

    $this->data['live_argold_jan2021_balance'] = @$arg_jan2021_records->data->record->argold;
    $this->data['live_arf_jan2021_balance']    = @$arf_jan2021_records->data->record->argold;
    $this->data['live_arc_jan2021_balance']    = @$arc_jan2021_records->data->record->argold;
  }

  private function get_vadotar_from_factory() {
    $url=API_ARG_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $this->data['arg_jan2021_vadotar_records'] = json_decode(curl_post_request($url));
    
    $url=API_ARF_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $this->data['arf_jan2021_vadotar_records'] = json_decode(curl_post_request($url));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $this->data['arc_jan2021_vadotar_records'] = json_decode(curl_post_request($url));
  }

  private function get_alloy_vodator_balance() {
    //get alloy vadotar balance and balance fine from account ledgers
    $accounts_balance_select = '(sum(debit_weight) - sum(credit_weight)) as balance, (sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance_fine';
    $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 Alloy Vodator'));
    $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Alloy Vodator'));
    $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 Alloy Vodator'));

    $this->data['accounts_argold_jan2021_alloy_vodator'] = $argold_vouchers['balance'];
    $this->data['accounts_arf_jan2021_alloy_vodator']    = $arf_vouchers['balance'];
    $this->data['accounts_arc_jan2021_alloy_vodator']    = $arc_vouchers['balance'];

    $this->data['accounts_argold_jan2021_alloy_vodator_fine'] = $argold_vouchers['balance_fine'];
    $this->data['accounts_arf_jan2021_alloy_vodator_fine']    = $arf_vouchers['balance_fine'];
    $this->data['accounts_arc_jan2021_alloy_vodator_fine']    = $arc_vouchers['balance_fine'];

    //get alloy vadotar balance and balance fine from factory records
    $arg_jan2021_records = $this->data['arg_jan2021_vadotar_records'];
    $arf_jan2021_records = $this->data['arf_jan2021_vadotar_records'];
    $arc_jan2021_records = $this->data['arc_jan2021_vadotar_records'];
    
    $this->data['live_argold_jan2021_alloy_vodator'] = !empty($arg_jan2021_records->data->alloy_vodator[0]) ? $arg_jan2021_records->data->alloy_vodator[0]->weight : 0;
    $this->data['live_arf_jan2021_alloy_vodator']    = !empty($arf_jan2021_records->data->alloy_vodator[0]) ? $arf_jan2021_records->data->alloy_vodator[0]->weight : 0;
    $this->data['live_arc_jan2021_alloy_vodator']    = !empty($arc_jan2021_records->data->alloy_vodator[0]) ? $arc_jan2021_records->data->alloy_vodator[0]->weight : 0;

    $this->data['live_argold_jan2021_alloy_vodator_fine'] = !empty($arg_jan2021_records->data->alloy_vodator[0]) ? $arg_jan2021_records->data->alloy_vodator[0]->fine : 0;
    $this->data['live_arf_jan2021_alloy_vodator_fine']    = !empty($arf_jan2021_records->data->alloy_vodator[0]) ? $arf_jan2021_records->data->alloy_vodator[0]->fine : 0;
    $this->data['live_arc_jan2021_alloy_vodator_fine']    = !empty($arc_jan2021_records->data->alloy_vodator[0]) ? $arc_jan2021_records->data->alloy_vodator[0]->fine : 0;
  } 

  private function get_gpc_vodator_balance() {
    //get gpc vadotar balance and balance fine from account ledgers
    $accounts_balance_select = '(sum(debit_weight) - sum(credit_weight)) as balance, (sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance_fine';
    $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 GPC Vodator'));
    $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 GPC Vodator'));
    $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 GPC Vodator'));

    $this->data['accounts_argold_jan2021_gpc_vodator'] = $argold_vouchers['balance'];
    $this->data['accounts_arf_jan2021_gpc_vodator']    = $arf_vouchers['balance'];
    $this->data['accounts_arc_jan2021_gpc_vodator']    = $arc_vouchers['balance'];

    $this->data['accounts_argold_jan2021_gpc_vodator_fine'] = $argold_vouchers['balance_fine'];
    $this->data['accounts_arf_jan2021_gpc_vodator_fine']    = $arf_vouchers['balance_fine'];
    $this->data['accounts_arc_jan2021_gpc_vodator_fine']    = $arc_vouchers['balance_fine'];

    //get gpc vadotar balance and balance fine from factory records
    $arg_jan2021_records = $this->data['arg_jan2021_vadotar_records'];
    $arf_jan2021_records = $this->data['arf_jan2021_vadotar_records'];
    $arc_jan2021_records = $this->data['arc_jan2021_vadotar_records'];
    
    $this->data['live_argold_jan2021_gpc_vodator'] = !empty($arg_jan2021_records->data->gpc_vodator[0]) ? $arg_jan2021_records->data->gpc_vodator[0]->weight : 0;
    $this->data['live_arf_jan2021_gpc_vodator']    = !empty($arf_jan2021_records->data->gpc_vodator[0]) ? $arf_jan2021_records->data->gpc_vodator[0]->weight : 0;
    $this->data['live_arc_jan2021_gpc_vodator']    = !empty($arc_jan2021_records->data->gpc_vodator[0]) ? $arc_jan2021_records->data->gpc_vodator[0]->weight : 0;

    $this->data['live_argold_jan2021_gpc_vodator_fine'] = !empty($arg_jan2021_records->data->gpc_vodator[0]) ? $arg_jan2021_records->data->gpc_vodator[0]->fine : 0;
    $this->data['live_arf_jan2021_gpc_vodator_fine']    = !empty($arf_jan2021_records->data->gpc_vodator[0]) ? $arf_jan2021_records->data->gpc_vodator[0]->fine : 0;
    $this->data['live_arc_jan2021_gpc_vodator_fine']    = !empty($arc_jan2021_records->data->gpc_vodator[0]) ? $arc_jan2021_records->data->gpc_vodator[0]->fine : 0;
  }

  private function get_stone_vatav_balance() {
    //get stone vatav balance and balance fine from account ledgers
    $accounts_balance_select = '(sum(debit_weight) - sum(credit_weight)) as balance, (sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance_fine';
    $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Jan 2021 Stone Vatav'));
    $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Jan 2021 Stone Vatav'));
    $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Jan 2021 Stone Vatav'));

    $this->data['accounts_argold_jan2021_stone_vatav'] = $argold_vouchers['balance'];
    $this->data['accounts_arf_jan2021_stone_vatav']    = $arf_vouchers['balance'];
    $this->data['accounts_arc_jan2021_stone_vatav']    = $arc_vouchers['balance'];

    $this->data['accounts_argold_jan2021_stone_vatav_fine'] = $argold_vouchers['balance_fine'];
    $this->data['accounts_arf_jan2021_stone_vatav_fine']    = $arf_vouchers['balance_fine'];
    $this->data['accounts_arc_jan2021_stone_vatav_fine']    = $arc_vouchers['balance_fine'];

    //get gpc vadotar balance and balance fine from factory records
    $arg_jan2021_records = $this->data['arg_jan2021_vadotar_records'];
    $arf_jan2021_records = $this->data['arf_jan2021_vadotar_records'];
    $arc_jan2021_records = $this->data['arc_jan2021_vadotar_records'];
    
    $this->data['live_argold_jan2021_stone_vatav'] = !empty($arg_jan2021_records->data->stone_vatav[0]) ? $arg_jan2021_records->data->stone_vatav[0]->weight : 0;
    $this->data['live_arf_jan2021_stone_vatav']    = !empty($arf_jan2021_records->data->stone_vatav[0]) ? $arf_jan2021_records->data->stone_vatav[0]->weight : 0;
    $this->data['live_arc_jan2021_stone_vatav']    = !empty($arc_jan2021_records->data->stone_vatav[0]) ? $arc_jan2021_records->data->stone_vatav[0]->weight : 0;

    $this->data['live_argold_jan2021_stone_vatav_fine'] = !empty($arg_jan2021_records->data->stone_vatav[0]) ? $arg_jan2021_records->data->stone_vatav[0]->fine : 0;
    $this->data['live_arf_jan2021_stone_vatav_fine']    = !empty($arf_jan2021_records->data->stone_vatav[0]) ? $arf_jan2021_records->data->stone_vatav[0]->fine : 0;
    $this->data['live_arc_jan2021_stone_vatav_fine']    = !empty($arc_jan2021_records->data->stone_vatav[0]) ? $arc_jan2021_records->data->stone_vatav[0]->fine : 0;
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
      $where['date(voucher_date) <=']=date('Y-m-d', strtotime($this->data['loss_date']));
    }

    $select = "account_name, 
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount,0 as id";
    $this->data['trial_balance'] = $this->model->get($select,$where, array() , 
                                                      array('group_by'=>'account_name,',
                                                            'order_by'=>'account_name asc'));

    $purchase_sales_account_domestic_export_select = "account_name, IFNULL(is_export, 0) as is_export,
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount,0 as id";
    $this->data['purchase_sales_account_domestic_export_records'] = $this->model->get($purchase_sales_account_domestic_export_select, 
                                                array('account_name' => array('SALES ACCOUNT', 'PURCHASE ACCOUNT')), 
                                                array(), array('group_by'=>'account_name, is_export'));

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

  private function calculate_gst_of_purchase_accounts($export, $sale_type) {
    $where = array();               
    
    $where['account_name'] = 'PURCHASE ACCOUNT';
    $where['is_export'] = $export;
    $where['sale_type'] = $sale_type;
    $where['gold_rate !='] = 0;
    $where['credit_amount !='] = 0;

    $select = 'sum(taxable_amount) as taxable_amount, sum(cgst_amount) as cgst_amount, sum(sgst_amount) as sgst_amount, sum(tcs_amount) as tcs_amount';
    $purchases = $this->model->find($select, $where);
        
    $data_key = ($export == 1) ? 'purchase_export' : 'purchase_domestic';
    $data_key = $data_key.'_'.$sale_type;

    $this->data[$data_key]['taxable_amount'] = $purchases['taxable_amount'];
    $this->data[$data_key]['cgst_amount'] = $purchases['cgst_amount'];
    $this->data[$data_key]['sgst_amount'] = $purchases['sgst_amount'];
    $this->data[$data_key]['tcs_amount'] = $purchases['tcs_amount'];

    if ($export == 1) {
      $credit_cash = $this->model->find($select, array('voucher_type like "cash%"' => NULL,
                                                       'account_name' => "PURCHASE ACCOUNT",
                                                       'credit_amount > ' => 0));

      $debit_cash = $this->model->find($select, array('voucher_type like "cash%"' => NULL,
                                                      'account_name' => "PURCHASE ACCOUNT",
                                                      'debit_amount > ' => 0));

      $cash = array('taxable_amount' => $credit_cash['taxable_amount'] - $debit_cash['taxable_amount'],
                    'cgst_amount' => $credit_cash['cgst_amount'] - $debit_cash['cgst_amount'],
                    'sgst_amount' => $credit_cash['sgst_amount'] - $debit_cash['sgst_amount'],
                    'tcs_amount' => $credit_cash['tcs_amount'] - $debit_cash['tcs_amount']);
      $this->data['credit_note'] = $cash;
    }
  }

  private function calculate_gst_of_sales_accounts($export, $sale_type){               
    $where = array();               
    
    $where['account_name'] = 'SALES ACCOUNT';
    $where['is_export'] = $export;
    $where['sale_type'] = $sale_type;
    $where['gold_rate !='] = 0;
    $where['debit_amount !='] = 0;

    $select = 'sum(taxable_amount) as taxable_amount, sum(cgst_amount) as cgst_amount, sum(sgst_amount) as sgst_amount, sum(tcs_amount) as tcs_amount';
    $sales = $this->model->find($select, $where);
        
    $data_key = ($export == 1) ? 'sale_export' : 'sale_domestic';
    $data_key = $data_key.'_'.$sale_type;

    $this->data[$data_key]['taxable_amount'] = $sales['taxable_amount'];
    $this->data[$data_key]['cgst_amount'] = $sales['cgst_amount'];
    $this->data[$data_key]['sgst_amount'] = $sales['sgst_amount'];
    $this->data[$data_key]['tcs_amount'] = $sales['tcs_amount'];

    if ($export == 0 && $sale_type = 'Sale') {
      $credit_cash = $this->model->find($select, array('voucher_type like "cash%"' => NULL,
                                                       'account_name' => "SALES ACCOUNT",
                                                       'credit_amount > ' => 0));

      $debit_cash = $this->model->find($select, array('voucher_type like "cash%"' => NULL,
                                                      'account_name' => "SALES ACCOUNT",
                                                      'debit_amount > ' => 0));

      $cash = array('taxable_amount' => -1 * $credit_cash['taxable_amount'] + $debit_cash['taxable_amount'],
                    'cgst_amount' => -1 * $credit_cash['cgst_amount'] + $debit_cash['cgst_amount'],
                    'sgst_amount' => -1 * $credit_cash['sgst_amount'] + $debit_cash['sgst_amount'],
                    'tcs_amount' => -1 * $credit_cash['tcs_amount'] + $debit_cash['tcs_amount']);
      $this->data['debit_note'] = $cash;
    }
  }

  private function calculate_profit_loss_of_export_sales_accounts($sale_type){               
    $where = array();               
    
    $where['ounce_rate !='] = 0;
    if ($sale_type == 'Labour')
      $select = 'sum(labour_usd_amount * usd_rate) + sum(freight_usd_amount * usd_rate) as taxable_amount, 0 as cgst_amount, 0 as sgst_amount, 0 as tcs_amount, 0 as factory_fine'; 
    else
      $select = 'sum(taxable_usd_amount * usd_rate) + sum(premium_usd_amount * usd_rate) as taxable_amount, 0 as cgst_amount, 0 as sgst_amount, 0 as tcs_amount, sum(factory_fine) as factory_fine'; 

    $sales = $this->chitti_model->find($select, $where);
        
    $data_key = 'sale_export';
    $data_key = $data_key.'_'.$sale_type;

    $this->data[$data_key]['taxable_amount'] = $sales['taxable_amount'];
    $this->data[$data_key]['cgst_amount'] = $sales['cgst_amount'];
    $this->data[$data_key]['sgst_amount'] = $sales['sgst_amount'];
    $this->data[$data_key]['tcs_amount'] = $sales['tcs_amount'];
    $this->data[$data_key]['factory_fine'] = $sales['factory_fine'];
  }

  private function get_gold_rate_from_myspn() {
    $gold_rate_response = get_web_page("http://spngoldlivebroadcast.noip.us:8888/VOTSBroadcast/Services/xml/a/%20mumbai?_=1617860765592");
    $string = explode('GOLD MUMBAI 99.50 WITH GST & TCS RTGS', $gold_rate_response);
    $this->data['gold_rate'] = @explode(',', $string[1])[3];

    $string = explode('SPOT GOLD', $gold_rate_response);
    $this->data['spot_gold'] = @explode(',', $string[1])[3];
  
    $string = explode('MUSDINR', $gold_rate_response);
    $this->data['usd_rate'] = @explode(',', $string[1])[3];
  }  

  private function update_alloy_gpc_stone_vadotar() {
    //$this->metal_receipt_voucher_model->delete_vodator_records(date('Y-m-d'));
    //$this->metal_issue_voucher_model->delete_vodator_records(date('Y-m-d'));
    $update_vadotar = isset($_GET['update_vadotar']) ? TRUE : FALSE;
    
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
  }

  private function get_rhodium_balance() {
    $this->data['rhodium'] = array();
    $this->set_rhodium_purchase('Dip R/d');
    $this->set_rhodium_purchase('Pen R/d');
    $this->set_rhodium_purchase('Dip R/d Issue', $this->data['rhodium']['Dip R/d']['rate']);
    $this->set_rhodium_purchase('Pen R/d Issue', $this->data['rhodium']['Pen R/d']['rate']);

    $this->data['rhodium']['Dip R/d Closing'] = array('fine' => $this->data['rhodium']['Dip R/d']['fine'] - $this->data['rhodium']['Dip R/d Issue']['fine'],
                                                      'amount' => $this->data['rhodium']['Dip R/d']['amount'] - $this->data['rhodium']['Dip R/d Issue']['amount']);
    $this->data['rhodium']['Pen R/d Closing'] = array('fine' => $this->data['rhodium']['Pen R/d']['fine'] - $this->data['rhodium']['Pen R/d Issue']['fine'],
                                                      'amount' => $this->data['rhodium']['Pen R/d']['amount'] - $this->data['rhodium']['Pen R/d Issue']['amount']);
  } 

  private function set_rhodium_purchase($rhodium_type, $purchase_rate = 0) {
    $select = 'sum(fine) as fine';
    $rhodium_fine = $this->metal_receipt_voucher_model->find($select, array('account_name' => $rhodium_type));
    $this->data['rhodium'][$rhodium_type] = array('fine' => $rhodium_fine['fine']);

    if ($purchase_rate == 0) {
      $select = 'sum(debit_amount) as debit_amount';
      $rhodium_amount = $this->voucher_model->find($select, array('account_name' => $rhodium_type,
                                                               'voucher_type' => 'rate cut issue voucher'));
      $this->data['rhodium'][$rhodium_type]['amount'] = $rhodium_amount['debit_amount'];
      $this->data['rhodium'][$rhodium_type]['purchase_rate'] = $this->data['rhodium'][$rhodium_type]['amount'] / $this->data['rhodium'][$rhodium_type]['fine'];
    } else {
      $this->data['rhodium'][$rhodium_type]['purchase_rate'] = $purchase_rate;
      $this->data['rhodium'][$rhodium_type]['amount'] = $purchase_rate * $this->data['rhodium'][$rhodium_type]['fine'];
    }

  }
}
