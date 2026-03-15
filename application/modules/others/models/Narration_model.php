<?php

class Narration_model extends BaseModel {
  protected $table_name = "ac_narration";
  protected $id = "id";
  function __construct() {
      parent::__construct();
  }

  public function validation_rules($klass='') {
  	return array(
			array(
        'field' => 'narration[name]', 
        'label' => 'Narration Name', 
        'rules' => 'trim|required'),
		);
  }

}
//class

