<?php

class Loss_account_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'loss_accounts[account_name]', 
                     'label' => 'Account Name',
                     'rules' => 'trim|required');
    return $rules;
  }
}