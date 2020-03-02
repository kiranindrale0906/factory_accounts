<?php

class Category_model extends BaseModel {

    protected $table_name = "ac_category";
    protected $id = "id";

    function __construct() {
        parent::__construct();
    }

    public function validation_rules($klass='') {
    	return array(
      			array('field' => 'category[name]', 'label' => 'Name', 'rules' => 'trim|required'),
      			array('field' => 'category[category_code]', 'label' => 'Category Code', 'rules' => 'trim|required'),
            array('field' => 'category[avg_melting]', 'label' => 'Avg. Melting', 'rules' => 'trim|required|numeric')
      		);
    }

}

//class