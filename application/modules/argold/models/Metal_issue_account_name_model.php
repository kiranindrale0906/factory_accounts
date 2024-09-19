<?php

class Metal_issue_account_name_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  public $router_class = "metal_issue_account_names";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
    $this->load->model(array('masters/account_model', 'transactions/rate_cut_issue_voucher_model'));
  }
  
  public function before_validate() {
    $this->attributes['voucher_date']=date('Y-m-d',strtotime($this->attributes['voucher_date']));
  }

  public function validation_rules($klass='') {
    $rules[] = array('field' => 'metal_issue_account_names[account_name]', 
                     'label' => 'Weight',
                     'rules' => 'trim|required');
    return $rules;
  }
  public function before_save($action) {
    $this->attributes['is_export']=!empty($_POST['metal_issue_account_names']['is_export'])?$_POST['metal_issue_account_names']['is_export']:0;
    $this->attributes['do_not_calculate_tax']=!empty($_POST['metal_issue_account_names']['do_not_calculate_tax'])?$_POST['metal_issue_account_names']['do_not_calculate_tax']:0;
    $account_detail=$this->account_model->find('id',array('name'=>$this->attributes['account_name']));
    $this->attributes['account_id']=$account_detail['id'];

  }
  public function after_save($action) {
   $reference_voucher_details = $this->get('',array('metal_receipt_voucher_reference_id'=>$this->attributes['id']));
   $voucher_details = $this->find('is_export',array('id'=>$this->attributes['id']));
   if(!empty($reference_voucher_details)){
    foreach ($reference_voucher_details as $index => $reference_voucher_detail) {
      $voucher_obj = new voucher_model($reference_voucher_detail);
      $voucher_obj->attributes['is_export'] = $voucher_details['is_export'];
      $voucher_obj->update('false');
    }
   }
  }
}