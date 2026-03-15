<?php

class Product_category_model extends BaseModel {

    protected $table_name = "ac_product_category";
    protected $id = "id";

    function __construct() {
        parent::__construct();
    }

    public function validation_rules($klass='') {
    	return array(
	      	array('field' => 'product_category[name]', 'label' => 'Name', 'rules' => 'trim|required'),
	      	array('field' => 'product_category[percentage]', 'label' => 'Percentage', 'rules' => 'trim|required')
	  	);
    }

}


//class