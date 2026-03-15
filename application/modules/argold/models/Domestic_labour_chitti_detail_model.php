<?php

class Domestic_labour_chitti_detail_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'domestic_labour_chitti_details[domestic_labour_chitti_id]', 
                     'label' => 'domestic_labour_chitti_id',
                     'rules' => 'trim|required');
    return $rules;
  }
}