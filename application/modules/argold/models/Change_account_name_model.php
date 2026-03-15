<?php

class Change_account_name_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules[] = array('field' => 'change_account_names[account_name]', 
                     'label' => 'Account Name',
                     'rules' => 'trim|required');
    return $rules;
  }
}