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
    if (isset($_GET['ac_id'])) {
      $issue_processes = $this->metal_receipt_voucher_model->get('', array('id' => $_GET['ac_id']));
      foreach($issue_processes as $issue_process) {
        $process=array(
          'account_name' => 'AR Gold Loss Account',
          'site_name' => 'AR Gold',
          'narration' => $issue_process['narration'],
          'receipt_type' => 'Loss Account',
          'debit_weight'=> $issue_process['credit_weight'],
          'purity'=>100,
          'factory_purity'=>100,
          'factory_fine' => $issue_process['credit_weight'],
          // 'description'=>$_GET['description'],
          'company_id'=>1,
          // 'parent_id'=>$_GET['parent_id'],
          'voucher_date'=> $issue_process['voucher_date'],
          'metal_receipt_voucher_reference_id' => $issue_process['id']);
        $receipt_obj = new metal_receipt_voucher_model($process);
        $receipt_obj->before_validate();
        $receipt_obj->save(true);
      }
      echo 'done'; die();
    } 

    $this->data['loss_date']=!empty($_GET['loss_date'])?$_GET['loss_date']:'';

//    $this->get_gold_rate_from_myspn();
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
    $this->calculate_hallmark_amount_with_tax();

    $this->get_vadotar_from_factories_and_accounts();

    $this->get_overall_rolling();

    $this->data['layout']='application';
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_factory_balance() {
    // $url=API_MAY2022_ARG_PATH."issue_and_receipts/ledger_balance/index";
    // $arg_records=json_decode(curl_post_request($url));

    // $url=API_MAY2022_ARF_PATH."issue_and_receipts/ledger_balance/index";
    // $arf_records=json_decode(curl_post_request($url));
    
    // $url=API_MAY2022_ARC_PATH."issue_and_receipts/ledger_balance/index";
    // $arc_records=json_decode(curl_post_request($url));
    
    // $url=API_AUG2022_ARG_PATH."issue_and_receipts/ledger_balance/index";
    // $arg_aug2022_records=json_decode(curl_post_request($url));

    // $url=API_AUG2022_ARF_PATH."issue_and_receipts/ledger_balance/index";
    // $arf_aug2022_records=json_decode(curl_post_request($url));
    
    // $url=API_AUG2022_ARC_PATH."issue_and_receipts/ledger_balance/index";
    // $arc_aug2022_records=json_decode(curl_post_request($url));
    
    // $url=API_FEB2023_ARG_PATH."issue_and_receipts/ledger_balance/index";
    // $arg_feb2023_records=json_decode(curl_post_request($url));

    // $url=API_FEB2023_ARF_PATH."issue_and_receipts/ledger_balance/index";
    // $arf_feb2023_records=json_decode(curl_post_request($url));
    
    $url=API_APR2023_ARC_PATH."issue_and_receipts/ledger_balance/index";
    $arc_apr2023_records=json_decode(curl_post_request($url));
    
    $url=API_APR2023_ARG_PATH."issue_and_receipts/ledger_balance/index";
    $arg_apr2023_records=json_decode(curl_post_request($url));

    $url=API_APR2023_ARF_PATH."issue_and_receipts/ledger_balance/index";
    $arf_apr2023_records=json_decode(curl_post_request($url));
    
    // $url=API_FEB2023_ARC_PATH."issue_and_receipts/ledger_balance/index";
    // $arc_feb2023_records=json_decode(curl_post_request($url));
    

    $url=API_EXPORT_INTERNAL_PATH."issue_and_receipts/ledger_balance/index";
    $export_records=json_decode(curl_post_request($url));
    $url=API_DOMESTIC_INTERNAL_PATH."issue_and_receipts/ledger_balance/index";
    $domestic_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = '(sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance';
    
    // $this->data['accounts_argold_balance'] = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'AR Gold Software (May 2022)'))['balance'];
    // $this->data['accounts_arf_balance']    = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'ARF Software (May 2022)'))['balance'];
    // $this->data['accounts_arc_balance']    = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'ARC Software (May 2022)'))['balance'];
    // $this->data['accounts_aug2022_argold_balance'] = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'AR Gold Software (Aug 2022)'))['balance'];
    // $this->data['accounts_aug2022_arf_balance']    = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'ARF Software (Aug 2022)'))['balance'];
    // $this->data['accounts_aug2022_arc_balance']    = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'ARC Software (Aug 2022)'))['balance'];

    // $this->data['accounts_feb2023_argold_balance'] = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'AR Gold Software (Feb 2023)'))['balance'];
    // $this->data['accounts_feb2023_arf_balance']    = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'ARF Software (Feb 2023)'))['balance'];
    // $this->data['accounts_feb2023_arc_balance']    = $this->voucher_model->find($accounts_balance_select, 
    //                                                       array('account_name' => 'ARC Software (Feb 2023)'))['balance'];

    $this->data['accounts_apr2023_argold_balance'] = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'AR Gold Software (Apr 2023)'))['balance'];
    $this->data['accounts_apr2023_arf_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARF Software (Apr 2023)'))['balance'];
    $this->data['accounts_apr2023_arc_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARC Software (Apr 2023)'))['balance'];

    $this->data['accounts_apr2023_export_balance'] = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'Export Internal Software'))['balance'];
    $this->data['accounts_apr2023_domestic_balance'] = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'Domestic Internal Software'))['balance'];
    $this->data['live_apr2023_argold_balance'] = @$arg_apr2023_records->data->record->argold;
    $this->data['live_apr2023_arf_balance']    = @$arf_apr2023_records->data->record->argold;
    $this->data['live_apr2023_arc_balance']    = @$arc_apr2023_records->data->record->argold;
    // $this->data['live_aug2022_argold_balance'] = @$arg_aug2022_records->data->record->argold;
    // $this->data['live_aug2022_arf_balance']    = @$arf_aug2022_records->data->record->argold;
    // $this->data['live_aug2022_arc_balance']    = @$arc_aug2022_records->data->record->argold;
    // $this->data['live_feb2023_argold_balance'] = @$arg_feb2023_records->data->record->argold;
    // $this->data['live_feb2023_arf_balance']    = @$arf_feb2023_records->data->record->argold;
    // $this->data['live_feb2023_arc_balance']    = @$arc_feb2023_records->data->record->argold;

    $this->data['live_apr2023_export_balance'] = @$export_records->data->record->argold;
    $this->data['live_apr2023_domestic_balance'] = @$export_records->data->record->argold;
  }

  private function get_vadotar_from_factories_and_accounts() {
    $this->get_vadotar_from_factory('AR Gold', 'Apr 2023');    
    $this->get_vadotar_from_factory('ARF', 'Apr 2023');    
    $this->get_vadotar_from_factory('ARC', 'Apr 2023');    
    // $this->get_vadotar_from_factory('AR Gold', 'May 2022');    
    // $this->get_vadotar_from_factory('ARF', 'May 2022');    
    // $this->get_vadotar_from_factory('ARC', 'May 2022');    
    // // $this->get_vadotar_from_factory('AR Gold', 'Aug 2022');    
    // $this->get_vadotar_from_factory('ARF', 'Aug 2022');    
    // $this->get_vadotar_from_factory('ARC', 'Aug 2022');    
    // $this->get_vadotar_from_factory('AR Gold', 'Feb 2023');    
    // $this->get_vadotar_from_factory('ARF', 'Feb 2023');    
    //$this->get_vadotar_from_factory('ARC', 'Feb 2023');    
  }

  private function get_vadotar_from_factory($site_name, $hostversion) {
    //$this->data['receipt_types'] = ['Alloy Vodator', 'GPC Vodator', 'Stone Vatav','Spring Vatav','Meena Vatav', 'Copper Vatav', 'Rhodium Vatav', 'Auto Tounch Loss Fine'];
    $this->data['receipt_types'] = ['Alloy Vodator', 'GPC Vodator', 'Stone Vatav','Meena Vatav', 'Copper Vatav', 'Rhodium Vatav', 'Auto Tounch Loss Fine', 'Spring Vatav'];
    $this->data['site_names'] = ['AR Gold', 'ARF', 'ARC'];
    $this->data['hostversions'] = ['Apr 2023']; //['May 2022', 'Aug 2022', 'Feb 2023'];

    $url = get_api_path($site_name, $hostversion)."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $response = json_decode(curl_post_request($url));
    
    foreach ($this->data['receipt_types'] as $receipt_type) {
      $this->data['factory_vadotar_records'] ??= [];
      $this->data['factory_vadotar_records'][$receipt_type] ??= [];
      $this->data['factory_vadotar_records'][$receipt_type][$site_name] ??= [];
      $this->data['factory_vadotar_records'][$receipt_type][$site_name][$hostversion] ??= [];
      

      $this->data['factory_vadotar_records'][$receipt_type][$site_name][$hostversion]['balance'] = $response->data->$receipt_type[0]->weight;
      $this->data['factory_vadotar_records'][$receipt_type][$site_name][$hostversion]['balance_fine'] = $response->data->$receipt_type[0]->fine;

      $this->get_accounts_vodator_balance($site_name, $receipt_type, $hostversion);
    }
  }

  private function get_accounts_vodator_balance($site_name, $receipt_type, $hostversion) {
    $this->data['account_vadotar_balance'] ??= [];
    $this->data['account_vadotar_balance'][$receipt_type] ??= [];
    $this->data['account_vadotar_balance'][$receipt_type][$site_name] ??= [];
    $this->data['account_vadotar_balance'][$receipt_type][$site_name][$hostversion] ??= [];
    
    $account_name = $site_name.' '.$receipt_type.' ('.$hostversion.')';
    $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
    $account_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => $account_name,
                                                                                   'voucher_type != ' => 'opening stock voucher',
                                                                                   'receipt_type' => $receipt_type));

    $this->data['account_vadotar_balance'][$receipt_type][$site_name][$hostversion]['balance'] = $account_vouchers['balance'];      
    $this->data['account_vadotar_balance'][$receipt_type][$site_name][$hostversion]['balance_fine'] = $account_vouchers['balance_fine'];
  } 

  private function get_overall_rolling() {  
    $url=API_APR2023_ARG_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arg_rolling_records=json_decode(curl_post_request($url));
    $this->data['live_argold_rolling_balance'] =!empty($arg_rolling_records->data->balance)?$arg_rolling_records->data->balance:0;
    $this->data['live_argold_rolling_gpc_balance']=!empty($arg_rolling_records->data->gpc_out_balance)? $arg_rolling_records->data->gpc_out_balance:0;
    
    $url=API_APR2023_ARF_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arf_rolling_records=json_decode(curl_post_request($url));
    $this->data['live_arf_rolling_balance'] =!empty($arf_rolling_records->data->balance)? $arf_rolling_records->data->balance:0;
    $this->data['live_arf_rolling_gpc_balance']=!empty($arf_rolling_records->data->gpc_out_balance)? $arf_rolling_records->data->gpc_out_balance:0;
    
    $url=API_APR2023_ARC_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arc_rolling_records=json_decode(curl_post_request($url));
    $this->data['live_arc_rolling_balance'] =!empty($arc_rolling_records->data->balance)?$arc_rolling_records->data->balance:0;
    $this->data['live_arc_rolling_gpc_balance']=!empty($arc_rolling_records->data->gpc_out_balance)? $arc_rolling_records->data->gpc_out_balance:0;
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
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount,
               IFNULL(sum(usd_debit_amount),0) - IFNULL(sum(usd_credit_amount),0) as usd_amount,0 as id";
    $this->data['trial_balance'] = $this->model->get($select,$where, array() , 
                                                      array('group_by'=>'account_name,',
                                                            'order_by'=>'account_name asc'));

    $purchase_sales_account_domestic_export_select = "account_name, IFNULL(is_export, 0) as is_export,
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount,0 as id";
    $this->data['purchase_sales_account_domestic_export_records'] = $this->model->get($purchase_sales_account_domestic_export_select, 
                                                array_merge($where, array('account_name' => array('SALES ACCOUNT', 'PURCHASE ACCOUNT'))), 
                                                array(), array('group_by'=>'account_name, is_export'));
    
    $this->data['domestic_labour_amount'] = $this->model->find('  IFNULL(sum(debit_amount),0) 
                                                                - IFNULL(sum(credit_amount),0) as amount', 
                                                array_merge($where, array('account_name' => array('Domestic Labour Amount'))), 
                                                array());
    if (empty($this->data['domestic_labour_amount'])) $this->data['domestic_labour_amount'] = array('amount' => 0);

    $loss_account = array('account_name' => 'Loss Account Details',
                          'fine' => 0, 'vadotar' => 0, 'amount' => 0);
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
    
    $where['usd_rate != 0'] = NULL;
    if ($sale_type == 'Labour') {
      $where['ounce_rate != 0 or usd_rate != 0'] = NULL;
      $select = 'sum(labour_usd_amount * usd_rate) + sum(freight_usd_amount * usd_rate) as taxable_amount, 0 as cgst_amount, 0 as sgst_amount, 0 as tcs_amount, 0 as factory_fine'; 
    } else {
      $where['ounce_rate != 0'] = NULL;
      $select = 'sum(taxable_usd_amount * usd_rate) + sum(premium_usd_amount * usd_rate) as taxable_amount, 0 as cgst_amount, 0 as sgst_amount, 0 as tcs_amount, sum(factory_fine) as factory_fine'; 
    }
    if(!empty($this->data['loss_date'])){
      $where['date(date) <=']=date('Y-m-d', strtotime($this->data['loss_date']));
    }

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
    //$gold_rate_response = get_web_page("http://spngoldlivebroadcast.noip.us:8888/VOTSBroadcast/Services/xml/a/%20mumbai?_=1617860765592");
    $gold_rate_response = get_web_page("http://spngoldlivebroadcast.noip.us:8888/VOTSBroadcast/Services/xml/a/%20mumbai?_=1658227048570");
    $string = explode('GOLD MUMBAI 99.5 RTGS', $gold_rate_response);
    $this->data['gold_rate'] = @explode(',', $string[1])[3];
    $this->data['gold_rate'] = 1.03 * $this->data['gold_rate'];

    $string = explode('SPOT GOLD', $gold_rate_response);
    $this->data['spot_gold'] = @explode(',', $string[1])[3];
  
    $string = explode('MUSDINR', $gold_rate_response);
    $this->data['usd_rate'] = @explode(',', $string[1])[3];
  }  

  private function update_alloy_gpc_stone_vadotar() {
    $update_vadotar = isset($_GET['update_vadotar']) ? TRUE : FALSE;
    
    if ($update_vadotar) {
      $incorrect_vadotar_vouchers = $this->voucher_model->get('receipt_type, site_name, voucher_date, 
                                                               sum(credit_weight) as credit_weight, 
                                                               sum(debit_weight) as debit_weight',
                                         array('receipt_type' => array('Alloy Vodator', 'GPC Vodator', 'Stone Vatav','Spring Vatav','Meena Vatav', 'Copper Vatav', 'Rhodium Vatav', 'Auto Tounch Loss Fine', 'Spring Vatav')),
                                         array(), array('group_by' => 'receipt_type, site_name, voucher_date',
                                                        'having' => 'credit_weight != debit_weight'));

      foreach($incorrect_vadotar_vouchers as $incorrect_vadotar_voucher) {
        $this->voucher_model->delete('', array('receipt_type' => $incorrect_vadotar_voucher['receipt_type'],
                                               'site_name' => $incorrect_vadotar_voucher['site_name'],
                                               'voucher_date' => $incorrect_vadotar_voucher['voucher_date']));
        $this->ledger_model->delete('', array('parent_id not in (select id from ac_vouchers)' => NULL));
      }

      // $this->create_update_vadotar_records(API_MAY2022_ARG_PATH, 'AR Gold', 'May 2022');
      // $this->create_update_vadotar_records(API_MAY2022_ARF_PATH, 'ARF', 'May 2022');
      // $this->create_update_vadotar_records(API_MAY2022_ARC_PATH, 'ARC', 'May 2022');
      // $this->create_update_vadotar_records(API_AUG2022_ARG_PATH, 'AR Gold', 'Aug 2022');
      // $this->create_update_vadotar_records(API_AUG2022_ARF_PATH, 'ARF', 'Aug 2022');
      // $this->create_update_vadotar_records(API_AUG2022_ARC_PATH, 'ARC', 'Aug 2022');
      // $this->create_update_vadotar_records(API_FEB2023_ARG_PATH, 'AR Gold', 'Feb 2023');
      // $this->create_update_vadotar_records(API_FEB2023_ARF_PATH, 'ARF', 'Feb 2023');
      $this->create_update_vadotar_records(API_APR2023_ARC_PATH, 'ARC', 'Apr 2023');
      $this->create_update_vadotar_records(API_APR2023_ARG_PATH, 'AR Gold', 'Apr 2023');
      $this->create_update_vadotar_records(API_APR2023_ARF_PATH, 'ARF', 'Apr 2023');
      //$this->create_update_vadotar_records(API_FEB2023_ARC_PATH, 'ARC', 'Feb 2023');
    }
  }

  private function create_update_vadotar_records($api_path, $site_name, $hostversion) {
    $url = $api_path."issue_and_receipts/alloy_gpc_vodator_ledger/index?group_by_date=1";
    $records = json_decode(curl_post_request($url));
    if (!empty($records)) {
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator', $site_name, $hostversion);

      $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->spring_vatav_group_by_date, 'Spring Vatav', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->meena_vatav_group_by_date, 'Meena Vatav', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->copper_vatav_group_by_date, 'Copper Vatav', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->rhodium_vatav_group_by_date, 'Rhodium Vatav', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->tounch_loss_fine_group_by_date, 'Auto Tounch Loss Fine', $site_name, $hostversion);
    }
  }

  private function get_rhodium_balance() {
    $this->data['rhodium'] = array();
    $this->set_rhodium_purchase('Dip R/d');
    $this->set_rhodium_purchase('Pen R/d');
    $this->set_rhodium_purchase('Dip R/d Issue', $this->data['rhodium']['Dip R/d']['rate']);
    $this->set_rhodium_purchase('Pen R/d Issue', $this->data['rhodium']['Pen R/d']['rate']);

    $this->data['rhodium']['Dip R/d Closing'] = array('fine' => $this->data['rhodium']['Dip R/d']['fine'] - $this->data['rhodium']['Dip R/d Issue']['fine'],
                                                      'amount' => $this->data['rhodium']['Dip R/d']['amount'] - $this->data['rhodium']['Dip R/d Issue']['amount'],
                                                      'rate' => 0);
    if ($this->data['rhodium']['Dip R/d Closing']['amount'] > 0)
      $this->data['rhodium']['Dip R/d Closing']['rate'] = $this->data['rhodium']['Dip R/d']['rate'];
    $this->data['rhodium']['Pen R/d Closing'] = array('fine' => $this->data['rhodium']['Pen R/d']['fine'] - $this->data['rhodium']['Pen R/d Issue']['fine'],
                                                      'amount' => $this->data['rhodium']['Pen R/d']['amount'] - $this->data['rhodium']['Pen R/d Issue']['amount'],
                                                      'rate' => 0);
    if ($this->data['rhodium']['Pen R/d Closing']['amount'] > 0)
      $this->data['rhodium']['Pen R/d Closing']['rate'] = $this->data['rhodium']['Pen R/d']['rate'];
  } 

  private function set_rhodium_purchase($rhodium_type, $purchase_rate = 0) {
    $select = 'sum(factory_fine) as factory_fine';
    $rhodium_fine = $this->voucher_model->find($select, array('account_name' => $rhodium_type,
                                                              'voucher_type' => array('metal receipt voucher')));
    $this->data['rhodium'][$rhodium_type] = array('fine' => $rhodium_fine['factory_fine']);

    if ($purchase_rate == 0) {
      $select = 'sum(debit_amount) as debit_amount';
      $rhodium_amount = $this->voucher_model->find($select, array('account_name' => $rhodium_type,
                                                                  'voucher_type' => 'rate cut issue voucher'));
      $this->data['rhodium'][$rhodium_type]['amount'] = $rhodium_amount['debit_amount'];
      if ($this->data['rhodium'][$rhodium_type]['fine'] > 0)
        $this->data['rhodium'][$rhodium_type]['rate'] = $this->data['rhodium'][$rhodium_type]['amount'] / $this->data['rhodium'][$rhodium_type]['fine'];
      else 
        $this->data['rhodium'][$rhodium_type]['rate'] = 0;
    } else {
      if ($this->data['rhodium'][$rhodium_type]['fine'] > 0)
        $this->data['rhodium'][$rhodium_type]['rate'] = $purchase_rate;
      else 
        $this->data['rhodium'][$rhodium_type]['rate'] = 0;
      $this->data['rhodium'][$rhodium_type]['amount'] = $purchase_rate * $this->data['rhodium'][$rhodium_type]['fine'];
    }

  }

  private function calculate_hallmark_amount_with_tax(){               
    $select_labour = 'sum(hallmark_amount) * 1.05 as hallmark_amount';
    $select_sale = 'sum(hallmark_amount) * 1.03 as hallmark_amount';
    $hallmark_amount_labour = $this->chitti_model->find($select_labour, array('usd_rate != 0', 'sale_type' => 'Labour'));
    $hallmark_amount_sale = $this->chitti_model->find($select_sale, array('usd_rate != 0', 'sale_type' => 'Sale'));
    $this->data['hallmark_amount'] = $hallmark_amount_labour['hallmark_amount'] + $hallmark_amount_sale['hallmark_amount'];
  }

}
