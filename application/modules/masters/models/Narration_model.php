<?php

class Narration_model extends BaseModel {

  protected $table_name = "ac_narration";
  protected $id = "id";
  public $router_class="narrations";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
			array('field' => 'narrations[name]', 'label' => 'Name', 
            'rules' => array('trim','required')));
  }
  // public function check_duplicate_purity($purity) {
  //   return parent::check_unique('purity');
  // } 
}
