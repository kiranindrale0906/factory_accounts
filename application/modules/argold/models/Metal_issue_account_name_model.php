<?php

class Metal_issue_account_name_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  public $router_class = "metal_issue_account_names";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
    $this->load->model(array('masters/account_model', 'transactions/rate_cut_issue_voucher_model'));
  }
  
  // public function after_save($action) {
  //   parent::after_save($action);
  //   $this->rate_cut_issue_voucher_model->create_rate_cut_vouchers_for_metal_and_refresh($this->attributes['id'], $this->attributes['receipt_type']);
  // }

  public function validation_rules($klass='') {
    $rules[] = array('field' => 'metal_issue_account_names[account_name]', 
                     'label' => 'Weight',
                     'rules' => 'trim|required');
    return $rules;
  }
}