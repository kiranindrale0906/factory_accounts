<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/models/Core_metal_issue_voucher_model.php";
class Client_metal_issue_voucher_model extends Core_metal_issue_voucher_model {
  
  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('argold/client_metal_receipt_voucher_model', 'masters/narration_model'));
  }
  
  public function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    $rules[] = $this->get_account_validation_rules();
    $rules[] = $this->get_factory_purity_validation_rules();
    if ($this->attributes['receipt_type'] != 'Pending Ghiss')
      $rules[] = $this->get_narration_validation_rules();
    return $rules;
  }

  public function before_validate() {
    if ($this->attributes['receipt_type'] == 'Tounch Loss Fine') return;
    if ($this->attributes['receipt_type'] == 'Pending Ghiss') $this->attributes['account_name'] = 'ARF Software';

    $this->attributes['fine'] = $this->attributes['credit_weight'] * $this->attributes['purity'] / 100;
    $this->set_factory_purity_and_factory_fine_from_narration();    
  }

  private function set_factory_purity_and_factory_fine_from_narration() {
    if ($this->attributes['receipt_type'] == 'Pending Ghiss') return;
    
    if (!empty($this->attributes['argold_id'])) return;   //do not set factory purity if set in issue department

    if (   empty($this->attributes['narration']) 
        || $this->attributes['account_name'] != 'SWARN SHILP CHAINS AND JEWELLERS PVT LTD') {
      $this->attributes['factory_purity'] = $this->attributes['purity'];
      $this->attributes['factory_fine'] = $this->attributes['fine'];
    } else {
      $narration_data=$this->narration_model->find('', array('name' => $this->attributes['narration'], 
                                                             'chain_purity'=>$this->attributes['purity']));
      if(!empty($narration_data)){
        $this->attributes['factory_purity'] = $narration_data['chain_purity'] + $narration_data['chain_margin'];
        $this->attributes['factory_fine'] = $this->attributes['credit_weight'] * $this->attributes['factory_purity'] / 100;
      }
    }
  }

  public function after_validate() {
    $this->attributes['fine']=$this->attributes['credit_weight']*$this->attributes['purity'] / 100;
  }

  public function after_save($action) {
    parent::after_save($action);
    $this->create_metal_receipt_voucher_for_finished_goods();
    if (   ENABLE_API_FOR_RECEIPT 
        && $this->attributes['receipt_type'] != 'Internal' 
        && ($this->attributes['account_name'] == 'ARF Software'
            || $this->attributes['receipt_type'] == 'ARF Chain Receipt'
            || $this->attributes['receipt_type'] == 'ARF RND'))
      $this->client_metal_receipt_voucher_model->send_request_to_arf($this->attributes);
  }

  private function create_metal_receipt_voucher_for_finished_goods() {
    if (isset($this->attributes['metal_receipt_voucher_reference_id']) 
        && (!empty($this->attributes['metal_receipt_voucher_reference_id']))) return true;    

    if (   $this->attributes['receipt_type'] == 'AR Gold Finished Goods'
        || $this->attributes['receipt_type'] == 'ARF Finished Goods'
        || $this->attributes['receipt_type'] == 'ARF Software Finished Goods'
        || $this->attributes['receipt_type'] == 'ARC Finished Goods') {
      $this->load->model('transactions/metal_receipt_voucher_model');
      $metal_receipt_data = array();
      $metal_receipt_data['company_id'] = $this->attributes['company_id'];
      $metal_receipt_data['voucher_date'] = $this->attributes['voucher_date'];
      $metal_receipt_data['account_name'] = $this->attributes['receipt_type'];
      $metal_receipt_data['receipt_type'] = $this->attributes['receipt_type'];
    
      $metal_receipt_data['debit_weight'] = $this->attributes['credit_weight'];
      $metal_receipt_data['purity'] = $this->attributes['purity'];
      $metal_receipt_data['factory_purity'] = $this->attributes['purity'];
      $metal_receipt_data['fine'] = $this->attributes['credit_weight'] * $this->attributes['purity'] / 100;
      $metal_receipt_data['factory_fine'] = $metal_receipt_data['fine'];
      $metal_receipt_data['narration'] = $this->attributes['narration'];
      $metal_receipt_data['suffix'] = "MR";
      $metal_receipt_data['voucher_type'] = "metal receipt voucher";
      $metal_receipt_data['transaction_type'] = 'account';
        
      $obj_metal_receipt_voucher=new metal_receipt_voucher_model($metal_receipt_data);
      $obj_metal_receipt_voucher->store();    
    }


    // if (empty($this->attributes['metal_receipt_voucher_reference_id'])) return true;

    // $this->load->model('transactions/metal_receipt_voucher_model');
    // $metal_receipt_data = array();
    
    // $issue_voucher_account_name = $this->account_model->find('name', array('id' => $this->attributes['account_id']))['name'];
    // $metal_receipt_data['company_id'] = $this->company_model->find('id', array('name' => $issue_voucher_account_name))['id'];

    // $metal_receipt_data['metal_receipt_voucher_reference_id'] = $this->attributes['id'];
    // $metal_receipt_data['voucher_date'] = $this->attributes['voucher_date'];
    
    // $receipt_voucher_company_name = $this->company_model->find('name', array('id' => $this->attributes['company_id']))['name'];
    // $metal_receipt_data['account_name'] = $receipt_voucher_company_name;
    // $metal_receipt_data['account_id'] = $this->account_model->find('id', array('name' => $receipt_voucher_company_name))['id'];
    
    // $metal_receipt_data['receipt_type'] = $this->attributes['receipt_type'];
    // $metal_receipt_data['debit_weight'] = $this->attributes['credit_weight'];
    // $metal_receipt_data['purity'] = $this->attributes['factory_purity'];
    // $metal_receipt_data['factory_purity'] = $this->attributes['factory_purity'];
    // $metal_receipt_data['fine'] = $this->attributes['credit_weight'] * $this->attributes['factory_purity'] / 100;
    // $metal_receipt_data['factory_fine'] = $metal_receipt_data['fine'];
    // $metal_receipt_data['narration'] = $this->attributes['narration'];
    // $metal_receipt_data['suffix'] = "MR";
    // $metal_receipt_data['voucher_type'] = "metal receipt voucher";
    // $metal_receipt_data['transaction_type'] = 'account';
      
    // $obj_metal_receipt_voucher=new metal_receipt_voucher_model($metal_receipt_data);
    // $obj_metal_receipt_voucher->store();
  }

}

//class