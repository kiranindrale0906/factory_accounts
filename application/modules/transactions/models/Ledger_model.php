<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_model extends BaseModel {
  protected $table_name = "ac_ledger";
  protected $id = "id";

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('ac_vouchers/voucher_model'));
  }

  public function regenerate_ledger_records($limit_date=0) {
    /*if($limit_date==1){
    $this->delete('', array('id > ' => 0,'(month(voucher_date) between "4" and "5") and year(voucher_date)<=2022'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('(month(voucher_date) between "4" and "5") and (year(voucher_date)<=2022)'=>NULL));
    }

    $current_month=date('m');
    if($limit_date==2){
    $this->delete('', array('id > ' => 0,'(month(voucher_date) between "5" and "6") and year(voucher_date)<=2022'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('(month(voucher_date) between "5" and "6") and (year(voucher_date)<=2022)'=>NULL));
    }
    if($limit_date==3){
    $this->delete('', array('id > ' => 0,'(month(voucher_date) between "7" and "8") and year(voucher_date)<=2022'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('(month(voucher_date) between "7" and "8") and (year(voucher_date)<=2022)'=>NULL));
    }
    if($limit_date==4){
    $this->delete('', array('id > ' => 0,'(month(voucher_date) between "8" and "9") and year(voucher_date)<=2022'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('(month(voucher_date) between "8" and "9") and (year(voucher_date)<=2022)'=>NULL));
    }
    if($limit_date==5){
    $this->delete('', array('id > ' => 0,'(month(voucher_date) between "9" and "12") and year(voucher_date)<=2022'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('(month(voucher_date) between "9" and "12") and (year(voucher_date)<=2022)'=>NULL));
    }*/if($limit_date==6){
    $this->delete('', array('id > ' => 0,'(month(voucher_date) between "1" and "3") and year(voucher_date)=2023'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('(month(voucher_date) between "1" and "3") and (year(voucher_date)=2023)'=>NULL));
    }if($limit_date==7){
    $this->delete('', array('id > ' => 0,'(month(voucher_date) between "4" and "7") and year(voucher_date)=2023'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('(month(voucher_date) between "4" and "7") and (year(voucher_date)=2023)'=>NULL));
    }
    if($limit_date==8){
    $this->delete('', array('id > ' => 0,'month(voucher_date) >=8 and year(voucher_date)=2023'=>NULL));
    $voucher_ids = $this->voucher_model->get('id',array('month(voucher_date) >=8 and year(voucher_date)=2023'=>NULL));
    }
    foreach ($voucher_ids as $voucher_id) {
      $ledger_obj = new Ledger_model(array('voucher_id' => $voucher_id['id']));
      $ledger_obj->before_validate();
      $ledger_obj->save();
    }
  }
  
  public function before_validate() {
    if (empty($this->attributes['voucher_id'])) {
      echo 'Voucher ID cannot be empty for Ledger';
      exit;
    }

    $existing_ledger_record = $this->find('id', array('voucher_id' => $this->attributes['voucher_id']));
    if (!empty($existing_ledger_record)) 
      $this->attributes['id'] = $existing_ledger_record['id'];

    $this->initialize($this->attributes['voucher_id']);
    $this->set_attributes_from_vouchers();
  }

  private function initialize($voucher_id) {
    $voucher = $this->voucher_model->find('', array('id' => $this->attributes['voucher_id']));
    $this->attributes['voucher_id'] = $voucher['id'];
    $this->attributes['company_id'] = $voucher['company_id'];
    $this->attributes['period_id'] = $voucher['period_id'];
    $this->attributes['voucher_number'] = $voucher['voucher_number'];
    $this->attributes['account_name'] = $voucher['account_name'];
    $this->attributes['account_id'] = $voucher['account_id'];
    $this->attributes['voucher_date'] = $voucher['voucher_date'];
    $this->attributes['narration'] = $voucher['narration'];
    $this->attributes['voucher_type'] = $voucher['voucher_type'];
    $this->attributes['transaction_type'] = $voucher['transaction_type'];
    $this->attributes['credit_amount'] = $voucher['credit_amount'];
    $this->attributes['debit_amount'] = $voucher['debit_amount'];
    $this->attributes['usd_credit_amount'] = $voucher['usd_credit_amount'];
    $this->attributes['usd_debit_amount'] = $voucher['usd_debit_amount'];
    $this->attributes['usd_rate'] = $voucher['usd_rate'];
    $this->attributes['credit_weight'] = $voucher['credit_weight'];
    $this->attributes['debit_weight'] = $voucher['debit_weight'];
    $this->attributes['purity'] = $voucher['purity'];
    $this->attributes['factory_purity'] = $voucher['factory_purity'];
    $this->attributes['receipt_type'] = $voucher['receipt_type'];
    $this->attributes['type'] = $voucher['type'];
    $this->attributes['fine'] = $voucher['fine'];
    $this->attributes['factory_fine'] = $voucher['factory_fine'];
    $this->attributes['gold_rate'] = $voucher['gold_rate'];
    $this->attributes['chitti_id'] = $voucher['chitti_id'];
    $this->attributes['description'] = $voucher['description'];
    $this->attributes['site_name'] = $voucher['site_name'];
    $this->attributes['sale_type'] = $voucher['sale_type'];
    $this->attributes['parent_id'] = $voucher['metal_receipt_voucher_reference_id'];
    $this->attributes['is_export'] = $voucher['is_export'];
  }
  
  private function set_attributes_from_vouchers() {
    if (empty($this->attributes['chitti_id'])) $this->attributes['chitti_id'] = $this->attributes['voucher_id'];
    if (empty($this->attributes['parent_id'])) $this->attributes['parent_id'] = $this->attributes['voucher_id'];

    //to display debit weight and credit amount on the issue side in Swarnshilp Ledger
    if ($this->attributes['voucher_type'] == 'rate cut receipt voucher') {
      if ($this->attributes['chitti_id'] != $this->attributes['voucher_id']) {
        $this->attributes['credit_weight'] = 0;
        $this->attributes['debit_weight'] = 0;
        $this->attributes['purity'] = 0;
        $this->attributes['factory_purity'] = 0;
        $this->attributes['fine'] = 0;
        $this->attributes['factory_fine'] = -1 * $this->attributes['factory_fine'];  
      }
    } 

    if ($this->attributes['voucher_type'] == 'rate cut issue voucher') {
      $this->attributes['credit_weight'] = 0;
      $this->attributes['debit_weight'] = 0;
      $this->attributes['purity'] = 0;
      $this->attributes['factory_purity'] = 0;
      if ($this->attributes['chitti_id'] == $this->attributes['voucher_id']) {  
        $this->attributes['fine'] = -1 * $this->attributes['fine'];
        $this->attributes['factory_fine'] = 0;
      } else {
        $this->attributes['credit_amount'] = -1 * $this->attributes['debit_amount'];
        $this->attributes['debit_amount'] = 0;
      }
    } 

    //to display credit amount with weight in Purchase Account Ledger
    if ($this->attributes['voucher_type'] == 'rate cut receipt voucher'  && $this->attributes['chitti_id'] == $this->attributes['voucher_id']) {
      $this->attributes['debit_amount'] = -1 * $this->attributes['credit_amount'];
      $this->attributes['credit_amount'] = 0;
    }
  }
}
