<?php

class Unrecovarable_account_record_model extends BaseModel {
  protected $table_name= 'ac_vouchers';
  public $router_class= 'unrecovarable_account_records';
  public function __construct($data = array()){
    parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules = array(array('field' => 'unrecovarable_account_records[credit_weight]', 'label' => 'Credit Weight',
                         'rules' => 'required'));
    return $rules;
  }
}