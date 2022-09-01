<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_reports extends BaseController {
  public function __construct() {
    parent::__construct();
     $this->load->model(array('masters/account_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model', 'argold/opening_loss_voucher_model'));
  }

  public function index() {
    $this->data['report_type'] = 'Rojmel Report';
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function _get_form_data() {
    $this->data['site_name']            = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'All';
    $this->data['account_id']           = (!empty($_GET['account_id'])) ? $_GET['account_id'] : 0;
    $this->data['factory_name'] = $this->data['site_name'];
    $this->data['branch'] = !empty($_GET['branch']) ? $_GET['branch'] : '';
    
    
    $this->data['loss_categories'] = array();
    
    $data['department_names'] = $this->get_loss_department_names();
    $data['quator'] = '';
    $data['type'] = 'category';
    $data['completed_at'] = '2021-11-05';
    if (empty($data['department_names'])) return;
    if (!isset($this->data['site_name']) || $this->data['site_name']=='All') return;

    $factory_loss_records = $this->get_loss_records_from_factory($data);
    $ghiss_melting_loss_records = $this->get_ghiss_melting_loss($data);
    $opening_loss_records = $this->get_opening_loss($data);
    $loss_records = array_merge($factory_loss_records, $ghiss_melting_loss_records,$opening_loss_records);

    if (empty($loss_records)) return;    
  
    $category_names = array_map('strtolower', $data['department_names']);
    foreach ($category_names as $category_name_index => $category_name) {
      $total_loss_fine = $recoverd_loss_fine = $unrecovery_loss = $fine_loss = $total_out_weight = 0;
      $recovered_loss = $total_recovery_loss = $total_unrecovery_loss = $after_recovered_loss = 0;
      $total_after_recovered_loss = $total_balance = $balance = 0;

      foreach ($loss_records as $index => $loss_record) {
        if (trim(strtolower($loss_record['description'])) == trim($category_name)) {
          $factory_wise_record[$index]['production']=0;
          
          $recovered_details = $this->voucher_model->find('sum(debit_weight) as weight,
                                                              factory_purity, sum(fine) as fine',
                                              array('parent_id' => $loss_record['parent_id'],
                                                    'account_name!=' => 'Unrecovarable'.' '.$this->data['site_name'],
                                                    'site_name' => $this->data['site_name']));
          
          $unrecovered_details = $this->voucher_model->find('sum(credit_weight) as weight',
                                               array('parent_id' => $loss_record['parent_id'],
                                                     'account_name' => 'Unrecovarable'.' '.$this->data['site_name']));

          $fine_loss = ($loss_record['in_weight'] * $loss_record['in_lot_purity'] / 100);
          $opening_recovered_loss=!empty($loss_record['opening_recovered_loss'])?$loss_record['opening_recovered_loss']:0;
          $recovered_loss = $recovered_details['fine']+$opening_recovered_loss;
          $opening_after_recovery=!empty($loss_record['opening_after_recovery'])?$loss_record['opening_after_recovery']:0;
          $opening_unrecoverable=!empty($loss_record['opening_unrecoverable'])?$loss_record['opening_unrecoverable']:0;
          $after_recovered_loss = $recovered_details['weight']+$opening_after_recovery;

          $unrecovery_loss = !empty($unrecovered_details) ? $unrecovered_details['weight'] : 0;
          $unrecoverable_loss=$unrecovery_loss+$opening_unrecoverable;
          $balance = $fine_loss - $recovered_loss - $unrecoverable_loss;
       
          if (!isset($this->data['loss_categories'][$category_name])) 
            $this->data['loss_categories'][$category_name] = array('loss_fine' => 0,
                                                                   'out_weight' => 0,
                                                                   'recoverd_loss_fine' => 0,
                                                                   'after_recovered_loss' => 0,
                                                                   'unrecoverable_loss' => 0,
                                                                   'balance' => 0);

          $this->data['loss_categories'][$category_name]['out_weight'] += $loss_record['out_weight'];
          $this->data['loss_categories'][$category_name]['loss_fine'] += $fine_loss;
          $this->data['loss_categories'][$category_name]['recoverd_loss_fine'] += $recovered_loss;
          $this->data['loss_categories'][$category_name]['after_recovered_loss'] += $after_recovered_loss;
          $this->data['loss_categories'][$category_name]['unrecoverable_loss'] += $unrecoverable_loss;
          $this->data['loss_categories'][$category_name]['balance'] += $balance;
        }
      }
    }  
  }

  private function get_loss_department_names() {
    $category_names = $this->voucher_model->get('distinct(description) as description', 
                                           array('account_name' => 'Loss Account',
                                                 'date(created_at)>=' => '2021-03-13'));

     $opening_category_names = $this->opening_loss_voucher_model->get('distinct(type_of_loss) as description',array('type_of_loss!=' => '','quator IS NULL'=>NULL));
    $category_names=array_merge($category_names,$opening_category_names);
    return array_column($category_names, 'description');
  }

  private function get_loss_records_from_factory($postdata) {
    if ($this->data['factory_name']=='ARC (May 2022)'){
    $path = API_MAY2022_ARC_PATH;
    }elseif ($this->data['factory_name']=='ARF (May 2022)'){
      $path =API_MAY2022_ARF_PATH;
    }elseif ($this->data['factory_name']=='AR Gold (May 2022)'){
      $path = API_MAY2022_ARG_PATH;
    }elseif ($this->data['factory_name']=='AR Gold (Aug 2022)'){
      $path = API_AUG2022_ARG_PATH;
    }elseif ($this->data['factory_name']=='ARC (Aug 2022)'){
      $path = API_AUG2022_ARC_PATH;
    }elseif ($this->data['factory_name']=='ARF (Aug 2022)'){
      $path = API_AUG2022_ARF_PATH;
    }else {return array();} 

    $url = $path.'issue_and_receipts/loss_report_for_accounts/index';
//	pd($url);
    $factory_loss_records = json_decode(curl_post_request($url, $postdata), true);
    if (!empty($factory_loss_records))
      if (   isset($factory_loss_records['data']['loss_details'])
          && !empty($factory_loss_records['data']['loss_details']['loss_detail']))
        return $factory_loss_records['data']['loss_details']['loss_detail'];
      elseif (isset($factory_loss_records['data']['ghiss_melting_out_weights']))
        return $factory_loss_records['data']['ghiss_melting_out_weights'];
      else
        return array();
    else
      return array();
  }  

  private function get_ghiss_melting_loss($data) {
    $ghiss_melting_loss = $this->voucher_model->get('description, site_name, credit_weight as in_weight, 
                                                     purity as in_lot_purity, argold_id as parent_id,
                                                     0 as out_weight', 
                                                     array('account_name' => 'Loss Account',
                                                           'site_name' => $this->data['site_name'],
                                                           'receipt_type' => 'Ghiss Melting Loss',
                                                           'quator'=> ''));
    foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
      unset($data['department_names']);
      $data['issue_department_id'] = $ghiss_melting_loss_value['parent_id'];
      $data['quator'] = '';

      $ghiss_details = $this->get_loss_records_from_factory($data);

      $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight'] = 0;
      if (!empty($ghiss_details)) 
        $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight'] = $ghiss_details;
    }

    return $ghiss_melting_loss;
  }
  private function get_opening_loss($data) {
    $opening_loss = $this->opening_loss_voucher_model->get('', 
                                                     array('factory_name' => $this->data['site_name'],'quator IS NULL'=>NULL));
    $opening_loss_details=array();
    foreach ($opening_loss as $opening_loss_index => $opening_loss_value) {
      $data['issue_department_id'] = $opening_loss_value['id'];
      $data['quator'] = '';
      $opening_loss_details[$opening_loss_index]['in_weight'] = $opening_loss_value['loss'];
      $opening_loss_details[$opening_loss_index]['in_lot_purity'] = $opening_loss_value['purity'];
      $opening_loss_details[$opening_loss_index]['out_weight'] = $opening_loss_value['out_weight'];
      $opening_loss_details[$opening_loss_index]['description'] = $opening_loss_value['type_of_loss'];
      $opening_loss_details[$opening_loss_index]['opening_after_recovery'] = $opening_loss_value['after_recovered'];
      $opening_loss_details[$opening_loss_index]['opening_recovered_loss'] = $opening_loss_value['recovered_loss'];
      $opening_loss_details[$opening_loss_index]['opening_unrecoverable'] = $opening_loss_value['unrecovered_loss'];
      $opening_loss_details[$opening_loss_index]['parent_id'] = $opening_loss_value['id'];

    }
    return $opening_loss_details;
  }
}
