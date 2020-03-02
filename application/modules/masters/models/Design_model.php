<?php

class Design_model extends BaseModel {

  protected $table_name = "ac_designs";
  protected $id = "id";

  function __construct() {
      parent::__construct();
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'design[name]', 
        'label' => 'Design Name', 
        'rules' => 'trim|required'),
    	array(
        'field' => 'design[code]', 
        'label' => 'Design Code', 
        'rules' => 'trim|required')
    );
  }

}

//class