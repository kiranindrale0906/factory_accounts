<?php

class Metal_receipt_gold_rate_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  public $router_class = "metal_receipt_gold_rates";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
    $this->load->model(array('masters/account_model', 'transactions/rate_cut_issue_voucher_model'));
  }
  
  public function after_save($action) {
    parent::after_save($action);
    $this->rate_cut_issue_voucher_model->create_rate_cut_vouchers_for_metal_and_refresh($this->attributes['id'], $this->attributes['receipt_type']);
  }
  public function before_save($action) {
    $this->attributes['is_export']=!empty($_POST['metal_receipt_gold_rates']['is_export'])?$_POST['metal_receipt_gold_rates']['is_export']:0;
  }

  public function validation_rules($klass='') {
    $rules[] = array('field' => 'metal_receipt_gold_rates[gold_rate]', 
                     'label' => 'Weight',
                     'rules' => 'trim|required|numeric|greater_than_equal_to[0]');
    return $rules;
  }
}