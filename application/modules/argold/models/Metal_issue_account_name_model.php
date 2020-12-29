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
}