<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_receipt_voucher_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $insert_to_ledger = true;
  protected $id = "id";

  function __construct() {
      parent::__construct();
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'bank_receipt_voucher[voucher_date]', 
        'label' => 'Date',
        'rules' => array('trim', 'required', 
                    array('validate_voucher_date', array($this->bank_receipt_voucher_model, 'check_period_exists'))),
        'errors'=>array('validate_voucher_date' => "Please set the period from master.")),
      array(
        'field' => 'bank_receipt_voucher[account_name]', 
        'label' => 'Account Name',
        'rules' => 'trim|required'),
      array(
        'field' => 'bank_receipt_voucher[debit_amount]', 
        'label' => 'Debit Amount',
        'rules' => 'trim|required|numeric|greater_than[0]'),
      array(
        'field' => 'bank_receipt_voucher[cheque_number]', 
        'label' => 'Check Number',
        'rules' => 'trim|numeric'),
      array(
        'field' => 'bank_receipt_voucher[bank_name]', 
        'label' => 'Bank Name',
        'rules' => array('trim', 'required', 
                    array('validate_bank_name', array($this->bank_receipt_voucher_model, 'verify_bank_name'))),
        'errors'=>array('validate_bank_name' => "Invalid bank name!.")), 
    );
  }

  public function check_period_exists($voucher_date) {
    $voucher_date=date('Y-m-d',strtotime($voucher_date));  
    $period_id = $this->period_model->get('id',
                                          array(
                                            array('"'.$voucher_date.'" between date_from and date_to'=>NULL)));
    if(!empty($period_id[0]['id']))
      return $period_id[0]['id'];
    else
      return false;
  }

  public function verify_bank_name($bank_name) {
    $bank_id = $this->account_model->get('id',
                                          array(
                                            array('name'=>$bank_name),
                                            array('group_code'=>'bank')));
    if(!empty($bank_id[0]['id'])) {
      $_POST[$this->router->class]['bank_id']=@$bank_id[0]['id'];
      return $bank_id[0]['id'];
    }
    else
      return false;
  }

  public function save_association_data($data, $action) {
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):1);
    $voucher_number = $this->delete_ledger_voucher_record($data['id'],$company_id);
    $table_name = $this->get_table_name();

    if (in_array($this->router->class, array('cash_issue_voucher', 'cash_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'cash';
    }
    if (in_array($this->router->class, array('bank_issue_voucher', 'bank_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'bill';
    }
    if (in_array($this->router->class, array('metal_issue_voucher', 'metal_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'metal';
    }
  
    if ($voucher_number) {
      $ledger_data['account_id'] = $data['account_id'];
      $ledger_data['account_name'] = $data['account_name'];
      $ledger_data['voucher_type'] = 'bank issue voucher';
      $ledger_data['suffix'] = 'BR';
      $ledger_data['voucher_date'] = $data['voucher_date'];
      $ledger_data['debit_amount'] = $data['debit_amount'];
      if(!empty($data['bank_id'])) {
        $ledger_data['bank_id'] = $data['bank_id'];  
      }
      if(!empty($data['bank_name'])) {
        $ledger_data['bank_name'] = $data['bank_name'];  
      }
      if(!empty($data['cheque_number'])) {
        $ledger_data['cheque_number'] = $data['cheque_number'];  
      }
      $ledger_data['table_name'] = $table_name;
      $ledger_data['table_id'] = $data['id'];
      $ledger_data['voucher_number'] = $voucher_number;
      $ledger_data['company_id'] = $company_id;
      $ledger_data['created_at'] = date('Y-m-d H:i:s');
      $this->Ledger_model->store($ledger_data);
    } else {
        return;
    }
  }

  public function delete_association_data($id) {
    $ledger_id=$this->Ledger_model->get('id',
                                        array(
                                          array(
                                            'table_id'=>$id)));
    if(!empty($ledger_id)) {
      foreach ($ledger_id as $k_ledger => $ledgerid) :
        if(!empty($ledgerid["id"])) 
          $this->Ledger_model->delete($ledgerid["id"]);
      endforeach;
    }
  }
}

//class