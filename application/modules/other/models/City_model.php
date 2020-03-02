<?php

class City_model extends BaseModel {

    protected $table_name = "ac_city";
    protected $id = "id";

    function __construct() {
        parent::__construct();
    }

    public function validation_rules($klass='') {
    	return array(
      			array('field' => 'city[name]', 'label' => 'Name', 'rules' => 'trim|required')
      		);
    }

}

//class