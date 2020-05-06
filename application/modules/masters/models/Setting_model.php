<?php

class Setting_model extends BaseModel {

  protected $table_name = "ac_settings";
  protected $id = "id";
  public $router_class = "settings";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array(
      	'field' => 'settings[name]', 
      	'label' => 'Company Name', 
      	'rules' => array('trim','required')),
      array(
        'field' => 'settings[value]', 
        'label' => 'Decimal No.', 
        'rules' => array('trim','required'))
    );
  }

  public function check_duplicate_company_name($name) {
    return parent::check_unique('name');
  }

}

//class