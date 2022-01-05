<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Loss_report_details extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model'));
  }

  public function index() {
    $this->get_loss_details();
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_loss_details() {
    $this->data['factory_name'] = !empty($_GET['factory_name']) ? $_GET['factory_name'] : '';
    $this->data['department_name'] = $_GET['category'];
    $data['department_name'] = $this->data['department_name'];
    
    $account_data = $this->account_model->find('unrecoverable_account_name', array('name' => $this->data['department_name']));
    $this->data['unrecoverable_account_name'] = !empty($account_data) ? $account_data['unrecoverable_account_name'] : '';
    
    $data['quator']='';
    $data['completed_at']='2021-11-05';
    
    $factory_loss_records = $this->get_loss_records_from_factory($data);
    $ghiss_melting_loss_records = $this->get_ghiss_melting_loss_records($data);
    $loss_detail_records = array_merge($factory_loss_records, $ghiss_melting_loss_records);

    $loss_detail_records = $this->factory_wise_record_array($loss_detail_records);
    
    $this->data['loss_details'] = !empty($loss_detail_records) ? $loss_detail_records : array();
  }

  private function factory_wise_record_array($loss_details){
    if (empty($loss_details)) return array();

    $factory_wise_record = array();
    $unrecovery_loss = $fine_loss = $recovered_loss = $balance=0;

    foreach ($loss_details as $index => $loss_detail) {
      $factory_wise_record[$index]['production'] = 0;
      $loss_account_details = $this->voucher_model->find('sum(debit_weight) as weight,
                                                          factory_purity, sum(fine) as fine',
                                              array('parent_id'=>$loss_detail['parent_id'],
                                                    'account_name!='=>'Unrecovarable'.' '.$this->data['factory_name']));
      
      $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',
                                              array('parent_id'=>$loss_detail['parent_id'],
                                                    'account_name'=>'Unrecovarable'.' '.$this->data['factory_name']));

      $fine_loss = $loss_detail['in_weight'] * $loss_detail['in_lot_purity'] / 100;
      $after_recovered_loss = $loss_account_details['weight'];
      $recovered_loss = $loss_account_details['fine'];
      $unrecovery_loss = !empty($unrecovery_details) ? $unrecovery_details['weight'] : 0;
      $balance = $fine_loss - $recovered_loss - $unrecovery_loss;

      $factory_wise_record[$index] = $loss_detail;
      $factory_wise_record[$index]['loss_fine'] = $fine_loss;
      $factory_wise_record[$index]['after_recovery'] = $after_recovered_loss;
      $factory_wise_record[$index]['recoverd_loss_fine'] = $recovered_loss;
      $factory_wise_record[$index]['unrecoverable_loss'] = $unrecovery_loss;
      $factory_wise_record[$index]['balance'] = $balance;
    }

    return $factory_wise_record;

  }  

  private function get_ghiss_melting_loss_records($data) {
    $ghiss_melting_loss = $this->voucher_model->get('receipt_type, description, site_name,
                                                     credit_weight as in_weight, purity as in_lot_purity,
                                                     argold_id as parent_id, 0 as out_weight,
                                                     created_at, created_at as first_date,
                                                     created_at as last_date, id', 
                                               array('account_name' => 'Loss Account',
                                                     'date(created_at)>=' => '2021-05-11',
                                                     'site_name' => $this->data['factory_name'],
                                                     'receipt_type' => 'Ghiss Melting Loss',
                                                     'description' => $this->data['department_name'],
                                                     'quator' => ''));
    foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
      $data['issue_department_id'] = $ghiss_melting_loss_value['parent_id'];
      $data['quator'] = '';
      
      $ghiss_details = $this->get_loss_records_from_factory($data);

      $out_weight = 0;
      if (   !empty($ghiss_details)
          && !empty($ghiss_details['data']['ghiss_melting_out_weights']))
        $out_weight = $ghiss_details['data']['ghiss_melting_out_weights'];

      $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight'] = $out_weight;
      $ghiss_melting_loss[$ghiss_melting_loss_index]['id'] = $ghiss_melting_loss_value['id'];
    }

    return $ghiss_melting_loss;
  }  

  private function get_loss_records_from_factory($postdata) {
    if ($this->data['factory_name']=='ARC')         $this->data['factory_url'] = API_ARC_PATH;
    elseif ($this->data['factory_name']=='ARF')     $this->data['factory_url'] = API_ARF_PATH;
    elseif ($this->data['factory_name']=='AR Gold') $this->data['factory_url'] = API_ARG_PATH;
    else return array();

    $url = $this->data['factory_url'].'issue_and_receipts/loss_report_for_accounts/index';
    $factory_loss_records =  json_decode(curl_post_request($url, $postdata), true);
    return !empty($factory_loss_records) ? $factory_loss_records['data']['loss_details']['loss_detail'] : array();
  }  
}
