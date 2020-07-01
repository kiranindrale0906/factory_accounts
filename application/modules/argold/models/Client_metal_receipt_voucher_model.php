<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/models/Core_metal_receipt_voucher_model.php";
class Client_metal_receipt_voucher_model extends Core_metal_receipt_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
   if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type']!='ARC Finished Goods' || $this->attributes['receipt_type']!='ARF Finished Goods' ) {
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
  public function before_validate() {
    if ($this->attributes['receipt_type'] == "ARC Finished Goods") $this->attributes['account_name'] = 'ARC';
    if ($this->attributes['receipt_type'] == "ARF Finished Goods") $this->attributes['account_name'] = 'ARF';
    
     if (in_array($this->attributes['receipt_type'], array('Metal', 'ARC Finished Goods','ARF Finished Goods'))) {
        $this->formdata['metal_receipt_vouchers']['factory_purity'] = $this->attributes['purity'];
        $this->formdata['metal_receipt_vouchers']['factory_fine'] = $this->attributes['debit_weight']*$this->attributes['purity']/100;
     }
      
    if ($this->attributes['receipt_type'] == "ARC Finished Goods"
        || $this->attributes['receipt_type'] == "ARF Finished Goods") {
      unset($this->formdata['metal_issue_vouchers']);
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $this->attributes['receipt_type'],
                                                            'credit_weight' => $this->attributes['debit_weight'],
                                                            'purity' => $this->attributes['purity'],
                                                            'factory_purity' => $this->attributes['factory_purity']));
    }

    if ($this->attributes['receipt_type'] == "ARC Refresh"
        || $this->attributes['receipt_type'] == "ARF Refresh"
        || $this->attributes['receipt_type'] == 'AR Gold Refresh') {
      unset($this->formdata['metal_issue_vouchers']);
    
    if ($this->attributes['receipt_type'] != 'AR Gold Refresh') {
      $account_name = 'ARC';
      if ($this->attributes['receipt_type'] == 'ARF') $account_name = 'ARF';
        $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $account_name,
                                                              'credit_weight' => $this->attributes['debit_weight'],
                                                              'purity' => $this->attributes['purity'],
                                                              'factory_purity' => $this->attributes['factory_purity']));
      }
    }
    
    if (isset($this->formdata['metal_issue_vouchers'])) {
      foreach ($this->formdata['metal_issue_vouchers'] as $index => $metal_issue_voucher) {
        $this->formdata['metal_issue_vouchers'][$index]['receipt_type'] = $this->attributes['receipt_type'];

        if ($metal_issue_voucher['credit_weight'] == 0 || empty($metal_issue_voucher['credit_weight'])) {
          unset($this->formdata['metal_issue_vouchers'][$index]);
          continue;
        }


        if ($this->attributes['receipt_type'] == 'Metal') 
          $this->formdata['metal_issue_vouchers'][$index]['purity'] = $this->attributes['factory_purity'];
          $this->formdata['metal_issue_vouchers'][$index]['factory_purity'] = $this->attributes['factory_purity'];
          $this->formdata['metal_issue_vouchers'][$index]['factory_fine'] =$metal_issue_voucher['credit_weight']* $this->attributes['factory_purity']/100;
          
      }
    }
  }

  public function before_save($action) {
    $this->attributes['fine'] = $this->attributes['debit_weight'] * $this->attributes['purity'] / 100;
    parent::before_save($action);
  }
  
  public function after_save($action) {
    parent::after_save($action);
    if (ENABLE_API_FOR_RECEIPT)
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

      $metal_issue_data['purity'] = $this->attributes['factory_purity'];
      $metal_issue_data['factory_purity'] = $this->attributes['factory_purity'];
      $metal_issue_data['fine'] =!empty($metal_issue_voucher['credit_weight'])? $metal_issue_voucher['credit_weight'] * $this->attributes['factory_purity'] / 100:0;
      $metal_issue_data['factory_fine'] = $metal_issue_data['fine'];
      $metal_issue_data['narration'] = $this->attributes['narration'];
      $metal_issue_data['suffix'] = "MI";
      $metal_issue_data['voucher_type'] = "metal issue voucher";
      $metal_issue_data['transaction_type'] = 'account';

      $obj_metal_issue_voucher=new metal_issue_voucher_model($metal_issue_data);
      $obj_metal_issue_voucher->store();
    }
    
  }

  private function send_request_to_argold($formdata) {
    $data = $formdata['metal_receipt_vouchers'];
    if ($data['company_id'] != 1) return true;

    $credit_weight = 0;
    if (!empty($formdata['metal_issue_vouchers'])) {
      foreach ($formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
        if(!empty($metal_issue_voucher['credit_weight']))
        $credit_weight += $metal_issue_voucher['credit_weight'];
      }
    }
    $in_weight = $data['debit_weight'] - $credit_weight;
    if ($in_weight == 0) return true;
  
    $api_data = array('account'=> $data['account_name'],
                      'in_weight' => $in_weight,
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
                                               //'quantity' => $data['quantity'],
                                               'process_name'=>'Refresh'));
      $send_data['refresh_departments'] = $api_data;
      $api_url=API_BASE_PATH."api/api_refresh_departments/store";   
    }
    else if($data['receipt_type']=="Daily Drawer") {
      $api_data = array_merge($api_data, array('type'=>$data['dd_type'],
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
}