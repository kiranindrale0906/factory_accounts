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

    if (   $this->attributes['receipt_type'] == 'AR Gold Refresh'
        || $this->attributes['receipt_type'] == 'ARF Refresh'
        || $this->attributes['receipt_type'] == 'ARC Refresh') 
      $rules[] = $this->get_sale_type_validation_rules();

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

    $this->set_metal_issue_voucher_attributes_from_argold_software_metal_receipt();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_refresh_and_chain_receipt();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_metal_and_chain_receipt();
    $this->set_id_for_alloy_vodator_gpc_vodator_and_stone_vatav();
    $this->set_metal_issue_voucher_attributes_for_alloy_vadotar_and_gpc_vadotar();
    $this->set_metal_issue_voucher_attributes_from_receipt_type_for_vadotar(); 
    
    $this->set_receipt_type_for_all_metal_issue_vouchers();
    $this->set_gold_rate_purity();
    $this->unset_metal_issue_voucher_records_when_credit_weight_is_0(); 
  }

  private function set_gold_rate_purity() {
    if (   !isset($this->attributes['gold_rate_purity'])
        || $this->attributes['gold_rate_purity'] > 0)  $this->attributes['gold_rate_purity'] = 100;
  }

  private function set_site_name_from_receipt_type() {
    if ($this->attributes['receipt_type'] == 'AR Gold Refresh')  $this->attributes['site_name'] = 'AR Gold Jan 2021';
    elseif ($this->attributes['receipt_type'] == 'ARF Refresh')  $this->attributes['site_name'] = 'ARF Jan 2021';
    elseif ($this->attributes['receipt_type'] == 'ARC Refresh')  $this->attributes['site_name'] = 'ARC Jan 2021';
  }

  private function set_sale_type_from_receipt_type_for_metal() {
    if ($this->attributes['receipt_type'] == 'Metal' && empty($this->attributes['parent_id'])) $this->attributes['sale_type'] == 'Sale';
  }

  private function set_account_name_from_receipt_type() {
    if ($this->attributes['receipt_type'] == "AR Gold Finished Goods")      $this->attributes['account_name'] = 'AR Gold';
    if ($this->attributes['receipt_type'] == "ARF Finished Goods")          $this->attributes['account_name'] = 'ARF';
    if ($this->attributes['receipt_type'] == "ARC Finished Goods")          $this->attributes['account_name'] = 'ARC';
    if ($this->attributes['receipt_type'] == "ARF Software Finished Goods") $this->attributes['account_name'] = 'ARF Software Jan 2021';
    if ($this->attributes['receipt_type'] == "Vadotar")                     $this->attributes['account_name'] = 'MAIN VADOTAR';
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

  private function set_factory_purity_from_receipt_type_for_metal_and_finished_goods_and_chain_receipt() {
    if (in_array($this->attributes['receipt_type'], array('Metal', 
                                                          'AR Gold Finished Goods', 'AR Gold Chain Receipt', 'AR Gold Finished Goods Receipt', 'AR Gold RND',
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

  private function set_metal_issue_voucher_attributes_from_argold_software_metal_receipt() {
    if (   $this->attributes['receipt_type'] == 'Metal'
        || $this->attributes['receipt_type'] == 'Daily Drawer') {
      $credit_weight = 0;

      $this->attributes['dd_type'] = isset($this->attributes['dd_type']) ? $this->attributes['dd_type'] : '';
      if (!empty($this->formdata['metal_issue_vouchers'])) {
        foreach ($this->formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
          if(!empty($metal_issue_voucher['credit_weight']))
          $credit_weight += $metal_issue_voucher['credit_weight'];
        }
      }
      $in_weight = $this->attributes['debit_weight'] - $credit_weight;
      if ($in_weight == 0) return true;

      $this->formdata['metal_issue_vouchers'][] = array('account_name' => 'AR Gold Software Jan 2021',
                                                        'credit_weight' => $in_weight,
                                                        'dd_type' => $this->attributes['dd_type']);
    } 
  }
  
  private function set_metal_issue_voucher_attributes_from_receipt_type_for_refresh_and_chain_receipt() {
    $set_metal_issue_voucher = 0;

    if (in_array($this->attributes['receipt_type'], array('AR Gold Refresh', 
                                                          'AR Gold Chain Receipt',
                                                          'AR Gold Finished Goods Receipt',
                                                          'AR Gold Finished Goods',
                                                          'AR Gold RND'))) {
      $set_metal_issue_voucher = 1;
      $account_name = 'AR Gold Software Jan 2021';
      $site_name = 'AR Gold Jan 2021';
    }

    if (     $this->attributes['receipt_type'] == 'Alloy Vodator'
          || $this->attributes['receipt_type'] == 'GPC Vodator'
          || $this->attributes['receipt_type'] == 'Stone Vatav') {
      $set_metal_issue_voucher = 1;
      
      if ($this->attributes['site_name'] == 'AR Gold Jan 2021') {
        $account_name = 'AR Gold Software Jan 2021';
        $site_name = 'AR Gold Jan 2021';
      } elseif ($this->attributes['site_name'] == 'AR Gold Nov 2020') {
        $account_name = 'AR Gold Software Nov 2020';
        $site_name = 'AR Gold Nov 2020';
      }
    }      

    if (in_array($this->attributes['receipt_type'], array('ARF Refresh', 
                                                          'ARF Chain Receipt',
                                                          'ARF Finished Goods Receipt',
                                                          'ARF Finished Goods',
                                                          'ARF RND'))) {
      $set_metal_issue_voucher = 1;
      $account_name = 'ARF Software Jan 2021';
      $site_name = 'ARF Jan 2021';
    }

    if (     $this->attributes['receipt_type'] == 'Alloy Vodator'
          || $this->attributes['receipt_type'] == 'GPC Vodator'
          || $this->attributes['receipt_type'] == 'Stone Vatav') {
      $set_metal_issue_voucher = 1;
      
      if ($this->attributes['site_name'] == 'ARF Jan 2021') {
        $account_name = 'ARF Software Jan 2021';
        $site_name = 'ARF Jan 2021';
      } elseif ($this->attributes['site_name'] == 'ARF Nov 2020') {
        $account_name = 'ARF Software Nov 2020';
        $site_name = 'ARF Nov 2020';
      }
    }  

    if (in_array($this->attributes['receipt_type'], array('ARC Refresh', 
                                                          'ARC Chain Receipt',
                                                          'ARC Finished Goods Receipt',
                                                          'ARC Finished Goods',
                                                          'ARC RND'))) {
      $set_metal_issue_voucher = 1;
      $account_name = 'ARC Software Jan 2021';
      $site_name = 'ARC Jan 2021';
    }

    if (     $this->attributes['receipt_type'] == 'Alloy Vodator'
          || $this->attributes['receipt_type'] == 'GPC Vodator'
          || $this->attributes['receipt_type'] == 'Stone Vatav') {
      $set_metal_issue_voucher = 1;
      
      if ($this->attributes['site_name'] == 'ARC Jan 2021') {
        $account_name = 'ARC Software Jan 2021';
        $site_name = 'ARC Jan 2021';
      } elseif ($this->attributes['site_name'] == 'ARC Nov 2020') {
        $account_name = 'ARC Software Nov 2020';
        $site_name = 'ARC Nov 2020';
      }
    }  

    if ($set_metal_issue_voucher==1) {
      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $account_name,
                                                            'site_name' => $site_name,
                                                            'credit_weight' => $this->attributes['debit_weight'],
                                                            'purity' => $this->attributes['purity'],
                                                            'factory_purity' => $this->attributes['factory_purity'],
                                                            'hook_kdm_purity' => (empty($this->attributes['hook_kdm_purity'])) ? $this->attributes['factory_purity'] : $this->attributes['hook_kdm_purity']));
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
         || $this->attributes['receipt_type'] == 'Stone Vatav') {
      unset($this->formdata['metal_issue_vouchers']);

      if     ($this->attributes['site_name'] == 'AR Gold Nov 2020') $account_name = 'AR Gold Software Nov 2020';
      elseif ($this->attributes['site_name'] == 'AR Gold Jan 2021') $account_name = 'AR Gold Software Jan 2021';
      elseif ($this->attributes['site_name'] == 'ARF Nov 2020') $account_name = 'ARF Software Nov 2020';
      elseif ($this->attributes['site_name'] == 'ARF Jan 2021') $account_name = 'ARF Software Jan 2021';
      elseif ($this->attributes['site_name'] == 'ARC Nov 2020') $account_name = 'ARC Software Nov 2020';
      elseif ($this->attributes['site_name'] == 'ARC Jan 2021') $account_name = 'ARC Software Jan 2021';

      $this->formdata['metal_issue_vouchers'] = array(array('account_name' => $account_name,
                                                            'site_name' => $this->attributes['site_name'],
                                                            'credit_weight' => $this->attributes['debit_weight'],
                                                            'purity' => $this->attributes['purity'],
                                                            'factory_purity' => $this->attributes['factory_purity']));
      $metal_issue_voucher = $this->find('id',array('receipt_type' => $this->attributes['receipt_type'],
                                                    // 'account_name' => $this->attributes['site_name'].' Software',
                                                    // 'narration' => $this->attributes['narration'],
                                                    'site_name' => $this->attributes['site_name'],
                                                    'voucher_date' => $this->attributes['voucher_date']));
      if (!empty($metal_issue_voucher))
        $this->formdata['metal_issue_vouchers'][0]['id'] = $metal_issue_voucher['id'];
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

  private function set_id_for_alloy_vodator_gpc_vodator_and_stone_vatav() {
    if (   $this->attributes['receipt_type'] != 'Alloy Vodator'
        && $this->attributes['receipt_type'] != 'GPC Vodator'
        && $this->attributes['receipt_type'] != 'Stone Vatav') return;

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
        && $this->attributes['receipt_type'] != 'AR Gold Refresh'
        && $this->attributes['receipt_type'] != 'ARF Refresh'
        && $this->attributes['receipt_type'] != 'ARC Refresh')
      return;

    if (!empty($this->attributes['gold_rate']) && $this->attributes['gold_rate'] <= 0 ) return;

    $this->rate_cut_issue_voucher_model->create_rate_cut_vouchers_for_metal_and_refresh($this->attributes['id'], $this->attributes['receipt_type']);
  } 
  
  public function after_save($action) {
    parent::after_save($action);
    $this->create_metal_issue_vouchers();
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
      
      $metal_issue_data['narration'] = @$this->attributes['narration'];
      $metal_issue_data['description'] = empty($this->attributes['description']) ? '' : $this->attributes['description'];
      $metal_issue_data['suffix'] = "MI";
      $metal_issue_data['voucher_type'] = "metal issue voucher";
      $metal_issue_data['transaction_type'] = 'account';
      $obj_metal_issue_voucher=new metal_issue_voucher_model($metal_issue_data);
      $obj_metal_issue_voucher->save();
    }    
  }

  public function send_request_to_factory($attributes) {
// pd($attributes);
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

    } else if ($attributes['receipt_type'] == "Daily Drawer") {
      $api_data = array_merge($api_data, array('type' => $attributes['dd_type'],
                                               'balance' => $attributes['credit_weight'],
                                               'karigar'=> 'Factory'));
      $send_data['daily_drawer_receipts'] = $api_data;
      $api_url="api/api_daily_drawer_receipts/store";  

    } else if(   $attributes['receipt_type'] == "AR Gold Refresh"
              || $attributes['receipt_type'] == "ARF Refresh"
              || $attributes['receipt_type'] == "ARC Refresh") {
      $api_data = array_merge($api_data, array('type'=>'Pure',
                                               'hook_kdm_purity' => $attributes['hook_kdm_purity'],
                                               'description' => $attributes['description'],
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

    }elseif (    ($attributes['receipt_type'] == 'Melting Wastage' || $attributes['receipt_type'] == 'Daily Drawer Wastage' || $attributes['receipt_type'] == 'GPC Out') 
              && (    $attributes['account_name'] == 'AR Gold Software Nov 2020' || $attributes['account_name'] == 'ARF Software Nov 2020' || $attributes['account_name'] == 'ARC Software Nov 2020'
                   || $attributes['account_name'] == 'AR Gold Software Jan 2021' || $attributes['account_name'] == 'ARF Software Jan 2021' || $attributes['account_name'] == 'ARC Software Jan 2021')) {

      $api_data = array_merge($api_data, array('type' => 'Pure'));
      $send_data['internal_receipts'] = $api_data;
      $api_url = "api/api_internal_receipts/store";

    } elseif (   $attributes['receipt_type'] == 'AR Gold RND'
              || $attributes['receipt_type'] == 'ARF RND'
              || $attributes['receipt_type'] == 'ARC RND') {
      $send_data['rnd_receipts'] = $api_data;
      $api_url = "api/api_rnd_receipts/store";  

    } elseif (   $attributes['receipt_type'] == 'AR Gold Finished Goods Receipt'
              || $attributes['receipt_type'] == 'ARF Finished Goods Receipt'
              || $attributes['receipt_type'] == 'ARC Finished Goods Receipt') {
      $send_data['finished_goods_receipts'] = $api_data;
      $api_url = "api/api_finished_goods_receipts/store";

    } elseif (   $attributes['receipt_type'] == 'Cutting Ghiss' 
              || $attributes['receipt_type'] == 'Ice Cutting Ghiss') {
      $send_data['pending_ghiss_receipts'] = array_merge($api_data, array('department_name' => $attributes['narration']));
      $api_url = "api/api_pending_ghiss_receipts/store";
    }

    if (empty($api_url)) return true;
    if ($attributes['account_name'] == 'AR Gold Software Jan 2021')
      $api_url = API_ARG_JAN2021_PATH.$api_url;
    elseif ($attributes['account_name'] == 'ARF Software Jan 2021')
      $api_url = API_ARF_JAN2021_PATH.$api_url;
    elseif ($attributes['account_name'] == 'ARC Software Jan 2021')
      $api_url = API_ARC_JAN2021_PATH.$api_url;
    elseif ($attributes['account_name'] == 'AR Gold Software Nov 2020')
          $api_url = API_ARG_NOV2020_PATH.$api_url;
    elseif ($attributes['account_name'] == 'ARC Software Nov 2020')
          $api_url = API_ARC_NOV2020_PATH.$api_url;
    elseif ($attributes['account_name'] == 'ARF Software Nov 2020')
          $api_url = API_ARF_NOV2020_PATH.$api_url;
        print_r($send_data)
        pd($api_url);
    $result = curl_post_request($api_url, $send_data);
  }

  public function create_vodator_records($records, $receipt_type, $site_name, $hostversion) {
    if (empty($records)) return true;
    $records = json_decode(json_encode($records), true);
    foreach ($records as $index => $record) {
      //$start_date_timestamp = strtotime($start_date);
      //$voucher_date_timestamp = strtotime($record['created_date']);
      
      //if ($start_date_timestamp > $voucher_date_timestamp) continue;
      $metal_receipt_voucher = $this->find('id, debit_weight', array('receipt_type' => $receipt_type,
                                                                     'account_name' => $site_name.' '.$hostversion.' '.$receipt_type,
                                                                     'narration' => $site_name.' '.$receipt_type,
                                                                     'voucher_date' => $record['created_date']));
      $data=array('company_id' => 1,
                  'voucher_date' => $record['created_date'],
                  'receipt_type' => $receipt_type,
                  'account_name' => $site_name.' '.$hostversion.' '.$receipt_type,
                  'debit_weight' => $record['weight'],
                  'purity' => $record['purity'],
                  'factory_purity' => $record['purity'],
                  'fine' => $record['fine'],
                  'factory_fine' => $record['fine'],
                  'narration' => $site_name.' '.$receipt_type,
                  'site_name' => $site_name.' '.$hostversion);
      $data['id'] = '';
      if (!empty($metal_receipt_voucher)) $data['id'] = $metal_receipt_voucher['id'];
        
      if(empty($metal_receipt_voucher['debit_weight'])
         || ($metal_receipt_voucher['debit_weight'] != $record['weight'])) {
        $metal_receipt_obj = new metal_receipt_voucher_model($data);
        $metal_receipt_obj->before_validate();
        $metal_receipt_obj->save();
      } 
    }
  }

}