<?php

class Combine_chitti_detail_model extends BaseModel {
  protected $table_name = "chitties";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'combine_chitti_details[combine_chitti_id]', 
                     'label' => 'combine_chitti_id',
                     'rules' => 'trim|required');
    return $rules;
  }
}