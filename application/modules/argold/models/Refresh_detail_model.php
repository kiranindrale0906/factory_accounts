<?php

class Refresh_detail_model extends BaseModel {

  protected $table_name = "refresh_details";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'refresh_details[refresh_id]', 
                     'label' => 'refresh_id',
                     'rules' => 'trim|required');
    
    return $rules;
  }
}