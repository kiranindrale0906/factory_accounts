<?php

class Company_model extends BaseModel {

  protected $table_name = "ac_company";
  protected $id = "id";
  public $router_class = "company";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array(
      	'field' => 'company[name]', 
      	'label' => 'Company Name', 
      	'rules' => array('trim','required',array('company_name_error_msg',array($this,'check_duplicate_company_name'))),
        'errors' => array('company_name_error_msg'=>'Company name already exists.')),
      array(
        'field' => 'company[decimal_no]', 
        'label' => 'Decimal No.', 
        'rules' => array('trim','numeric'),)
    );
  }

  public function check_duplicate_company_name($name) {
    return parent::check_unique('name');
  }

}

//class