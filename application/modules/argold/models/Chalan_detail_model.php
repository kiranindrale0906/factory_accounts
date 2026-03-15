<?php

class Chalan_detail_model extends BaseModel {
  protected $table_name = "chitties";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'chalan_details[chalan_id]', 
                     'label' => 'packing_slip_id',
                     'rules' => 'trim|required');
    return $rules;
  }
}