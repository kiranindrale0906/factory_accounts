<?php

class Sm_model extends BaseModel {

  protected $table_name = "ac_sms";
  protected $id = "id";

  function __construct() {
      parent::__construct();
  }

  public function validation_rules($klass='') {
  	return array(
			array(
        'field' => 'sms[short_message]', 
        'label' => 'Short Message', 
        'rules' => 'trim|required'),
			array(
        'field' => 'sms[tvariable]', 
        'label' => 'Tvariable', 
        'rules' => 'trim|required'),
      array(
        'field' => 'sms[type]', 
        'label' => 'Type', 
        'rules' => 'trim|required'),
      array(
        'field' => 'sms[company_code]', 
        'label' => 'Comapny Code', 
        'rules' => 'trim|required'),
      array(
        'field' => 'sms[message]', 
        'label' => 'Message', 
        'rules' => 'trim|required'),
		);
  }

}

//class

