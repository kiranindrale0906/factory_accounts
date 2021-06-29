<?php

class Ghiss_melting_quator_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules[] = array('field' => 'ghiss_melting_quators[id]', 
                     'label' => 'Id',
                     'rules' => 'trim|required');
    return $rules;
  }
}