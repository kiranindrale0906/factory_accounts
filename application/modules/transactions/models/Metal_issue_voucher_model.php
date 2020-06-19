<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Metal_issue_voucher_client_model.php";
class Metal_issue_voucher_model extends Metal_issue_voucher_client_model {
  public $router_class = "metal_issue_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }

   public function before_validate() {
    $this->attributes['fine']=$this->attributes['credit_weight']*$this->attributes['purity']/100;
  }


  public function after_save($action) {
    $this->create_metal_receipt_voucher();
  }

  private function create_metal_receipt_voucher() {
  	if (empty($this->attributes['metal_receipt_voucher_reference_id'])) return true;

    $this->load->model('transactions/metal_receipt_voucher_model');
    $metal_receipt_data = array();
    
    $issue_voucher_account_name = $this->account_model->find('name', array('id' => $this->attributes['account_id']))['name'];
    $metal_receipt_data['company_id'] = $this->company_model->find('id', array('name' => $issue_voucher_account_name))['id'];

    $metal_receipt_data['metal_receipt_voucher_reference_id'] = $this->attributes['id'];
    $metal_receipt_data['voucher_date'] = $this->attributes['voucher_date'];
    
    $receipt_voucher_company_name = $this->company_model->find('name', array('id' => $this->attributes['company_id']))['name'];
    $metal_receipt_data['account_name'] = $receipt_voucher_company_name;
    $metal_receipt_data['account_id'] = $this->account_model->find('id', array('name' => $receipt_voucher_company_name))['id'];
    
    $metal_receipt_data['debit_weight'] = $this->attributes['credit_weight'];
    $metal_receipt_data['purity'] = $this->attributes['factory_purity'];
    $metal_receipt_data['factory_purity'] = $this->attributes['factory_purity'];
    $metal_receipt_data['fine'] = $this->attributes['credit_weight'] * $this->attributes['factory_purity'] / 100;
    $metal_receipt_data['factory_fine'] = $metal_receipt_data['fine'];
    $metal_receipt_data['narration'] = $this->attributes['narration'];
    $metal_receipt_data['suffix'] = "MR";
    $metal_receipt_data['voucher_type'] = "metal receipt voucher";
    $metal_receipt_data['transaction_type'] = 'account';
      
    $obj_metal_receipt_voucher=new metal_receipt_voucher_model($metal_receipt_data);
    $obj_metal_receipt_voucher->store();
  }
    
}
?>