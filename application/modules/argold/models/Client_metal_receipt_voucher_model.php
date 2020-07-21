<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/models/Core_metal_receipt_voucher_model.php";
class Client_metal_receipt_voucher_model extends Core_metal_receipt_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    if (!empty($this->attributes['receipt_type']) 
        && ($this->attributes['receipt_type'] !='ARC Finished Goods' 
           || $this->attributes['receipt_type'] !='ARF Finished Goods'
           || $this->attributes['receipt_type'] !='AR Gold Finished Goods'
           || $this->attributes['receipt_type'] !='ARF Software Finished Goods')) {
      $rules[] = $this->get_account_validation_rules();
    // $rules[] = $this->get_factory_purity_validation_rules();
    }
    $rules[] = $this->get_receipt_type_validation_rules();

    // if (!empty($this->formdata['metal_issue_vouchers'])) {
    //   foreach ($this->formdata['metal_issue_vouchers'] as $index => $metal_issue_voucher) {
    //     $rules[] = $this->get_metal_issue_factory_purity_validation_rules('metal_issue_vouchers',$index);
    //   }
    // }

    return $rules;
  }

  private function set_account_name_from_receipt_type() {
    if ($this->attributes['receipt_type'] == "AR Gold Finished Goods")      $this->attributes['account_name'] = 'AR Gold';
    if ($this->attributes['receipt_type'] == "ARF Finished Goods")          $this->attributes['account_name'] = 'ARF';
    if ($this->attributes['receipt_type'] == "ARF Software Finished Goods") $this->attributes['account_name'] = 'ARF Software';
    if ($this->attributes['receipt_type'] == "ARC Finished Goods")          $this->attributes['account_name'] = 'ARC';
    if ($this->attributes['receipt_type'] == "Vadotar")                     $this->attributes['account_name'] = 'Main Vadotar';
  }

  private function set_metal_receipt_attributes_from_receipt_type_for_vadotar() {
    if ($this->attributes['receipt_type'] == 'Vadotar') {
      $this->attributes['purity'] = 100;
      $this->attributes['factory_purity'] = 100;
      $this->attributes['narration'] = 'Vadotar internal transfer';
      $last_vodotar_voucher = $this->find('created_at', array('receipt_type' => 'Vadotar'), array(), array('order_by' => 'id desc'));
      if (empty($last_vodotar_voucher['created_at'])) $last_vodotar_voucher['created_at'] = '2019-04-01';
      $total_vadotar = $this->find('sum(debit_weight * (purity - factory_purity) / 100) + sum(credit_weight * (purity - factory_purity) / 100) as vadotar',
                                   array('created_at >= ' => $last_vodotar_voucher['created_at'],
                                         'receipt_type != ' => 'Vadotar',
                                         'account_name != ' => 'Tounch Loss Fine'));
      $this->attributes['debit_weight'] = empty($total_vadotar['vadotar']) ? 0 : -1 * $total_vadotar['vadotar'];    

      if ($this->attributes['debit_weight'] == 0) {
        die();   //this needs to be converted into a validation
      }
    }
  }

  private function set_factory_purity_from_receipt_type_for_metal_and_finihed_goods() {
    if (in_array($this->attributes['receipt_type'], array('Metal', 
                                                          'AR Gold Finished Goods', 
                                                          'ARF Finished Goods', 'ARF Software Finished Goods',
                                                          'ARC Finished Goods'))) {
      $this->formdata['metal_receipt_vouchers']['factory_purity'] = $this->attributes['purity'];
    }
  }

  private function set_metal_receipt_attributes() {
    $this->formdata['metal_receipt_vouchers']['factory_fine'] = $this->attributes['debit_weight']*$this->attributes['purity']/100;
  }

  private function set_metal_issue_voucher_attributes_from_receipt_type_for_finished_goods() {
    if ($this->attributes['receipt_type'] == "AR Gold Finished Goods"
        || $this->attributes['receipt_type'] == "ARF Finished Goods"
        || $this->attributes['receipt_type'] == "ARF Software Finished Goods"
        || $this->attributes['receipt_type'] == "ARC Finished Goods") {
      unset($this->formdata['metal_issue_vouchers']);
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $this->attributes['receipt_type'],
                                                            'credit_weight' => $this->attributes['debit_weight'],
                                                            'purity' => $this->attributes['purity'],
                                                            'factory_purity' => $this->attributes['purity']));
    }
  }
  
  private function set_metal_issue_voucher_attributes_from_receipt_type_for_refresh() {
    if ($this->attributes['receipt_type'] == 'AR Gold Refresh'
        || $this->attributes['receipt_type'] == "ARF Refresh"
        || $this->attributes['receipt_type'] == "ARC Refresh") {
      unset($this->formdata['metal_issue_vouchers']);
      
      if ($this->attributes['receipt_type'] == "AR Gold Refresh") return;

      if ($this->attributes['receipt_type'] == 'ARF Refresh') $account_name = 'ARF';
      if ($this->attributes['receipt_type'] == 'ARC Refresh') $account_name = 'ARC';
      
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $account_name,
                                                            'credit_weight' => $this->attributes['debit_weight'],
                                                            'purity' => $this->attributes['purity'],
                                                            'factory_purity' => $this->attributes['factory_purity']));
    }
  }

  private function set_metal_issue_voucher_attributes_from_receipt_type_for_metal() {
    if (isset($this->formdata['metal_issue_vouchers'])) {
      foreach ($this->formdata['metal_issue_vouchers'] as $index => $metal_issue_voucher) {
        if ($this->attributes['receipt_type'] == 'Metal') {
          $this->formdata['metal_issue_vouchers'][$index]['purity'] = $this->attributes['purity'];
          $this->formdata['metal_issue_vouchers'][$index]['factory_purity'] = $this->attributes['purity'];
          $this->formdata['metal_issue_vouchers'][$index]['factory_fine'] =$metal_issue_voucher['credit_weight']* $this->attributes['purity']/100;
        }
      }
    }
  }

  private function set_metal_issue_voucher_attributes_for_alloy_vadotar_and_gpc_vadotar() {
    if (($this->attributes['account_name'] == "Alloy Vodator" && $this->attributes['narration'] == "ARF Alloy Vodator")
         || ($this->attributes['account_name'] == "GPC Vodator" && $this->attributes['narration'] == "ARF GPC Vodator"))  {
      unset($this->formdata['metal_issue_vouchers']);
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => 'ARF Software',
                                                            'credit_weight' => $this->attributes['debit_weight'],
                                                            'purity' => $this->attributes['purity'],
                                                            'factory_purity' => $this->attributes['factory_purity']));
      // $metal_issue_voucher = $this->find('',array('receipt_type' => $this->attributes['receipt_type'],
      //                                             'account_name' => 'ARF Software',
      //                                             'narration' => $this->attributes['narration'],
      //                                             'voucher_date' => $this->attributes['voucher_date']));
    }
  }

  private function set_metal_issue_voucher_attributes_from_receipt_type_for_vadotar() {
    if ($this->attributes['receipt_type'] == "Vadotar") {
      unset($this->formdata['metal_issue_vouchers']);
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => 'VADOTAR',
                                                            'credit_weight' => $this->attributes['debit_weight'],
                                                            'purity' => $this->attributes['purity'],
                                                            'fine' => $this->attributes['debit_weight'] * $this->attributes['purity'] / 100,
                                                            'factory_fine' => 0,
                                                            'factory_purity' => 0),
                                                    );
    }
  }

  private function set_receipt_type_for_all_metal_issue_vouchers() {
    if (isset($this->formdata['metal_issue_vouchers'])) {
      foreach ($this->formdata['metal_issue_vouchers'] as $index => $metal_issue_voucher) {
        $this->formdata['metal_issue_vouchers'][$index]['receipt_type'] = $this->attributes['receipt_type'];
      }
    }
  }

  private function unset_metal_issue_voucher_records_when_credit_weight_is_0() {
    if (isset($this->formdata['metal_issue_vouchers'])) {
      foreach ($this->formdata['metal_issue_vouchers'] as $index => $metal_issue_voucher) {
        if ($metal_issue_voucher['credit_weight'] == 0 || empty($metal_issue_voucher['credit_weight'])) 
          unset($this->formdata['metal_issue_vouchers'][$index]);
      }
    }
  }

  public function before_validate() {
    $this->set_account_name_from_receipt_type();
    $this->set_factory_purity_from_receipt_type_for_metal_and_finihed_goods();
    $this->set_metal_receipt_attributes_from_receipt_type_for_vadotar();
    $this->set_metal_receipt_attributes();

    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_finished_goods();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_refresh();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_metal();
    $this->set_metal_issue_voucher_attributes_for_alloy_vadotar_and_gpc_vadotar();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_vadotar(); 

    $this->set_receipt_type_for_all_metal_issue_vouchers();
    $this->unset_metal_issue_voucher_records_when_credit_weight_is_0(); 
  }

  public function before_save($action) {
    $this->attributes['fine'] = $this->attributes['debit_weight'] * $this->attributes['purity'] / 100;
    parent::before_save($action);
  }
  
  public function after_save($action) {
    parent::after_save($action);
    if (ENABLE_API_FOR_RECEIPT && $this->attributes['receipt_type'] != 'Internal')
      $this->send_request_to_argold($this->formdata);
    $this->create_metal_issue_vouchers();
  }

  private function create_metal_issue_vouchers() {
    $this->load->model('transactions/metal_issue_voucher_model');
    if(empty($this->formdata['metal_issue_vouchers'])) return true;

    foreach ($this->formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
      $metal_issue_data = array();
      $metal_issue_data=$metal_issue_voucher;

      $metal_issue_data['company_id']  = $this->attributes['company_id'];
      $metal_issue_data['metal_receipt_voucher_reference_id'] = $this->attributes['id'];
      $metal_issue_data['voucher_date'] = $this->attributes['voucher_date'];
      $metal_issue_data['account_id'] = $this->attributes['account_id'];

      if ($this->attributes['receipt_type'] != 'Vadotar') {
        $metal_issue_data['purity'] = $this->attributes['factory_purity'];
        $metal_issue_data['factory_purity'] = $this->attributes['factory_purity'];
        $metal_issue_data['fine'] =!empty($metal_issue_voucher['credit_weight'])? $metal_issue_voucher['credit_weight'] * $this->attributes['factory_purity'] / 100 : 0;
        $metal_issue_data['factory_fine'] = $metal_issue_data['fine'];
      }
      
      $metal_issue_data['narration'] = $this->attributes['narration'];
      $metal_issue_data['suffix'] = "MI";
      $metal_issue_data['voucher_type'] = "metal issue voucher";
      $metal_issue_data['transaction_type'] = 'account';
      $obj_metal_issue_voucher=new metal_issue_voucher_model($metal_issue_data);
      $obj_metal_issue_voucher->save();
    }
    
  }

  private function send_request_to_argold($formdata) {
    $data = $formdata['metal_receipt_vouchers'];
    if ($data['company_id'] != 1) return true;
    if ($data['account_name'] == 'Alloy Vodator' || $data['account_name'] == 'GPC Vodator') return true;

    $credit_weight = 0;
    if (!empty($formdata['metal_issue_vouchers'])) {
      foreach ($formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
        if(!empty($metal_issue_voucher['credit_weight']))
        $credit_weight += $metal_issue_voucher['credit_weight'];
      }
    }
    $in_weight = $data['debit_weight'] - $credit_weight;
    if ($in_weight == 0 && $data['receipt_type'] != "ARF Refresh") return true;
    
    $api_data = array('account'=> $data['account_name'].' (accounts)',
                      'in_weight' => ($data['receipt_type'] != "ARF Refresh") ? $in_weight : $data['debit_weight'],
                      'in_lot_purity' => @$data['factory_purity'],
                      'description' =>$data['narration'],
                      'argold_account_id'=>$data['id']);
    $send_data=array();

    if ($data['receipt_type'] == "Metal") {
      $api_data = array_merge($api_data, array('type' => 'Pure',
                                               'process_name' => 'Receipt'));
      $send_data['receipt_departments'] = $api_data;
      $api_url=API_BASE_PATH."api/api_receipt_departments/store";   
    } else if($data['receipt_type'] == "AR Gold Refresh") {
      $api_data = array_merge($api_data, array('type'=>'Pure',
                                               'hook_kdm_purity' => $data['factory_purity'],
                                               'process_name'=>'Refresh'));
      $send_data['refresh_departments'] = $api_data;
      $api_url=API_BASE_PATH."api/api_refresh_departments/store";   
    // } else if($data['receipt_type'] == "ARF Refresh") {
    //   $api_data = array_merge($api_data, array('type'=>'Pure',
    //                                            'quantity' => 1,
    //                                            'hook_kdm_purity' => $data['factory_purity'],
    //                                            'process_name'=>'Refresh'));
    //   $send_data['refresh_departments'] = $api_data;
    //   $api_url=ARF_API_BASE_PATH."api/api_refresh_departments/store";   
    } else if($data['receipt_type']=="Daily Drawer") {
      $api_data = array_merge($api_data, array('type'=>$data['dd_type'],
                                               'balance' => $in_weight,
                                               'karigar'=> 'Factory'));
      $send_data['daily_drawer_receipts'] = $api_data;
      $api_url=API_BASE_PATH."api/api_daily_drawer_receipts/store";   
    }
    if (empty($api_url)) return true;

    $result = curl_post_request($api_url, $send_data);
    if(empty($result) || (!empty($result['status']) && $result['status']=="error")) {
      $api_data = array_merge($api_data, array('api_url'=>$api_url));
      $obj_receipt_not_sent = new Receipt_not_sent_argold_model($api_data);
      $obj_receipt_not_sent->store(false);
    }
  }

  public function send_request_to_arf($attributes) {
    if ($attributes['credit_weight'] == 0) return true;
  
    $api_data = array('account'=> $attributes['account_name'].' (accounts)',
                      'in_weight' => $attributes['credit_weight'],
                      'in_lot_purity' => $attributes['factory_purity'],
                      'description' => $attributes['narration'],
                      'argold_account_id' => $attributes['id']);
    $send_data=array();

    if ($attributes['receipt_type'] == "Metal") {
      $api_data = array_merge($api_data, array('type' => 'Pure',
                                               'process_name' => 'Receipt'));
      $send_data['receipt_departments'] = $api_data;
      $api_url=ARF_API_BASE_PATH."api/api_receipt_departments/store";   
    }

    if (empty($api_url)) return true;

    $result = curl_post_request($api_url, $send_data);
    if(empty($result) || (!empty($result['status']) && $result['status']=="error")) {
      $api_data = array_merge($api_data, array('api_url'=>$api_url));
      $obj_receipt_not_sent = new Receipt_not_sent_argold_model($api_data);
      $obj_receipt_not_sent->store(false);
    }
  }

  public function create_vodator_records($records, $type, $from, $start_date='2020-07-04') {
    if (empty($records)) return true;
    $records = json_decode(json_encode($records), true);
    foreach ($records as $index => $record) {
      $start_date_timestamp = strtotime($start_date);
      $voucher_date_timestamp = strtotime($record['created_date']);
      
      if ($start_date_timestamp > $voucher_date_timestamp) continue;
      $metal_receipt_voucher = $this->find('',array('receipt_type' => $type.' Vodator',
                                                    'account_name' => $type.' Vodator',
                                                    'narration' => $from.' '.$type.' Vodator',
                                                    'voucher_date' => $record['created_date']));
      $data=array('company_id' => 1,
                  'voucher_date' => $record['created_date'],
                  'receipt_type' => $type.' Vodator',
                  'account_name' => $type.' Vodator',
                  'debit_weight' => $record['weight'],
                  'purity' => $record['purity'],
                  'factory_purity' => $record['purity'],
                  'fine' => $record['fine'],
                  'factory_fine' => $record['fine'],
                  'narration' => $from.' '.$type.' Vodator');
      $data['id'] = '';
      if (!empty($metal_receipt_voucher)) $data['id'] = $metal_receipt_voucher['id'];
        
      if(empty($metal_receipt_voucher['debit_weight'])
         || ($metal_receipt_voucher['debit_weight'] != $record['weight'])) {
        $metal_issue_obj = new metal_receipt_voucher_model($data);
        $metal_issue_obj->before_validate();
        $metal_issue_obj->save();
      } 
    }
  }

}