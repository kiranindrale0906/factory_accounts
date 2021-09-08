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
      	'label' => 'Name', 
      	'rules'  =>array('trim','required',
                    array('name_error_msg',array($this,'check_duplicate_name'))),
        'errors' => array('name_error_msg'=>'Default Name already exists.')),
      array(
        'field' => 'settings[value]', 
        'label' => 'Value', 
        'rules' => array('trim','required'))
    );
  }

  public function check_duplicate_name($name) {
    return parent::check_unique('name');
  }

}

//class