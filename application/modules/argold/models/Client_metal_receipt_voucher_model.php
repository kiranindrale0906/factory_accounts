<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Core_metal_receipt_voucher_model.php";
class Client_metal_receipt_voucher_model extends Core_metal_receipt_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/rate_cut_issue_voucher_model'));
  }

  public function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    if (!empty($this->attributes['receipt_type']) 
        && (  $this->attributes['receipt_type'] != 'ARC Finished Goods' 
           || $this->attributes['receipt_type'] != 'ARF Finished Goods'
           || $this->attributes['receipt_type'] != 'AR Gold Finished Goods'
           || $this->attributes['receipt_type'] != 'ARF Software Finished Goods')) {
      $rules[] = $this->get_account_validation_rules();
    }

    if (in_array($this->attributes['receipt_type'], array('AR Gold Finished Goods Receipt',
                                                          'ARF Finished Goods Receipt',
                                                          'ARC Finished Goods Receipt'))) {
      $rules[] = $this->get_narration_validation_rules();
    }

    // if ($this->attributes['receipt_type'] == 'AR Gold Refresh'
    //     || $this->attributes['receipt_type'] == 'ARF Refresh'
    //     || $this->attributes['receipt_type'] == 'ARC Refresh')
    if ($this->attributes['receipt_type'] == 'Refresh')  
      $rules[] = $this->get_sale_type_validation_rules();

    //$rules[] = $this->get_site_name_validation_rules();
  
    $rules[] = $this->get_receipt_type_validation_rules();
    $rules[] = $this->get_factory_purity_validation_rules();
    return $rules;
  }


  public function before_validate() {
    $this->set_account_name_from_receipt_type();
    $this->set_site_name_from_receipt_type();
    $this->set_sale_type_from_receipt_type_for_metal();
    $this->set_factory_purity_from_receipt_type_for_metal_and_finished_goods_and_chain_receipt();
    $this->set_metal_receipt_attributes_from_receipt_type_for_vadotar();
    $this->set_metal_receipt_attributes();
    if(!empty($this->attributes['site_name'])&&($this->attributes['site_name']=="AR Gold ERP" || $this->attributes['site_name']=="ARF ERP" ||$this->attributes['site_name']=="RND ERP" || $this->attributes['site_name']=="ARC ERP" || $this->attributes['site_name']=="Domestic Internal ERP" || $this->attributes['site_name']=="ARNA BANGLE ERP") && $this->attributes['receipt_type'] == 'Metal'){
    	$this->formdata['metal_issue_vouchers'][0]=$this->attributes;
    	$this->formdata['metal_issue_vouchers'][0]['account_name']=$this->attributes['customer_name'];
    	$this->formdata['metal_issue_vouchers'][0]['credit_weight']=$this->attributes['debit_weight'];
    }
    $this->set_metal_issue_voucher_attributes_from_argold_software_metal_receipt_and_refresh();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_chain_receipt();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_stone();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_metal_and_chain_receipt();
    $this->set_id_for_alloy_vodator_gpc_vodator_and_stone_vatav();
    $this->set_metal_issue_voucher_attributes_for_alloy_vadotar_and_gpc_vadotar();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_vadotar(); 
    
    $this->set_receipt_type_for_all_metal_issue_vouchers();
    $this->set_gold_rate_purity();
    $this->unset_metal_issue_voucher_records_when_credit_weight_is_0(); 
      //pd($this->formdata);
}

  private function set_gold_rate_purity() {
    if (   !isset($this->attributes['gold_rate_purity'])
        || $this->attributes['gold_rate_purity'] > 0)  $this->attributes['gold_rate_purity'] = 100;
  }

  private function set_site_name_from_receipt_type() {
    if (!empty($this->attributes['receipt_type']) && ($this->attributes['receipt_type'] == 'Refresh'|| $this->attributes['receipt_type'] == 'Daily Drawer') ){
      foreach ($this->formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
        $this->attributes['site_name'] = get_site_name_from_account_name($metal_issue_voucher['account_name']);
        break;
      }
    } else {
      $site_name = get_site_name_from_account_name($this->attributes['account_name']);
      if (!empty($site_name)) $this->attributes['site_name'] = $site_name;
    }
  }

  private function set_sale_type_from_receipt_type_for_metal() {
    if ($this->attributes['receipt_type'] == 'Metal' && empty($this->attributes['parent_id'])) @$this->attributes['sale_type'] == 'Sale';
  }

  private function set_account_name_from_receipt_type() {
    if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "AR Gold Finished Goods")  $this->attributes['account_name'] = 'AR Gold';
     if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "Export Internal")        $this->attributes['account_name'] = 'Export Internal Software';
     if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "Domestic Internal")      $this->attributes['account_name'] = 'Domestic Internal Software';
    if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "QC Out")                 $this->attributes['account_name'] = 'Domestic Internal Software';
     if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "Packing Slip")           $this->attributes['account_name'] = 'Export Internal Software';
    if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "ARF Finished Goods")          $this->attributes['account_name'] = 'ARF';
    if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "ARC Finished Goods")          $this->attributes['account_name'] = 'ARC';
    if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "ARF Software Finished Goods") $this->attributes['account_name'] = 'ARF Software';
    if (!empty($this->attributes['receipt_type']) && $this->attributes['receipt_type'] == "Vadotar")                     $this->attributes['account_name'] = 'MAIN VADOTAR';
  }

  private function set_metal_receipt_attributes_from_receipt_type_for_vadotar() {
    if ($this->attributes['receipt_type'] == 'Vadotar') {
      $this->attributes['purity'] = 100;
      $this->attributes['factory_purity'] = 100;
      $this->attributes['narration'] = 'Vadotar internal transfer';
      // $last_vodotar_voucher = $this->find('created_at', array('receipt_type' => 'Vadotar'), array(), array('order_by' => 'id desc'));
      // if (empty($last_vodotar_voucher['created_at'])) $last_vodotar_voucher['created_at'] = '2019-04-01';
      // $total_vadotar = $this->find('sum(debit_weight * (purity - factory_purity) / 100) + sum(credit_weight * (purity - factory_purity) / 100) as vadotar',
      //                              array('created_at >= ' => $last_vodotar_voucher['created_at'],
      //                                    'receipt_type != ' => 'Vadotar',
      //                                    'account_name != ' => 'Tounch Loss Fine'));

      $total_vadotar = $this->find('  sum(debit_weight * (purity - factory_purity) / 100) 
                                    + sum(credit_weight * (purity - factory_purity) / 100) as vadotar',
                                   array('account_name != ' => 'Tounch Loss Fine'));

      $this->attributes['debit_weight'] = empty($total_vadotar['vadotar']) ? 0 : -1 * $total_vadotar['vadotar'];    
      if ($this->attributes['debit_weight'] == 0) {
        die();   //this needs to be converted into a validation
      }
    }
  }

  private function set_factory_purity_from_receipt_type_for_metal_and_finished_goods_and_chain_receipt() {
    if (in_array($this->attributes['receipt_type'], array('Metal', 
                                                          'Rhodium', 
                                                          'AR Gold Finished Goods', 'AR Gold Chain Receipt', 'AR Gold Finished Goods Receipt', 'AR Gold RND','Export Internal','Domestic Internal','Packing Slip','QC Out',
                                                          'ARF Finished Goods', 'ARF Software Finished Goods', 'ARF Chain Receipt', 'ARF Finished Goods Receipt', 'ARF RND',
                                                          'ARC Finished Goods', 'ARC Chain Receipt', 'ARC Finished Goods Receipt', 'ARC RND'))) {
      $this->formdata['metal_receipt_vouchers']['factory_purity'] = $this->attributes['purity'];
    }
  }

  private function set_metal_receipt_attributes() {
    if (empty($this->attributes['purity']))
      $this->formdata['metal_receipt_vouchers']['factory_fine'] = 0;
    else
      $this->formdata['metal_receipt_vouchers']['factory_fine'] = $this->attributes['debit_weight'] * $this->attributes['purity']/100;
  }

  private function set_metal_issue_voucher_attributes_from_argold_software_metal_receipt_and_refresh() {
    if (   $this->attributes['receipt_type'] == 'Metal'
        || $this->attributes['receipt_type'] == 'Daily Drawer'
        || $this->attributes['receipt_type'] == 'Refresh') {
      $credit_weight = 0;

      $this->attributes['dd_type'] = !empty($this->attributes['dd_type']) ? $this->attributes['dd_type'] : '';
      if (!empty($this->formdata['metal_issue_vouchers'])) {
        foreach ($this->formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
          if(!empty($metal_issue_voucher['credit_weight']))
          $credit_weight += $metal_issue_voucher['credit_weight'];
        }
      }
      $in_weight = $this->attributes['debit_weight'] - $credit_weight;
      if ($in_weight == 0) return true;

      pd('Please select account name to issue '.$this->attributes['receipt_type'].' to factory');
      // $this->formdata['metal_issue_vouchers'][] = array('account_name'  => 'AR Gold Software (Aug 2022)',
      //                                                   'credit_weight' => $in_weight,
      //                                                   'dd_type'       => $this->attributes['dd_type']);
    } 
  }
  
  private function set_metal_issue_voucher_attributes_from_receipt_type_for_chain_receipt() {
    $set_metal_issue_voucher = 0;

    if (in_array($this->attributes['receipt_type'], array(//'AR Gold Refresh', 
                                                          'AR Gold Chain Receipt',
                                                          'AR Gold Finished Goods Receipt',
                                                          'AR Gold Finished Goods'))) {
      $set_metal_issue_voucher = 1;
      //$site_name = 'AR Gold';
    }

    if (     $this->attributes['receipt_type'] == 'Alloy Vodator'
          || $this->attributes['receipt_type'] == 'GPC Vodator'
          || $this->attributes['receipt_type'] == 'Stone Vatav'
          || $this->attributes['receipt_type'] == 'Spring Vatav'
          || $this->attributes['receipt_type'] == 'Meena Vatav'
          || $this->attributes['receipt_type'] == 'Copper Vatav'
          || $this->attributes['receipt_type'] == 'Rhodium Vatav'
          || $this->attributes['receipt_type'] == 'Auto Tounch Loss Fine') {
      $set_metal_issue_voucher = 1;

      // if ($this->attributes['site_name'] == 'AR Gold') {
      //   $account_name = 'AR Gold Software';
      //   $site_name = 'AR Gold';
      // }
    }   

    if (in_array($this->attributes['receipt_type'], array(//'ARF Refresh', 
                                                          'ARF Chain Receipt',
                                                          'ARF Finished Goods Receipt',
                                                          'ARF Finished Goods'))) {
      $set_metal_issue_voucher = 1;
      //$account_name = 'ARF Software';
      //$site_name = 'ARF';
    }

    if (     $this->attributes['receipt_type'] == 'Alloy Vodator'
          || $this->attributes['receipt_type'] == 'GPC Vodator'
          || $this->attributes['receipt_type'] == 'Stone Vatav'
          || $this->attributes['receipt_type'] == 'Spring Vatav'
          || $this->attributes['receipt_type'] == 'Meena Vatav'
          || $this->attributes['receipt_type'] == 'Copper Vatav'
          || $this->attributes['receipt_type'] == 'Rhodium Vatav'
          || $this->attributes['receipt_type'] == 'Auto Tounch Loss Fine') {
      $set_metal_issue_voucher = 1;
      
      // if ($this->attributes['site_name'] == 'ARF') {
      //   $account_name = 'ARF Software';
      //   $site_name = 'ARF';
      // }
    }  

    if (in_array($this->attributes['receipt_type'], array(//'ARC Refresh', 427
                                                          'ARC Chain Receipt',
                                                          'ARC Finished Goods Receipt',
                                                          'ARC Finished Goods'))) {
      $set_metal_issue_voucher = 1;
      // $account_name = 'ARC Software';
      // $site_name = 'ARC';
    }

    if (in_array($this->attributes['receipt_type'], array('Export Internal','Packing Slip'))) {
      $set_metal_issue_voucher = 1;
      //$account_name = 'Export Internal Software';
      $site_name = 'Export';
    }
    if (in_array($this->attributes['receipt_type'], array('Domestic Internal','QC Out'))) {
      $set_metal_issue_voucher = 1;
      //$account_name = 'Export Internal Software';
      $site_name = 'Domestic';
    }

    if (     $this->attributes['receipt_type'] == 'Alloy Vodator'
          || $this->attributes['receipt_type'] == 'GPC Vodator'
          || $this->attributes['receipt_type'] == 'Stone Vatav'
          || $this->attributes['receipt_type'] == 'Spring Vatav'
          || $this->attributes['receipt_type'] == 'Meena Vatav'
          || $this->attributes['receipt_type'] == 'Copper Vatav'
          || $this->attributes['receipt_type'] == 'Rhodium Vatav'
          || $this->attributes['receipt_type'] == 'Auto Tounch Loss Fine') {
      $set_metal_issue_voucher = 1;
      
      // if ($this->attributes['site_name'] == 'ARC') {
      //   $account_name = 'ARC Software';
      //   $site_name = 'ARC';
      // } 
    }  

    //$site_name = get_site_name_from_account_name($this->attributes['account_name']);
    $hook_kdm_purity = (empty($this->attributes['hook_kdm_purity'])) ? $this->attributes['factory_purity'] : $this->attributes['hook_kdm_purity'];
    if ($set_metal_issue_voucher==1) {
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $this->attributes['account_name'],
                                  //'site_name' => $site_name,
                                  'credit_weight' => $this->attributes['debit_weight'],
                                  'purity' => $this->attributes['purity'],
                                  'factory_purity' => $this->attributes['factory_purity'],
                                  'hook_kdm_purity' => $hook_kdm_purity));
    }
  }

  private function set_metal_issue_voucher_attributes_from_receipt_type_for_metal_and_chain_receipt() {
    if (isset($this->formdata['metal_issue_vouchers'])) {
      foreach ($this->formdata['metal_issue_vouchers'] as $index => $metal_issue_voucher) {
        if (   $this->attributes['receipt_type'] == 'Metal'
            || $this->attributes['receipt_type'] == 'AR Gold Chain Receipt'
            || $this->attributes['receipt_type'] == 'ARF Chain Receipt'
            || $this->attributes['receipt_type'] == 'ARC Chain Receipt'
            || $this->attributes['receipt_type'] == 'AR Gold RND'
            || $this->attributes['receipt_type'] == 'ARF RND'
            || $this->attributes['receipt_type'] == 'ARC RND'
            || $this->attributes['receipt_type'] == 'Export Internal'
            || $this->attributes['receipt_type'] == 'Domestic Internal'
            || $this->attributes['receipt_type'] == 'Packing Slip'
            || $this->attributes['receipt_type'] == 'QC Out'
            || $this->attributes['receipt_type'] == 'AR Gold Finished Goods Receipt'
            || $this->attributes['receipt_type'] == 'ARF Finished Goods Receipt'
            || $this->attributes['receipt_type'] == 'ARC Finished Goods Receipt') {
          $this->formdata['metal_issue_vouchers'][$index]['purity'] = $this->attributes['purity'];
          $this->formdata['metal_issue_vouchers'][$index]['factory_purity'] = $this->attributes['purity'];
          $this->formdata['metal_issue_vouchers'][$index]['factory_fine'] =$metal_issue_voucher['credit_weight']* $this->attributes['purity']/100;
        }
      }
    }
  }

  private function set_metal_issue_voucher_attributes_for_alloy_vadotar_and_gpc_vadotar() {
    if (    $this->attributes['receipt_type'] == "Alloy Vodator"
         || $this->attributes['receipt_type'] == "GPC Vodator"
         || $this->attributes['receipt_type'] == 'Stone Vatav'
         || $this->attributes['receipt_type'] == 'Spring Vatav'
         || $this->attributes['receipt_type'] == 'Meena Vatav'
         || $this->attributes['receipt_type'] == 'Copper Vatav'
         || $this->attributes['receipt_type'] == 'Rhodium Vatav'
         || $this->attributes['receipt_type'] == 'Auto Tounch Loss Fine') {
      unset($this->formdata['metal_issue_vouchers']);

      // if     ($this->attributes['site_name'] == 'AR Gold (May 2022)') $account_name = 'AR Gold Software';
      // elseif ($this->attributes['site_name'] == 'ARF') $account_name = 'ARF Software';
      // elseif ($this->attributes['site_name'] == 'ARC') $account_name = 'ARC Software';

      $account_name = get_account_name_from_site_name($this->attributes['site_name']);
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $account_name,
                                                  'site_name' => $this->attributes['site_name'],
                                                  'credit_weight' => $this->attributes['debit_weight'],
                                                  'purity' => $this->attributes['purity'],
                                                  'factory_purity' => $this->attributes['factory_purity']));
      
      if ($this->attributes['receipt_type'] != 'Auto Tounch Loss Fine') {
        $metal_issue_voucher = $this->find('id',array('receipt_type' => $this->attributes['receipt_type'],
                                                      'account_name' => $account_name, //$this->attributes['site_name'].' Software',
                                                      // 'narration' => $this->attributes['narration'],
                                                      'site_name' => $this->attributes['site_name'],
                                                      'voucher_date' => $this->attributes['voucher_date']));
        if (!empty($metal_issue_voucher))
          $this->formdata['metal_issue_vouchers'][0]['id'] = $metal_issue_voucher['id'];
      }
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
  private function set_metal_issue_voucher_attributes_from_receipt_type_for_stone() {
    if ($this->attributes['receipt_type'] == "Stone") {
      unset($this->formdata['metal_issue_vouchers']);
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => 'ARC Software (Apr 2024)',
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

  private function set_id_for_alloy_vodator_gpc_vodator_and_stone_vatav() {
    if (   $this->attributes['receipt_type'] != 'Alloy Vodator'
        && $this->attributes['receipt_type'] != 'GPC Vodator'
        && $this->attributes['receipt_type'] != 'Stone Vatav'
        && $this->attributes['receipt_type'] != 'Spring Vatav'
        && $this->attributes['receipt_type'] != 'Meena Vatav'
        && $this->attributes['receipt_type'] != 'Copper Vatav'
        && $this->attributes['receipt_type'] != 'Rhodium Vatav') return;

    $metal_receipt_voucher = $this->find('id', array('receipt_type' => $this->attributes['receipt_type'],
                                                     'site_name' => $this->attributes['site_name'],
                                                     'voucher_date' => $this->attributes['voucher_date']));
    if (!empty($metal_receipt_voucher)) $this->attributes['id'] = $metal_receipt_voucher['id'];

  }

  public function before_save($action) {
    $this->attributes['fine'] = $this->attributes['debit_weight'] * $this->attributes['purity'] / 100;
    $this->attributes['factory_fine'] = $this->attributes['debit_weight'] * $this->attributes['factory_purity'] / 100;
    parent::before_save($action);
  }

  private function create_rate_cut_vouchers_for_metal_and_refresh() {
    if (   $this->attributes['receipt_type'] != 'Metal'
        && $this->attributes['receipt_type'] != 'Refresh'
        // && $this->attributes['receipt_type'] != 'AR Gold Refresh'
        // && $this->attributes['receipt_type'] != 'ARF Refresh'
        // && $this->attributes['receipt_type'] != 'ARC Refresh'
        && $this->attributes['receipt_type'] != 'Rhodium')
      return;

    if (   !empty($this->attributes['gold_rate']) && $this->attributes['gold_rate'] <= 0 
        && !empty($this->attributes['hallmark_rate']) && $this->attributes['hallmark_rate'] <= 0 ) return;
    if(!empty($this->attributes['sale_type']) && ($this->attributes['sale_type']=="Sale Return" || $this->attributes['sale_type']=="Sales Good Return")){
      $this->rate_cut_issue_voucher_model->create_rate_cut_vouchers_for_sales_return($this->attributes['id'], $this->attributes['receipt_type']);
    }else{
      $this->rate_cut_issue_voucher_model->create_rate_cut_vouchers_for_metal_and_refresh($this->attributes['id'], $this->attributes['receipt_type']);
    }
  } 
  
  public function after_save($action) {
//pd($this->formdata);
    parent::after_save($action);
    if($this->attributes['account_name']!="Domestic Internal Software" && $this->attributes['account_name']!="Export Internal Software"){
      $this->create_metal_issue_vouchers();
    }
    $this->create_rate_cut_vouchers_for_metal_and_refresh();
    $this->_add_metal_receipt_id_in_refresh_data();
  }
  
  private function _add_metal_receipt_id_in_refresh_data() {
    if(!empty($this->formdata['refresh_id'])){
      $refresh['metal_receipt_id']=$this->attributes['id'];
      $refresh_data = new refresh_model($refresh);
      $refresh_data->update(false,array('id'=>$this->formdata['refresh_id']));
    }
  }

  private function create_metal_issue_vouchers() {
    $this->load->model(array('transactions/metal_issue_voucher_model','transactions/metal_receipt_voucher_model'));
    if(empty($this->formdata['metal_issue_vouchers'])) return true;
    $is_export= $this->metal_receipt_voucher_model->find('is_export',array('id'=>$this->attributes['id']))['is_export'];
    foreach ($this->formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
      $metal_issue_data = array();
      $metal_issue_data=$metal_issue_voucher;

      $metal_issue_data['company_id']  = $this->attributes['company_id'];
      $metal_issue_data['metal_receipt_voucher_reference_id'] = $this->attributes['id'];
      $metal_issue_data['voucher_date'] = $this->attributes['voucher_date'];
      $metal_issue_data['site_name'] = get_site_name_from_account_name($metal_issue_voucher['account_name']) ?? $this->attributes['site_name'];
      //$metal_issue_data['account_id'] = $this->attributes['account_id'];

      if ($this->attributes['receipt_type'] != 'Vadotar') {
        $metal_issue_data['purity'] = $this->attributes['factory_purity'];
        $metal_issue_data['factory_purity'] = $this->attributes['factory_purity'];
        $metal_issue_data['fine'] =!empty($metal_issue_voucher['credit_weight'])? $metal_issue_voucher['credit_weight'] * $this->attributes['factory_purity'] / 100 : 0;
        $metal_issue_data['factory_fine'] = $metal_issue_data['fine'];
      }
      
      $metal_issue_data['narration'] = @$this->attributes['narration'];
      $metal_issue_data['description'] = empty($this->attributes['description']) ? '' : $this->attributes['description'];
      $metal_issue_data['suffix'] = "MI";
      $metal_issue_data['voucher_type'] = "metal issue voucher";
      $metal_issue_data['transaction_type'] = 'account';
      $metal_issue_data['is_export'] = $is_export;
      $metal_issue_data['dd_type'] = !empty($this->attributes['dd_type'])?$this->attributes['dd_type']:"";
      $obj_metal_issue_voucher=new metal_issue_voucher_model($metal_issue_data);
      $obj_metal_issue_voucher->save();
    }    
  }

  public function send_request_to_factory($attributes) {
$attributes['account_name']=trim($attributes['account_name']);
    if ($attributes['credit_weight'] == 0) return true;
    $api_data = array('account'=> $attributes['account_name'].' (accounts)',
                      'in_weight' => $attributes['credit_weight'],
                      'in_lot_purity' => $attributes['factory_purity'],
                      'description' => $attributes['narration'],
                      'argold_account_id' => $attributes['id']);
    $send_data=array();
    if ($attributes['receipt_type'] == 'Metal') {
      $api_data = array_merge($api_data, array('type' => 'Pure',
                                               'process_name' => 'Receipt'));
      $send_data['receipt_departments'] = $api_data;
      $api_url="api/api_receipt_departments/store";

    } elseif ($attributes['receipt_type'] == 'Rhodium') {
      $api_data = array_merge($api_data, array('type' => 'Pure',
                                               'process_name' => 'Receipt'));
      $send_data['rhodium_receipts'] = $api_data;
      $api_url="api/api_rhodium_receipts/store";

    } elseif ($attributes['receipt_type'] == 'Stone') {
      $api_data = array_merge($api_data, array('type' => 'Pure',
                                               'description' => $attributes['description'],
                                               'process_name' => 'Stone Receipt'));
      $send_data['stone_receipts'] = $api_data;
      $api_url="api/api_stone_receipts/store";

    } else if ($attributes['receipt_type'] == "Daily Drawer") {
      $api_data = array_merge($api_data, array('type' => $attributes['dd_type'],
                                               'balance' => $attributes['credit_weight'],
                                               'karigar'=> 'Factory'));
      $send_data['daily_drawer_receipts'] = $api_data;
      $api_url="api/api_daily_drawer_receipts/store";  

    } else if(   $attributes['receipt_type'] == "Refresh" ||
               $attributes['receipt_type'] == "Reject"
              //    $attributes['receipt_type'] == "AR Gold Refresh"
              // || $attributes['receipt_type'] == "ARF Refresh"
              || $attributes['receipt_type'] == "Export Internal"
              || $attributes['receipt_type'] == "Domestic Internal") {
              // || $attributes['receipt_type'] == "ARC Refresh"
	if ($attributes['account_name'] == 'Export Internal Software' || $attributes['account_name'] == 'Domestic Internal Software' || $attributes['account_name'] == 'Domestic Internal ERP Software') return;

      $api_data = array_merge($api_data, array('type'=>'Pure',
                                               'hook_kdm_purity' => (empty($attributes['hook_kdm_purity'])) ? $attributes['factory_purity'] : $attributes['hook_kdm_purity'],
                                               'description' => $attributes['receipt_type'].'-'.$attributes['description'],
                                               'process_name'=>'Refresh'));
      $send_data['refresh_departments'] = $api_data;
      $api_url="api/api_refresh_departments/store";

    } elseif (   $attributes['receipt_type'] == 'AR Gold Chain Receipt'
              || $attributes['receipt_type'] == 'ARF Chain Receipt'
              || $attributes['receipt_type'] == 'ARC Chain Receipt') {
      $api_data = array_merge($api_data, array('type' => 'Solid Machine Chain'));
      $send_data['chain_receipts'] = $api_data;
      $api_url = "api/api_chain_receipts/store";

    }elseif ( $attributes['receipt_type'] == 'AR Gold Internal Receipt'
              || $attributes['receipt_type'] == 'ARF Internal Receipt'
              || $attributes['receipt_type'] == 'ARC Internal Receipt') {
      $api_data = array_merge($api_data, array('type' => 'Pure' ,'description' => $api_data['description'].'-'.$attributes['site_name']));
      $send_data['internal_receipts'] = $api_data;
      $api_url = "api/api_internal_receipts/store";

    }elseif (    ($attributes['receipt_type'] == 'Melting Wastage' || $attributes['receipt_type'] == 'Daily Drawer Wastage'|| $attributes['receipt_type'] == 'Fancy 75 DD Wastage'|| $attributes['receipt_type'] == 'Pipe and Para DD Wastage'|| $attributes['receipt_type'] == 'Ball Chain DD Wastage' ||$attributes['receipt_type'] == 'Sisma DD Wastage'||$attributes['receipt_type'] == 'Fancy 92 DD Wastage' || $attributes['receipt_type'] == 'GPC' || $attributes['receipt_type'] == 'GPC Out' || $attributes['receipt_type'] == 'Finish Good') 
              && (    $attributes['account_name'] == 'AR Gold Software Nov 2020' || $attributes['account_name'] == 'ARF Software Nov 2020' || $attributes['account_name'] == 'ARC Software Nov 2020'
                   || $attributes['account_name'] == 'AR Gold Software Jan 2021'
                    || $attributes['account_name'] == 'ARF Software Jan 2021' || $attributes['account_name'] == 'ARC Software Jan 2021'
                   || $attributes['account_name'] == 'AR Gold Software (May 2022)'
                   || $attributes['account_name'] == 'ARF Software (May 2022)' 
                   || $attributes['account_name'] == 'ARC Software (May 2022)'
                   || $attributes['account_name'] == 'AR Gold Software (Aug 2022)'
                   || $attributes['account_name'] == 'ARF Software (Aug 2022)' 
                   || $attributes['account_name'] == 'ARC Software (Aug 2022)'
                   || $attributes['account_name'] == 'AR Gold Software (Feb 2023)'
                   || $attributes['account_name'] == 'ARF Software (Feb 2023)' 
                   || $attributes['account_name'] == 'ARC Software (Feb 2023)'
                   || $attributes['account_name'] == 'AR Gold Software (Apr 2023)'
                   || $attributes['account_name'] == 'ARF Software (Apr 2023)' 
                   || $attributes['account_name'] == 'ARC Software (Apr 2023)'
                   || $attributes['account_name'] == 'AR Gold Software (Sep 2023)'
                   || $attributes['account_name'] == 'ARF Software (Sep 2023)' 
                   || $attributes['account_name'] == 'ARC Software (Sep 2023)'
                   || $attributes['account_name'] == 'AR Gold Software (Apr 2024)'
                   || $attributes['account_name'] == 'ARF Software (Apr 2024)' 
                   || $attributes['account_name'] == 'Arf Software (Aug 2024)' 
                   || $attributes['account_name'] == 'ARF Software (Aug 2024)' 
                   || $attributes['account_name'] == 'ARC Software (Apr 2024)'
                   || $attributes['account_name'] == 'AR Gold Software'
                   || $attributes['account_name'] == 'ARF Software' 
                   || $attributes['account_name'] == 'ARC Software'
                   || $attributes['account_name'] == 'Export Internal Software'
                   || $attributes['account_name'] == 'Domestic Internal Software'
                    )) {
      $api_data = array_merge($api_data, array('type' => 'Pure','description' => $api_data['description'].'-'.$attributes['site_name']));
      $send_data['internal_receipts'] = $api_data;
      if($attributes['account_name'] == 'Domestic Internal Software'){
        $api_data['account']=$attributes['site_name'];
        $send_data['domestic_internal_receipts'] = $api_data;
        $api_url = "api/api_domestic_internal_receipts/store";
      }else{
        $api_url = "api/api_internal_receipts/store";
      }


    }elseif (   $attributes['receipt_type'] == 'AR Gold RND'
              || $attributes['receipt_type'] == 'ARF RND'
              || $attributes['receipt_type'] == 'ARC RND') {
      $send_data['rnd_receipts'] = $api_data;
      $api_url = "api/api_rnd_receipts/store";  

    }elseif (   $attributes['receipt_type'] == 'Export Internal ISSUE') {
      $send_data['export_internal_receipts'] = $api_data;
      $api_url = "api/api_export_internal_receipts/store";  

    } elseif (   $attributes['receipt_type'] == 'AR Gold Finished Goods Receipt'
              || $attributes['receipt_type'] == 'ARF Finished Goods Receipt'
              || $attributes['receipt_type'] == 'ARC Finished Goods Receipt') {
      $send_data['finished_goods_receipts'] = $api_data;
      $api_url = "api/api_finished_goods_receipts/store";

    } elseif ($attributes['receipt_type'] == 'Cutting Ghiss' 
              ||$attributes['receipt_type'] == 'Recutting Ghiss' 
              ||$attributes['receipt_type'] == 'DC Ghiss' 
              ||$attributes['receipt_type'] == 'DC 2 Ghiss' 
              ||$attributes['receipt_type'] == 'CNC Ghiss' 
              ||$attributes['receipt_type'] == 'Round and Ball Chain Cutting Ghiss' 
              ||$attributes['receipt_type'] == 'Round and Ball Chain Ghiss' 
              ||$attributes['receipt_type'] == 'Round and Ball Chain 2 Ghiss' 
              ||$attributes['receipt_type'] == 'Hand Cutting Ghiss' 
              ||$attributes['receipt_type'] == 'Hand Dull Ghiss' 
              || $attributes['receipt_type'] == 'Ice Cutting Ghiss'){
      $department_name='';
      if($attributes['receipt_type']=='Cutting Ghiss'){
        $department_name='Cutting';
      }elseif($attributes['receipt_type']=='Recutting Ghiss'){
        $department_name='Recutting';
      }elseif($attributes['receipt_type']=='DC Ghiss'){
        $department_name='DC';
      }elseif($attributes['receipt_type']=='DC 2 Ghiss'){
        $department_name='Dc 2';
      }elseif($attributes['receipt_type']=='CNC Ghiss'){
        $department_name='CNC';
      }elseif($attributes['receipt_type']=='Round and Ball Chain Cutting Ghiss'){
        $department_name='Round and Ball Chain Cutting';
      }elseif($attributes['receipt_type']=='Round and Ball Chain Ghiss'){
        $department_name='Round and Ball Chain';
      }elseif($attributes['receipt_type']=='Round and Ball Chain 2 Ghiss'){
        $department_name='Round and Ball Chain 2';
      }elseif($attributes['receipt_type']=='Hand Cutting Ghiss'){
        $department_name='Hand Cutting';
      }elseif($attributes['receipt_type']=='Hand Dull Ghiss'){
        $department_name='Hand Dull';
      }elseif($attributes['receipt_type']=='Ice Cutting Ghiss'){
        $department_name='Ice Cutting';
      }
      $send_data['pending_ghiss_receipts'] = array_merge($api_data, array('department_name' => $department_name));
      $api_url = "api/api_pending_ghiss_receipts/store";
    }

    if(($attributes['site_name']=="AR Gold ERP" || $attributes['site_name']=="ARF ERP" ||$attributes['site_name']=="RND ERP" || $attributes['site_name']=="ARC ERP" || $attributes['site_name']=="Domestic Internal ERP" || $attributes['site_name']=="ARNA BANGLE ERP") && ($attributes['receipt_type'] == 'GPC Out'|| $attributes['receipt_type'] == 'Melting Wastage' || $attributes['receipt_type'] == 'Daily Drawer Wastage'||$attributes['receipt_type'] == 'Fancy 75 DD Wastage'|| $attributes['receipt_type'] == 'Pipe and Para DD Wastage'|| $attributes['receipt_type'] == 'Ball Chain DD Wastage' ||$attributes['receipt_type'] == 'Sisma DD Wastage'||$attributes['receipt_type'] == 'Fancy 92 DD Wastage' || $attributes['receipt_type'] == 'Export Internal' || $attributes['receipt_type'] == 'Domestic Internal' || $attributes['receipt_type'] == 'Refresh')){}
      elseif(($attributes['site_name']=="AR Gold ERP" || $attributes['site_name']=="ARF ERP" ||$attributes['site_name']=="RND ERP" || $attributes['site_name']=="ARC ERP" || $attributes['site_name']=="Domestic Internal ERP" || $attributes['site_name']=="ARNA BANGLE ERP") &&($attributes['receipt_type'] == 'GPC' || $attributes['receipt_type'] == 'GPC Out'|| $attributes['receipt_type'] == 'Finish Good') && ($attributes['account_name'] == 'Domestic Internal ERP Software' || $attributes['account_name'] == 'ARNA BANGLE' || $attributes['account_name'] == 'Rnd Erp Software' ||  $attributes['account_name'] == 'ARG ERP Software' )){
     }else{

    	if (empty($api_url)) return true;
   	 $api_url = get_api_path_from_account_name($attributes['account_name']).$api_url;

    }
    // if ($attributes['account_name'] == 'AR Gold Software')
    //   $api_url = API_ARG_PATH.$api_url;
    // elseif ($attributes['account_name'] == 'ARF Software')
    //   $api_url = API_ARF_PATH.$api_url;
    // elseif ($attributes['account_name'] == 'ARC Software')
    //   $api_url = API_ARC_PATH.$api_url;
    // elseif ($attributes['account_name'] == 'AR Gold Software (Aug 2022)')
    //   $api_url = API_2_ARG_PATH.$api_url;
    // elseif ($attributes['account_name'] == 'ARF Software (Aug 2022)')
    //   $api_url = API_2_ARF_PATH.$api_url;
    // elseif ($attributes['account_name'] == 'ARC Software (Aug 2022)')
    //   $api_url = API_2_ARC_PATH.$api_url;
    // elseif ($attributes['account_name'] == 'Export Internal Software')
    //   $api_url = API_EXPORT_INTERNAL_PATH.$api_url;
  //  print_r($send_data);
//pd($attributes);
//pd($api_url);
  if ($attributes['account_name']=="AR Gold ERP Software" ||$attributes['account_name']=="ARG ERP Software" || $attributes['account_name']=="ARF ERP Software" || $attributes['account_name']=="Arf Erp Software" ||$attributes['account_name']=="Rnd Erp Software" || $attributes['account_name']=="ARC ERP Software" || $attributes['account_name']=="Arc Erp Software"|| $attributes['account_name']=="ARNA BANGLE"|| $attributes['account_name']=="Domestic Internal ERP Software"){
      $this->load->model(array('transactions/metal_issue_voucher_model','transactions/metal_receipt_voucher_model'));
      if(!empty($attributes['metal_receipt_voucher_reference_id'])){ 	
       $parent_data=$this->metal_receipt_voucher_model->find('',array('id'=>$attributes['metal_receipt_voucher_reference_id']));
      }    //  pd($attributes);
      if($attributes['receipt_type']=="Daily Drawer"){
        $attributes['receipt_type']=$attributes['dd_type'];
      }
      if($attributes['receipt_type']=="Refresh"){
        $attributes['site_name']=$parent_data['site_name'];
        $attributes['hook_kdm_purity']=$parent_data['hook_kdm_purity'];
      }

      if($attributes['account_name']=="ARNA BANGLE"){
    //  	if($attributes['customer_name']==''){
      	$attributes['customer_name']="ARNA BANGLE";
      	if($attributes['receipt_type']=="GPC"){
      	$attributes['receipt_type']="GPC Out"; 
      	 }    //	}
      }	
      if($attributes['receipt_type']=="Export Internal" || $attributes['receipt_type']=="Domestic Internal"){
        $attributes['receipt_type']="Refresh";
        $attributes['site_name']=$parent_data['site_name'];
        $attributes['hook_kdm_purity']=$parent_data['hook_kdm_purity'];
      }
      if($attributes['receipt_type']=="AR Gold RND" || $attributes['receipt_type']=="ARF RND" || $attributes['receipt_type']=="ARF RND"){
        $attributes['receipt_type']="RND";
      }
      if(!empty($parent_data)){
      $attributes['customer_name']=$parent_data['account_name'];
      }

    $api_data = array('receipt_type'=> $attributes['receipt_type'],
                      'account_name'=> $attributes['account_name'],
                      'customer_name'=> $attributes['customer_name'],
                      'factory'=> $attributes['account_name'],
                      'item_name'=> $attributes['narration'],
                      'voucher_number'=> $attributes['voucher_number'],
                      'credit_weight' => (float)$attributes['credit_weight'],
                      'factory_purity' => (float)$attributes['factory_purity'],
                      'hook_kdm_purity' => (empty($attributes['hook_kdm_purity'])) ? (float)four_decimal($attributes['factory_purity']) : (float)four_decimal($attributes['hook_kdm_purity']),
                      'description' => $attributes['description'],
                      'account_id' => $attributes['id']);
    $send_data=$api_data;
 //$api_url = "https://staging1-arg-manufacturing.8848digitalerp.com/api/method/custom_app.api.material_receipt.create_material_receipt";
    $api_url = "https://erp.ar-gold.in/api/method/custom_app.api.material_receipt.create_material_receipt";
    if (empty($api_url)) return true;
    $result = curl_post_erp_request($api_url, $send_data);
  }else{
    $result = curl_post_request($api_url, $send_data);
  }
}

  public function create_vodator_records($records, $receipt_type, $site_name, $hostversion) {
    if (empty($records)) return true;
    $records = json_decode(json_encode($records), true);
    foreach ($records as $index => $record) {
      if ($record['weight']==0) continue;
      //$start_date_timestamp = strtotime($start_date);
      //$voucher_date_timestamp = strtotime($record['created_date']);
      
      //if ($start_date_timestamp > $voucher_date_timestamp) continue;
      $metal_receipt_voucher = $this->find('id, debit_weight', array('receipt_type' => $receipt_type,
                                                                     'account_name' => $site_name.' '.$receipt_type.' ('.$hostversion.')',
                                                                     'narration' => $site_name.' '.$receipt_type,
                                                                     'voucher_date' => $record['created_date']));
      $data=array('company_id' => 1,
                  'voucher_date' => $record['created_date'],
                  'receipt_type' => $receipt_type,
                  'account_name' => $site_name.' '.$receipt_type.' ('.$hostversion.')',
                  'debit_weight' => $record['weight'],
                  'purity' => $record['purity'],
                  'factory_purity' => $record['purity'],
                  'fine' => $record['fine'],
                  'factory_fine' => $record['fine'],
                  'narration' => $site_name.' '.$receipt_type,
                  'site_name' => $site_name.' ('.$hostversion.')');
      $data['id'] = '';
      if (!empty($metal_receipt_voucher)) $data['id'] = $metal_receipt_voucher['id'];
      if (empty($record['weight'])) return;
      if (empty($metal_receipt_voucher['debit_weight'])
         || ($metal_receipt_voucher['debit_weight'] != round($record['weight'], 4) )) {
        $metal_receipt_obj = new metal_receipt_voucher_model($data);
        $metal_receipt_obj->before_validate();
        $metal_receipt_obj->save();
      } 
    }
  }

}
