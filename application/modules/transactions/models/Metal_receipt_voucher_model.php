<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Metal_receipt_voucher_model extends Voucher_model {
  protected $prefix = 'MR';
  protected $voucher_type = 'metal receipt voucher';
  protected $account_type = 'account';
  public $router_class = "metal_receipt_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'metal_receipt_vouchers[voucher_date]', 
        'label' => 'Date',
        'rules' => array('trim', 'required', 
                    array('validate_voucher_date', array($this, 'check_period_exists'))),
        'errors'=>array('validate_voucher_date' => "Please set the period from master.")),
      array(
        'field' => 'metal_receipt_vouchers[purity]', 
        'label' => 'Purity',
        'rules' => 'trim|required|numeric|less_than_equal_to[100]'),
      array(
        'field' => 'metal_receipt_vouchers[account_name]', 
        'label' => 'Account Name',
        'rules' => 'trim|required'),
      array(
        'field' => 'metal_receipt_vouchers[debit_weight]', 
        'label' => 'Debit Weight',
        'rules' => 'trim|required|numeric|greater_than[0]'),
    );
  }

  // public function save_association_data($data, $action) {
  //   $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):1);
  //   $voucher_number = $this->delete_ledger_voucher_record($data['id'],$company_id);
  //   $table_name = $this->get_table_name();

  //   if (in_array($this->router->class, array('cash_issue_voucher', 'cash_receipt_voucher'))) {
  //     $ledger_data['cash_bill_type'] = 'cash';
  //   }
  //   if (in_array($this->router->class, array('bank_issue_voucher', 'bank_receipt_voucher'))) {
  //     $ledger_data['cash_bill_type'] = 'bill';
  //   }
  //   if (in_array($this->router->class, array('metal_issue_voucher', 'metal_receipt_voucher'))) {
  //     $ledger_data['cash_bill_type'] = 'metal';
  //   }
    
  //   if ($voucher_number) {
  //     $ledger_data['account_id'] = $data['account_id'];
  //     $ledger_data['account_name'] = $data['account_name'];
  //     $ledger_data['voucher_type'] = 'metal issue voucher';
  //     $ledger_data['voucher_date'] = $data['voucher_date'];
  //     $ledger_data['debit_weight'] = $data['debit_weight'];
  //     $ledger_data['purity'] = $data['purity'];
  //     $ledger_data['purity_id'] = $data['purity_id'];
  //     $ledger_data['pure_gold'] = $data['pure_gold_debit'];
  //     $ledger_data['table_name'] = $table_name;
  //     $ledger_data['table_id'] = $data['id'];
  //     $ledger_data['voucher_number'] = $voucher_number;
  //     $ledger_data['suffix'] = 'MI';
  //     $ledger_data['company_id'] = $company_id;
  //     $ledger_data['created_at'] = date('Y-m-d H:i:s');
  //     $this->Ledger_model->store($ledger_data);
  //   } else {
  //       return;
  //   }
  // }

  // public function delete_association_data($id) {
  //   $ledger_id=$this->Ledger_model->get('id',
  //                                       array(
  //                                         array(
  //                                           'table_id'=>$id)));
  //   if(!empty($ledger_id)) {
  //     foreach ($ledger_id as $k_ledger => $ledgerid) :
  //       if(!empty($ledgerid["id"])) 
  //         $this->Ledger_model->delete($ledgerid["id"]);
  //     endforeach;
  //   }
  // }
}

//class