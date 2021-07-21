<?php

class Packing_slip_detail_model extends BaseModel {

  protected $table_name = "packing_slip_details";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'packing_slip_details[packing_slip_id]', 
                     'label' => 'packing_slip_id',
                     'rules' => 'trim|required');
    return $rules;
  }
}