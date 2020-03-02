<?php

class State_model extends BaseModel {

    protected $table_name = "ac_state";
    protected $id = "id";

    function __construct() {
        parent::__construct();
    }

    public function validation_rules($klass='') {
    	return array(
      			array('field' => 'state[name]', 'label' => 'Name', 'rules' => 'trim|required')
      		);
    }
}

//class