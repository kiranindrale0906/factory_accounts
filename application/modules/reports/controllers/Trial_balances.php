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

    $this->get_vadotar_from_factories_and_accounts();
    // $this->get_alloy_vodator_balance();
    // $this->get_gpc_vodator_balance();
    // $this->get_stone_vatav_balance();
    // $this->get_meena_vatav_balance();
    // $this->get_copper_vatav_balance();
    // $this->get_rhodium_vatav_balance();
    // $this->get_tounch_loss_fine_balance();

    $this->get_overall_rolling();

    $this->data['layout']='application';
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_factory_balance() {
    $url=API_MAY2022_ARG_PATH."issue_and_receipts/ledger_balance/index";
    $arg_records=json_decode(curl_post_request($url));

    $url=API_MAY2022_ARF_PATH."issue_and_receipts/ledger_balance/index";
    $arf_records=json_decode(curl_post_request($url));
    
    $url=API_MAY2022_ARC_PATH."issue_and_receipts/ledger_balance/index";
    $arc_records=json_decode(curl_post_request($url));
    
    $url=API_AUG2022_ARG_PATH."issue_and_receipts/ledger_balance/index";
    $arg_aug2022_records=json_decode(curl_post_request($url));

    $url=API_AUG2022_ARF_PATH."issue_and_receipts/ledger_balance/index";
    $arf_aug2022_records=json_decode(curl_post_request($url));
    
    $url=API_AUG2022_ARC_PATH."issue_and_receipts/ledger_balance/index";
    $arc_aug2022_records=json_decode(curl_post_request($url));
    
    $url=API_EXPORT_INTERNAL_PATH."issue_and_receipts/ledger_balance/index";
    $export_records=json_decode(curl_post_request($url));
    
    $accounts_balance_select = '(sum(debit_weight*purity/100) - sum(credit_weight*purity/100)) as balance';
    
    $this->data['accounts_argold_balance'] = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'AR Gold Software (May 2022)'))['balance'];
    $this->data['accounts_arf_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARF Software (May 2022)'))['balance'];
    $this->data['accounts_arc_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARC Software (May 2022)'))['balance'];
    $this->data['accounts_aug2022_argold_balance'] = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'AR Gold Software (Aug 2022)'))['balance'];
    $this->data['accounts_aug2022_arf_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARF Software (Aug 2022)'))['balance'];
    $this->data['accounts_aug2022_arc_balance']    = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'ARC Software (Aug 2022)'))['balance'];

    $this->data['accounts_export_balance'] = $this->voucher_model->find($accounts_balance_select, 
                                                          array('account_name' => 'Export Internal Software'))['balance'];
    $this->data['live_argold_balance'] = @$arg_records->data->record->argold;
    $this->data['live_arf_balance']    = @$arf_records->data->record->argold;
    $this->data['live_arc_balance']    = @$arc_records->data->record->argold;
    $this->data['live_aug2022_argold_balance'] = @$arg_aug2022_records->data->record->argold;
    $this->data['live_aug2022_arf_balance']    = @$arf_aug2022_records->data->record->argold;
    $this->data['live_aug2022_arc_balance']    = @$arc_aug2022_records->data->record->argold;

    $this->data['live_export_balance'] = @$export_records->data->record->argold;
  }

  private function get_vadotar_from_factories_and_accounts() {
    $this->get_vadotar_from_factory('AR Gold', 'May 2022');    
    $this->get_vadotar_from_factory('ARF', 'May 2022');    
    $this->get_vadotar_from_factory('ARC', 'May 2022');    
    $this->get_vadotar_from_factory('AR Gold', 'Aug 2022');    
    $this->get_vadotar_from_factory('ARF', 'Aug 2022');    
    $this->get_vadotar_from_factory('ARC', 'Aug 2022');    
  }

  private function get_vadotar_from_factory($site_name, $hostversion) {
    $receipt_types = ['Alloy Vodator', 'GPC Vodator', 'Stone Vatav', 'Meeva Vatav', 'Copper Vatav', 'Rhodium Vatav', 'Tounch Loss Fine'];

    $url = get_api_path($site_name, $hostversion)."issue_and_receipts/alloy_gpc_vodator_ledger/index";
    $response = json_decode(curl_post_request($url));
    
    foreach ($receipt_types as $receipt_type) {
      $this->data[$receipt_type] ??= [];
      $this->data[$receipt_type][$site_name] ??= [];
      $this->data[$receipt_type][$site_name][$hostversion] ??= [];
      $this->data[$receipt_type][$site_name][$hostversion]['factory_vadotar_records'] ??= [];

      $this->data[$receipt_type][$site_name][$hostversion]['factory_vadotar_records']['balance'] = $response->data->$receipt_type[0]->weight;
      $this->data[$receipt_type][$site_name][$hostversion]['factory_vadotar_records']['balance_fine'] = $response->data->$receipt_type[0]->fine;

      $this->get_accounts_vodator_balance($site_name, $receipt_type, $hostversion);
    }
  }

  private function get_accounts_vodator_balance($site_name, $receipt_type, $hostversion) {
    $this->data ??= [];
    $this->data[$receipt_type] ??= [];
    $this->data[$receipt_type][$site_name] ??= [];
    $this->data[$receipt_type][$site_name][$hostversion] ??= [];
    $this->data[$receipt_type][$site_name][$hostversion]['account_vadotar_balance'] ??= [];

    $account_name = $site_name.' '.$receipt_type.' ('.$hostversion.') ';
    $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
    $account_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => $account_name));
    
    $this->data[$receipt_type][$site_name][$hostversion]['account_vadotar_balance']['balance'] = $account_vouchers['balance'];      
    $this->data[$receipt_type][$site_name][$hostversion]['account_vadotar_balance']['balance_fine'] = $account_vouchers['balance_fine'];
  } 

  // private function get_alloy_vodator_balance() {
  //   //get alloy vadotar balance and balance fine from account ledgers
  //   $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
  //   $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Alloy Vodator'));
  //   $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Alloy Vodator'));
  //   $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Alloy Vodator'));

  //   $this->data['accounts_argold_alloy_vodator'] = $argold_vouchers['balance'];
  //   $this->data['accounts_arf_alloy_vodator']    = $arf_vouchers['balance'];
  //   $this->data['accounts_arc_alloy_vodator']    = $arc_vouchers['balance'];

  //   $this->data['accounts_argold_alloy_vodator_fine'] = $argold_vouchers['balance_fine'];
  //   $this->data['accounts_arf_alloy_vodator_fine']    = $arf_vouchers['balance_fine'];
  //   $this->data['accounts_arc_alloy_vodator_fine']    = $arc_vouchers['balance_fine'];

  //   //get alloy vadotar balance and balance fine from factory records
  //   $arg_records = $this->data['arg_vadotar_records'];
  //   $arf_records = $this->data['arf_vadotar_records'];
  //   $arc_records = $this->data['arc_vadotar_records'];
    
  //   $this->data['live_argold_alloy_vodator'] = !empty($arg_records->data->alloy_vodator[0]) ? $arg_records->data->alloy_vodator[0]->weight : 0;
  //   $this->data['live_arf_alloy_vodator']    = !empty($arf_records->data->alloy_vodator[0]) ? $arf_records->data->alloy_vodator[0]->weight : 0;
  //   $this->data['live_arc_alloy_vodator']    = !empty($arc_records->data->alloy_vodator[0]) ? $arc_records->data->alloy_vodator[0]->weight : 0;

  //   $this->data['live_argold_alloy_vodator_fine'] = !empty($arg_records->data->alloy_vodator[0]) ? $arg_records->data->alloy_vodator[0]->fine : 0;
  //   $this->data['live_arf_alloy_vodator_fine']    = !empty($arf_records->data->alloy_vodator[0]) ? $arf_records->data->alloy_vodator[0]->fine : 0;
  //   $this->data['live_arc_alloy_vodator_fine']    = !empty($arc_records->data->alloy_vodator[0]) ? $arc_records->data->alloy_vodator[0]->fine : 0;
  // } 

  // private function get_gpc_vodator_balance() {
  //   //get gpc vadotar balance and balance fine from account ledgers
  //   $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
  //   $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold GPC Vodator'));
  //   $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF GPC Vodator'));
  //   $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC GPC Vodator'));

  //   $this->data['accounts_argold_gpc_vodator'] = $argold_vouchers['balance'];
  //   $this->data['accounts_arf_gpc_vodator']    = $arf_vouchers['balance'];
  //   $this->data['accounts_arc_gpc_vodator']    = $arc_vouchers['balance'];

  //   $this->data['accounts_argold_gpc_vodator_fine'] = $argold_vouchers['balance_fine'];
  //   $this->data['accounts_arf_gpc_vodator_fine']    = $arf_vouchers['balance_fine'];
  //   $this->data['accounts_arc_gpc_vodator_fine']    = $arc_vouchers['balance_fine'];

  //   //get gpc vadotar balance and balance fine from factory records
  //   $arg_records = $this->data['arg_vadotar_records'];
  //   $arf_records = $this->data['arf_vadotar_records'];
  //   $arc_records = $this->data['arc_vadotar_records'];
    
  //   $this->data['live_argold_gpc_vodator'] = !empty($arg_records->data->gpc_vodator[0]) ? $arg_records->data->gpc_vodator[0]->weight : 0;
  //   $this->data['live_arf_gpc_vodator']    = !empty($arf_records->data->gpc_vodator[0]) ? $arf_records->data->gpc_vodator[0]->weight : 0;
  //   $this->data['live_arc_gpc_vodator']    = !empty($arc_records->data->gpc_vodator[0]) ? $arc_records->data->gpc_vodator[0]->weight : 0;

  //   $this->data['live_argold_gpc_vodator_fine'] = !empty($arg_records->data->gpc_vodator[0]) ? $arg_records->data->gpc_vodator[0]->fine : 0;
  //   $this->data['live_arf_gpc_vodator_fine']    = !empty($arf_records->data->gpc_vodator[0]) ? $arf_records->data->gpc_vodator[0]->fine : 0;
  //   $this->data['live_arc_gpc_vodator_fine']    = !empty($arc_records->data->gpc_vodator[0]) ? $arc_records->data->gpc_vodator[0]->fine : 0;
  // }

  // private function get_stone_vatav_balance() {
  //   //get stone vatav balance and balance fine from account ledgers
  //   $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
  //   $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Stone Vatav'));
  //   $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Stone Vatav'));
  //   $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Stone Vatav'));

  //   $this->data['accounts_argold_stone_vatav'] = $argold_vouchers['balance'];
  //   $this->data['accounts_arf_stone_vatav']    = $arf_vouchers['balance'];
  //   $this->data['accounts_arc_stone_vatav']    = $arc_vouchers['balance'];

  //   $this->data['accounts_argold_stone_vatav_fine'] = $argold_vouchers['balance_fine'];
  //   $this->data['accounts_arf_stone_vatav_fine']    = $arf_vouchers['balance_fine'];
  //   $this->data['accounts_arc_stone_vatav_fine']    = $arc_vouchers['balance_fine'];

  //   //get gpc vadotar balance and balance fine from factory records
  //   $arg_records = $this->data['arg_vadotar_records'];
  //   $arf_records = $this->data['arf_vadotar_records'];
  //   $arc_records = $this->data['arc_vadotar_records'];
    
  //   $this->data['live_argold_stone_vatav'] = !empty($arg_records->data->stone_vatav[0]) ? $arg_records->data->stone_vatav[0]->weight : 0;
  //   $this->data['live_arf_stone_vatav']    = !empty($arf_records->data->stone_vatav[0]) ? $arf_records->data->stone_vatav[0]->weight : 0;
  //   $this->data['live_arc_stone_vatav']    = !empty($arc_records->data->stone_vatav[0]) ? $arc_records->data->stone_vatav[0]->weight : 0;

  //   $this->data['live_argold_stone_vatav_fine'] = !empty($arg_records->data->stone_vatav[0]) ? $arg_records->data->stone_vatav[0]->fine : 0;
  //   $this->data['live_arf_stone_vatav_fine']    = !empty($arf_records->data->stone_vatav[0]) ? $arf_records->data->stone_vatav[0]->fine : 0;
  //   $this->data['live_arc_stone_vatav_fine']    = !empty($arc_records->data->stone_vatav[0]) ? $arc_records->data->stone_vatav[0]->fine : 0;
  // }
  // private function get_meena_vatav_balance() {
  //   //get stone vatav balance and balance fine from account ledgers
  //   $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
  //   $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Meena Vatav'));
  //   $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Meena Vatav'));
  //   $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Meena Vatav'));

  //   $this->data['accounts_argold_meena_vatav'] = $argold_vouchers['balance'];
  //   $this->data['accounts_arf_meena_vatav']    = $arf_vouchers['balance'];
  //   $this->data['accounts_arc_meena_vatav']    = $arc_vouchers['balance'];

  //   $this->data['accounts_argold_meena_vatav_fine'] = $argold_vouchers['balance_fine'];
  //   $this->data['accounts_arf_meena_vatav_fine']    = $arf_vouchers['balance_fine'];
  //   $this->data['accounts_arc_meena_vatav_fine']    = $arc_vouchers['balance_fine'];

  //   //get gpc vadotar balance and balance fine from factory records
  //   $arg_records = $this->data['arg_vadotar_records'];
  //   $arf_records = $this->data['arf_vadotar_records'];
  //   $arc_records = $this->data['arc_vadotar_records'];
    
  //   $this->data['live_argold_meena_vatav'] = !empty($arg_records->data->meena_vatav[0]) ? $arg_records->data->meena_vatav[0]->weight : 0;
  //   $this->data['live_arf_meena_vatav']    = !empty($arf_records->data->meena_vatav[0]) ? $arf_records->data->meena_vatav[0]->weight : 0;
  //   $this->data['live_arc_meena_vatav']    = !empty($arc_records->data->meena_vatav[0]) ? $arc_records->data->meena_vatav[0]->weight : 0;

  //   $this->data['live_argold_meena_vatav_fine'] = !empty($arg_records->data->meena_vatav[0]) ? $arg_records->data->meena_vatav[0]->fine : 0;
  //   $this->data['live_arf_meena_vatav_fine']    = !empty($arf_records->data->meena_vatav[0]) ? $arf_records->data->meena_vatav[0]->fine : 0;
  //   $this->data['live_arc_meena_vatav_fine']    = !empty($arc_records->data->meena_vatav[0]) ? $arc_records->data->stone_vatav[0]->fine : 0;
  // }

  // private function get_copper_vatav_balance() {
  //   //get stone vatav balance and balance fine from account ledgers
  //   $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
  //   $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Copper Vatav'));
  //   $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Copper Vatav'));
  //   $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Copper Vatav'));

  //   $this->data['accounts_argold_copper_vatav'] = $argold_vouchers['balance'];
  //   $this->data['accounts_arf_copper_vatav']    = $arf_vouchers['balance'];
  //   $this->data['accounts_arc_copper_vatav']    = $arc_vouchers['balance'];

  //   $this->data['accounts_argold_copper_vatav_fine'] = $argold_vouchers['balance_fine'];
  //   $this->data['accounts_arf_copper_vatav_fine']    = $arf_vouchers['balance_fine'];
  //   $this->data['accounts_arc_copper_vatav_fine']    = $arc_vouchers['balance_fine'];

  //   //get gpc vadotar balance and balance fine from factory records
  //   $arg_records = $this->data['arg_vadotar_records'];
  //   $arf_records = $this->data['arf_vadotar_records'];
  //   $arc_records = $this->data['arc_vadotar_records'];
    
  //   $this->data['live_argold_copper_vatav'] = !empty($arg_records->data->copper_vatav[0]) ? $arg_records->data->copper_vatav[0]->weight : 0;
  //   $this->data['live_arf_copper_vatav']    = !empty($arf_records->data->copper_vatav[0]) ? $arf_records->data->copper_vatav[0]->weight : 0;
  //   $this->data['live_arc_copper_vatav']    = !empty($arc_records->data->copper_vatav[0]) ? $arc_records->data->copper_vatav[0]->weight : 0;

  //   $this->data['live_argold_copper_vatav_fine'] = !empty($arg_records->data->copper_vatav[0]) ? $arg_records->data->copper_vatav[0]->fine : 0;
  //   $this->data['live_arf_copper_vatav_fine']    = !empty($arf_records->data->copper_vatav[0]) ? $arf_records->data->copper_vatav[0]->fine : 0;
  //   $this->data['live_arc_copper_vatav_fine']    = !empty($arc_records->data->copper_vatav[0]) ? $arc_records->data->copper_vatav[0]->fine : 0;
  // }

  // private function get_rhodium_vatav_balance() {
  //   //get stone vatav balance and balance fine from account ledgers
  //   $accounts_balance_select = '(sum(debit_weight)) as balance, (sum(debit_weight*purity/100)) as balance_fine';
  //   $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Rhodium Vatav'));
  //   $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Rhodium Vatav'));
  //   $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Rhodium Vatav'));

  //   $this->data['accounts_argold_rhodium_vatav'] = $argold_vouchers['balance'];
  //   $this->data['accounts_arf_rhodium_vatav']    = $arf_vouchers['balance'];
  //   $this->data['accounts_arc_rhodium_vatav']    = $arc_vouchers['balance'];

  //   $this->data['accounts_argold_rhodium_vatav_fine'] = $argold_vouchers['balance_fine'];
  //   $this->data['accounts_arf_rhodium_vatav_fine']    = $arf_vouchers['balance_fine'];
  //   $this->data['accounts_arc_rhodium_vatav_fine']    = $arc_vouchers['balance_fine'];

  //   //get gpc vadotar balance and balance fine from factory records
  //   $arg_records = $this->data['arg_vadotar_records'];
  //   $arf_records = $this->data['arf_vadotar_records'];
  //   $arc_records = $this->data['arc_vadotar_records'];
    
  //   $this->data['live_argold_rhodium_vatav'] = !empty($arg_records->data->rhodium_vatav[0]) ? $arg_records->data->rhodium_vatav[0]->weight : 0;
  //   $this->data['live_arf_rhodium_vatav']    = !empty($arf_records->data->rhodium_vatav[0]) ? $arf_records->data->rhodium_vatav[0]->weight : 0;
  //   $this->data['live_arc_rhodium_vatav']    = !empty($arc_records->data->rhodium_vatav[0]) ? $arc_records->data->rhodium_vatav[0]->weight : 0;

  //   $this->data['live_argold_rhodium_vatav_fine'] = !empty($arg_records->data->rhodium_vatav[0]) ? $arg_records->data->rhodium_vatav[0]->fine : 0;
  //   $this->data['live_arf_rhodium_vatav_fine']    = !empty($arf_records->data->rhodium_vatav[0]) ? $arf_records->data->rhodium_vatav[0]->fine : 0;
  //   $this->data['live_arc_rhodium_vatav_fine']    = !empty($arc_records->data->rhodium_vatav[0]) ? $arc_records->data->rhodium_vatav[0]->fine : 0;
  // }

  // private function get_tounch_loss_fine_balance() {
  //   //get alloy vadotar balance and balance fine from account ledgers
  //   $accounts_balance_select = '(sum(debit_weight)) as balance, 
  //                               (sum(debit_weight*purity/100)) as balance_fine';
  //   $argold_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'AR Gold Auto Tounch Loss Fine'));
  //   $arf_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARF Auto Tounch Loss Fine'));
  //   $arc_vouchers = $this->voucher_model->find($accounts_balance_select, array('account_name' => 'ARC Auto Tounch Loss Fine'));

  //   $this->data['accounts_argold_tounch_loss_fine'] = $argold_vouchers['balance'];
  //   $this->data['accounts_arf_tounch_loss_fine']    = $arf_vouchers['balance'];
  //   $this->data['accounts_arc_tounch_loss_fine']    = $arc_vouchers['balance'];

  //   $this->data['accounts_argold_tounch_loss_fine_fine'] = $argold_vouchers['balance_fine'];
  //   $this->data['accounts_arf_tounch_loss_fine_fine']    = $arf_vouchers['balance_fine'];
  //   $this->data['accounts_arc_tounch_loss_fine_fine']    = $arc_vouchers['balance_fine'];

  //   //get alloy vadotar balance and balance fine from factory records
  //   $arg_records = $this->data['arg_vadotar_records'];
  //   $arf_records = $this->data['arf_vadotar_records'];
  //   $arc_records = $this->data['arc_vadotar_records'];
    
  //   $this->data['live_argold_tounch_loss_fine'] = !empty($arg_records->data->tounch_loss_fine[0]) ? $arg_records->data->tounch_loss_fine[0]->weight : 0;
  //   $this->data['live_arf_tounch_loss_fine']    = !empty($arf_records->data->tounch_loss_fine[0]) ? $arf_records->data->tounch_loss_fine[0]->weight : 0;
  //   $this->data['live_arc_tounch_loss_fine']    = !empty($arc_records->data->tounch_loss_fine[0]) ? $arc_records->data->tounch_loss_fine[0]->weight : 0;

  //   $this->data['live_argold_tounch_loss_fine_fine'] = !empty($arg_records->data->tounch_loss_fine[0]) ? $arg_records->data->tounch_loss_fine[0]->fine : 0;
  //   $this->data['live_arf_tounch_loss_fine_fine']    = !empty($arf_records->data->tounch_loss_fine[0]) ? $arf_records->data->tounch_loss_fine[0]->fine : 0;
  //   $this->data['live_arc_tounch_loss_fine_fine']    = !empty($arc_records->data->tounch_loss_fine[0]) ? $arc_records->data->tounch_loss_fine[0]->fine : 0;
  // } 

  private function get_overall_rolling() {  
    $url=API_MAY2022_ARG_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arg_rolling_records=json_decode(curl_post_request($url));
    $this->data['live_argold_rolling_balance'] =!empty($arg_rolling_records->data->balance)?$arg_rolling_records->data->balance:0;
    $this->data['live_argold_rolling_gpc_balance']=!empty($arg_rolling_records->data->gpc_out_balance)? $arg_rolling_records->data->gpc_out_balance:0;
    
    $url=API_MAY2022_ARF_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
    $arf_rolling_records=json_decode(curl_post_request($url));
    $this->data['live_arf_rolling_balance'] =!empty($arf_rolling_records->data->balance)? $arf_rolling_records->data->balance:0;
    $this->data['live_arf_rolling_gpc_balance']=!empty($arf_rolling_records->data->gpc_out_balance)? $arf_rolling_records->data->gpc_out_balance:0;
    
    $url=API_MAY2022_ARC_PATH."stock_summary_reports/overall_rolling_reports/index?overall_rolling=1";
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
    // pd($this->data['purchase_sales_account_domestic_export_records']);

    $this->data['domestic_labour_amount'] = $this->model->find('  IFNULL(sum(debit_amount),0) 
                                                                - IFNULL(sum(credit_amount),0) as amount', 
                                                array_merge($where, array('account_name' => array('Domestic Labour Amount'))), 
                                                array());
    if (empty($this->data['domestic_labour_amount'])) $this->data['domestic_labour_amount'] = array('amount' => 0);

    $loss_account = array('account_name' => 'Loss Account Details',
                          'fine' => 0, 'vadotar' => 0, 'amount' => 0);
    $this->data['loss_account_records'] = array();
    // $loss_account_names = array('AR Gold Alloy Vodator', 'ARF Alloy Vodator', 'ARC Alloy Vodator',
    //                             'AR Gold GPC Vodator', 'ARF GPC Vodator', 'ARC GPC Vodator',
    //                             'AR Gold Stone Vatav', 'ARF Stone Vatav', 'ARC Stone Vatav',
    //                             'AR Gold Copper Vatav', 'ARF Copper Vatav', 'ARC Copper Vatav',
    //                             'AR Gold Rhodium Vatav', 'ARF Rhodium Vatav', 'ARC Rhodium Vatav',
    //                             'HCL LOSS', 'STONE VATAV ARF', 'TOUNCH LOSS FINE ARF', 
    //                             'Tounch & Castic Dep.Loss', 'Tounch Loss Fine', 'Tounch Loss Fine ',
    //                             'MEENA LOSS ARF', 'GPC Powder', 'Gpc Powder ARF', 'Gpc Powder ARC', 'GPC Powder AR Gold', 'SISMA GHISS LOSS',
    //                             'ARG Stone Loss', 'Tounch Loss Fine ARC', 'PASSAGE SEPT', 'ARF GHISS LOSS',
    //                             'BUFFING LOSS', 'GRINDING LOSS', 'TOUNCH LOSS FINE ARF',
    //                             'SHAMPOO AND STEEL VIBRATOR LOSS/WALNUT SHAMPO', 'ARG GHISS LOSS', 'GPC POWDER LOSS ARC',
    //                             'LOSS ACCOUNT', 'Loss Account');
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
    $string = explode('MUMBAI GOLD RTGS  99.50 WITH GST', $gold_rate_response);
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
      $incorrect_vadotar_vouchers = $this->voucher_model->get('receipt_type, site_name, voucher_date, 
                                                               sum(credit_weight) as credit_weight, 
                                                               sum(debit_weight) as debit_weight',
                                         array('receipt_type' => array('Alloy Vodator', 'GPC Vodator', 'Stone Vatav','Meena Vatav', 'Copper Vatav', 'Rhodium Vatav', 'Auto Tounch Loss Fine')),
                                         array(), array('group_by' => 'receipt_type, site_name, voucher_date',
                                                        'having' => 'credit_weight != debit_weight'));

      foreach($incorrect_vadotar_vouchers as $incorrect_vadotar_voucher) {
        $this->voucher_model->delete('', array('receipt_type' => $incorrect_vadotar_voucher['receipt_type'],
                                               'site_name' => $incorrect_vadotar_voucher['site_name'],
                                               'voucher_date' => $incorrect_vadotar_voucher['voucher_date']));
        $this->ledger_model->delete('', array('parent_id not in (select id from ac_vouchers)' => NULL));
      }

      $this->create_update_vadotar_records(API_MAY2022_ARG_PATH, 'AR Gold', 'May 2022');
      $this->create_update_vadotar_records(API_MAY2022_ARF_PATH, 'ARF', 'May 2022');
      $this->create_update_vadotar_records(API_MAY2022_ARC_PATH, 'ARC', 'May 2022');
      $this->create_update_vadotar_records(API_AUG2022_ARG_PATH, 'AR Gold', 'Aug 2022');
      $this->create_update_vadotar_records(API_AUG2022_ARF_PATH, 'ARF', 'Aug 2022');
      $this->create_update_vadotar_records(API_AUG2022_ARC_PATH, 'ARC', 'Aug 2022');

      // $url = API_MAY2022_ARG_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      // $records = json_decode(curl_post_request($url));
      
      // if (!empty($records)) {
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', 'AR Gold', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator', 'AR Gold', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav', 'AR Gold', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->meena_vatav_group_by_date, 'Meena Vatav', 'AR Gold', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->copper_vatav_group_by_date, 'Copper Vatav', 'AR Gold', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->rhodium_vatav_group_by_date, 'Rhodium Vatav', 'AR Gold', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->tounch_loss_fine_group_by_date, 'Auto Tounch Loss Fine', 'AR Gold', 'May 2022');
      // }

      // $url = API_MAY2022_ARF_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      // $records = json_decode(curl_post_request($url));
      
      // if (!empty($records)) {
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', 'ARF', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator', 'ARF', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav', 'ARF', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->meena_vatav_group_by_date, 'Meena Vatav', 'ARF', 'May 2022');
      // $this->metal_receipt_voucher_model->create_vodator_records($records->data->copper_vatav_group_by_date, 'Copper Vatav', 'ARF', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->rhodium_vatav_group_by_date, 'Rhodium Vatav', 'ARF', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->tounch_loss_fine_group_by_date, 'Auto Tounch Loss Fine', 'ARF', 'May 2022');
      // }
      
      // $url = API_MAY2022_ARC_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      // $records = json_decode(curl_post_request($url));
      // if (!empty($records)) {
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', 'ARC', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator',  'ARC', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav',  'ARC', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->meena_vatav_group_by_date, 'Meena Vatav',  'ARC', 'May 2022');
      //  $this->metal_receipt_voucher_model->create_vodator_records($records->data->copper_vatav_group_by_date, 'Copper Vatav',  'ARC', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->rhodium_vatav_group_by_date, 'Rhodium Vatav',  'ARC', 'May 2022');
      //   $this->metal_receipt_voucher_model->create_vodator_records($records->data->tounch_loss_fine_group_by_date, 'Auto Tounch Loss Fine',  'ARC', 'May 2022');
      // }
    }
  }

  private function create_update_vadotar_records($api_path, $site_name, $hostversion) {
    $url = $api_path."issue_and_receipts/alloy_gpc_vodator_ledger/index?group_by_date=1";
    $records = json_decode(curl_post_request($url));
    if (!empty($records)) {
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->alloy_vodator_group_by_date, 'Alloy Vodator', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->gpc_vodator_group_by_date, 'GPC Vodator', $site_name, $hostversion);
      $this->metal_receipt_voucher_model->create_vodator_records($records->data->stone_vatav_group_by_date, 'Stone Vatav', $site_name, $hostversion);
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
}
