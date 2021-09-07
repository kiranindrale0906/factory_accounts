<?php

class Quator_model extends BaseModel {

  protected $table_name = "ac_quators";
  protected $id = "id";
  public $router_class="quators";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
			array('field' => 'quators[name]', 'label' => 'Name', 
            'rules' => array('trim','required',array('error_msg_quator',array($this,'check_duplicate_quator'))),
            'errors'=>  array('error_msg_quator'=>'Name already exists'))
		);
  }

  public function check_duplicate_quator($name) {
    return parent::check_unique('name');
  } 
}
