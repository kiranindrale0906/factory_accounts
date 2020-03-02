<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Journal_voucher_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $insert_to_ledger = true;
  protected $id = "id";

  function __construct() {
      parent::__construct();
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'journal_voucher[voucher_date]', 
        'label' => 'Date',
        'rules' => array('trim', 'required', 
                    array('validate_voucher_date', array($this->journal_voucher_model, 'check_period_exists'))),
        'errors'=>array('validate_voucher_date' => "Please set the period from master.")),
      array(
        'field' => 'journal_voucher[account_name]', 
        'label' => 'To Account Name',
        'rules' => 'trim|required'),
      array(
        'field' => 'journal_voucher[from_account_name]', 
        'label' => 'From Account Name',
        'rules' => 'trim|required'),
      array(
        'field' => 'journal_voucher[amount]', 
        'label' => 'Amount',
        'rules' => 'trim|required|numeric|greater_than[0]'),
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

  public function save_association_data($data, $action) {
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):1);
    $voucher_number = $this->delete_ledger_voucher_record($data['id'],$company_id);
    $table_name = $this->get_table_name();
    
    if ($voucher_number) {
      $ledger_data['account_id'] = $data['account_id'];
      $ledger_data['from_account_id'] = $data['from_account_id'];
      $ledger_data['account_name'] = $data['account_name'];
      $ledger_data['from_account_name'] = $data['from_account_name'];
      $ledger_data['voucher_type'] = 'journal voucher';
      $ledger_data['voucher_date'] = $data['voucher_date'];
      $ledger_data['amount'] = $data['amount'];
      $ledger_data['table_name'] = $table_name;
      $ledger_data['table_id'] = $data['id'];
      $ledger_data['voucher_number'] = $voucher_number;
      $ledger_data['suffix'] = 'JV';
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