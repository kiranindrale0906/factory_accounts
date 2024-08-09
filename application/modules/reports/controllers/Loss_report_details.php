<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Loss_report_details extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model', 'argold/opening_loss_voucher_model'));
  }

  public function index() {
    $this->get_loss_details();
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_loss_details() {
    $this->data['factory_name'] = !empty($_GET['factory_name']) ? $_GET['factory_name'] : '';
    $this->data['branch'] = !empty($_GET['branch']) ? $_GET['branch'] : '';
    $this->data['department_name'] = $_GET['category'];
    $data['department_name'] = $this->data['department_name'];
    $account_data = $this->account_model->find('unrecoverable_account_name', array('name' => $this->data['department_name']));
    $this->data['unrecoverable_account_name'] = !empty($account_data) ? $account_data['unrecoverable_account_name'] : '';
    
    $data['quator']='';
    $data['completed_at']='2021-11-05';
    
    $factory_loss_records = $this->get_loss_records_from_factory($data);
    $ghiss_melting_loss_records = $this->get_ghiss_melting_loss_records($data);
    $fire_tounch_loss_records = $this->get_fire_tounch_loss_records($data);
    $opening_loss_records = $this->get_opening_loss($data);
    $loss_detail_records = array_merge($factory_loss_records, $ghiss_melting_loss_records,$fire_tounch_loss_records,$opening_loss_records);

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
                                                    'site_name' => $this->data['factory_name'],
                                                    'account_name!='=>'Unrecovarable'.' '.$this->data['factory_name']));
      
      $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',
                                              array('parent_id'=>$loss_detail['parent_id'],
                                                    'account_name'=>'Unrecovarable'.' '.$this->data['factory_name']));

      $fine_loss = $loss_detail['in_weight'] * $loss_detail['in_lot_purity'] / 100;
      $opening_after_recovery=!empty($loss_detail['opening_after_recovery'])?$loss_detail['opening_after_recovery']:0;
      $opening_recovery_fine=!empty($loss_detail['opening_recovery_fine'])?$loss_detail['opening_recovery_fine']:0;
      $opening_unrecoverable=!empty($loss_detail['opening_unrecoverable'])?$loss_detail['opening_unrecoverable']:0;
      $after_recovered_loss = $loss_account_details['weight']+$opening_after_recovery;
      $recovered_loss = $loss_account_details['fine']+$opening_recovery_fine;
      $unrecovery_loss = !empty($unrecovery_details) ? $unrecovery_details['weight'] : 0;
      $unrecoverable_loss=$unrecovery_loss+$opening_unrecoverable;
      $balance = $fine_loss - $recovered_loss - $unrecoverable_loss;

      $factory_wise_record[$index] = $loss_detail;
      $factory_wise_record[$index]['loss_fine'] = $fine_loss;
      $factory_wise_record[$index]['after_recovery'] = $after_recovered_loss;
      $factory_wise_record[$index]['recoverd_loss_fine'] = $recovered_loss;
      $factory_wise_record[$index]['unrecoverable_loss'] = $unrecoverable_loss;
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
                                               array('account_name' => get_loss_account_name_from_site_name($this->data['factory_name']),
                                                     'date(created_at)>=' => '2021-05-11',
                                                     'site_name' => $this->data['factory_name'],
                                                     'receipt_type' => 'Ghiss Melting Loss',
                                                     'description' => $this->data['department_name'],
                                                     'quator =""' =>NULL));
    /*foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
      $data['issue_department_id'] = $ghiss_melting_loss_value['parent_id'];
      $data['quator'] = '';
      
      $ghiss_details = $this->get_loss_records_from_factory($data);

      $out_weight = 0;
      if (!empty($ghiss_details))
        $out_weight = $ghiss_details;

      $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight'] = $out_weight;
      $ghiss_melting_loss[$ghiss_melting_loss_index]['id'] = $ghiss_melting_loss_value['id'];
    }*/
    $department_ids = array_column($ghiss_melting_loss, 'parent_id');
    $url = API_APR2024_ARC_PATH . "issue_and_receipts/loss_report_for_accounts/index";
    $data['issue_department_ids'] = $department_ids;
    $data['quator'] = $this->data['quator_name'];
    $details = json_decode(curl_post_request($url, $data), true);
    $weights = !empty($details['data']['ghiss_melting_out_weights']) ? $details['data']['ghiss_melting_out_weights'] : [];

    // Map out_weights to ghiss_melting_loss
    foreach ($ghiss_melting_loss as $index => $value) {
        $department_id = $value['parent_id'];
        $ghiss_melting_loss[$index]['out_weight'] = isset($weights[$department_id]) ? $weights[$department_id] : 0;
        $ghiss_melting_loss[$index]['id'] = $value['id'];
    } 
    return $ghiss_melting_loss;
  }  
private function get_fire_tounch_loss_records($data) {
    

    $fire_tounch_loss = $this->voucher_model->get('receipt_type, description, site_name,
                                                     credit_weight as in_weight, purity as in_lot_purity,
                                                     argold_id as parent_id, 0 as out_weight,
                                                     created_at, created_at as first_date,
                                                     created_at as last_date, id', 
                                               array('account_name' => get_loss_account_name_from_site_name($this->data['factory_name']),
                                                     'date(created_at)>=' => '2021-05-11',
                                                     'site_name' => $this->data['factory_name'],
                                                     'receipt_type' => 'Fire Tounch Loss',
                                                     'description' => $this->data['department_name'],
                                                     'quator' => ''));
    /*foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
      $data['issue_department_id'] = $fire_tounch_loss_value['parent_id'];
      $data['quator'] = '';
      
      $fire_tounch_details = $this->get_loss_records_from_factory($data);

      $out_weight = 0;
      if (!empty($fire_tounch_details))
        $out_weight = $fire_tounch_details;

      $fire_tounch_loss[$fire_tounch_loss_index]['out_weight'] = $out_weight;
      $fire_tounch_loss[$fire_tounch_loss_index]['id'] = $fire_tounch_loss_value['id'];
    }*/
    $fire_tounch_loss_department_ids = array_column($fire_tounch_loss, 'parent_id');
    $url = API_APR2024_ARC_PATH . "issue_and_receipts/loss_report_for_accounts/index";
    $data['issue_department_id'] = $fire_tounch_loss_department_ids;
    $data['quator'] = $this->data['quator_name'];
    $details = json_decode(curl_post_request($url, $data), true);
    $fire_tounch_loss_weights = !empty($details['data']['fire_tounch_out_weights']) ? $details['data']['fire_tounch_out_weights'] : [];

    // Map out_weights to ghiss_melting_loss
    foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
        $department_id = $fire_tounch_loss_value['parent_id'];
        $fire_tounch_loss[$fire_tounch_loss_index]['out_weight'] = isset($fire_tounch_loss_weights[$department_id]) ? $fire_tounch_loss_weights[$department_id] : 0;
        $fire_tounch_loss[$fire_tounch_loss_index]['id'] = $fire_tounch_loss_value['id'];
    }
    return $fire_tounch_loss;
  }  

  private function get_loss_records_from_factory($postdata) { 
    // if ($this->data['factory_name']=='ARC (May 2022)'){
    // $this->data['factory_url'] = API_MAY2022_ARC_PATH;
    // }elseif ($this->data['factory_name']=='ARF (May 2022)'){
    //   $this->data['factory_url'] =API_MAY2022_ARF_PATH;
    // }elseif ($this->data['factory_name']=='AR Gold (May 2022)'){
    //   $this->data['factory_url'] = API_MAY2022_ARG_PATH;
    // }elseif ($this->data['factory_name']=='AR Gold (Aug 2022)'){
    //   $this->data['factory_url'] = API_AUG2022_ARG_PATH;
    // }elseif ($this->data['factory_name']=='ARC (Aug 2022)'){
    //   $this->data['factory_url'] = API_AUG2022_ARC_PATH;
    // }elseif ($this->data['factory_name']=='ARF (Aug 2022)'){
    //   $this->data['factory_url'] = API_AUG2022_ARF_PATH;
    // }else {return array();} 
    $this->data['factory_url'] = get_api_url_from_site_name($this->data['factory_name']);

    $url = $this->data['factory_url'].'issue_and_receipts/loss_report_for_accounts/index';
    $factory_loss_records =  json_decode(curl_post_request($url, $postdata), true);
    if (!empty($factory_loss_records))
      if (   isset($factory_loss_records['data']['loss_details'])
          && !empty($factory_loss_records['data']['loss_details']['loss_detail']))
        return $factory_loss_records['data']['loss_details']['loss_detail'];
      elseif (isset($factory_loss_records['data']['ghiss_melting_out_weights']))
        return $factory_loss_records['data']['ghiss_melting_out_weights'];
      elseif (isset($factory_loss_records['data']['fire_tounch_out_weights']))
        return $factory_loss_records['data']['fire_tounch_out_weights'];
      else
        return array();
    else
      return array();
  }  
  private function get_opening_loss($data) {
    $opening_loss = $this->opening_loss_voucher_model->get('', 
                                                     array('factory_name' => $this->data['factory_name'],'quator IS NULL'=>NULL,'type_of_loss' => $this->data['department_name']));
    $opening_loss_details=array();
    foreach ($opening_loss as $opening_loss_index => $opening_loss_value) {
      $data['issue_department_id'] = $opening_loss_value['id'];
      $data['quator'] = '';
      $opening_loss_details[$opening_loss_index]['in_weight'] = $opening_loss_value['loss'];
      $opening_loss_details[$opening_loss_index]['in_lot_purity'] = $opening_loss_value['purity'];
      $opening_loss_details[$opening_loss_index]['out_weight'] = $opening_loss_value['out_weight'];
      $opening_loss_details[$opening_loss_index]['description'] = $opening_loss_value['type_of_loss'];
      $opening_loss_details[$opening_loss_index]['parent_id'] = $opening_loss_value['id'];
      $opening_loss_details[$opening_loss_index]['id'] = $opening_loss_value['id'];
      $opening_loss_details[$opening_loss_index]['created_at'] = $opening_loss_value['created_at'];
      $opening_loss_details[$opening_loss_index]['first_date'] = $opening_loss_value['created_at'];
      $opening_loss_details[$opening_loss_index]['last_date'] = $opening_loss_value['created_at'];
      $opening_loss_details[$opening_loss_index]['receipt_type'] = "Opening Loss";
      $opening_loss_details[$opening_loss_index]['opening_after_recovery'] = $opening_loss_value['after_recovered'];
      $opening_loss_details[$opening_loss_index]['opening_unrecoverable'] = $opening_loss_value['unrecovered_loss'];
      $opening_loss_details[$opening_loss_index]['opening_recovery_fine'] = $opening_loss_value['recovered_loss'];
      
      $opening_loss_details[$opening_loss_index]['quator'] = $opening_loss_value['quator'];

    }
    return $opening_loss_details;
  }
}
