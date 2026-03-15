<?php

class Department_model extends BaseModel {
  protected $table_name = "ac_department";
  protected $id = "id";
  public $router_class="department";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
    	array(
  			'field' => 'department[name]', 
  			'label' => 'Department Name', 
  			'rules' => array('trim','required',
                      array('error_msg_department',array($this,'check_department'))),
        'errors'=>  array('error_msg_department'=>'Department already exists'))
    );
  }

  public function before_save($action) {
    $this->formdata['department']['taggable']=(!empty($this->attributes['taggable'])?$this->attributes['taggable']:0);
  }

  public function check_department($purity) {
    return parent::check_unique('name');
  } 
}