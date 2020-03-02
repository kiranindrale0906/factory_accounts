<?php

class Salesman_model extends BaseModel {
  protected $table_name = "ac_salesman";
  protected $id = "id";

  function __construct() {
      parent::__construct();
  }

  public function validation_rules($klass='') {
  	return array(
    	array(
        'field' => 'salesman[name]', 
        'label' => 'Name', 
        'rules' => 'trim|required'),
    	array(
        'field' => 'salesman[salesman_code]', 
        'label' => 'Salesman Code', 
        'rules' => 'trim|required'),
    );
  }
}

//class

