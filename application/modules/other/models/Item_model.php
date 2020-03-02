<?php

class Item_model extends BaseModel {

    protected $table_name = "ac_item";
    protected $id = "id";

    function __construct() {
        parent::__construct();
    }

    public function validation_rules($klass='') {
    	return array(
      			array('field' => 'item[name]', 'label' => 'Name', 'rules' => 'trim|required'),
      			array('field' => 'item[item_code]', 'label' => 'Item Code', 'rules' => 'trim|required'),
            array('field' => 'item[avg_melting]', 'label' => 'Avg. Melting', 'rules' => 'trim|required|numeric'),
            array('field' => 'item[melting_from]', 'label' => 'Melting From', 'rules' => 'trim|required|numeric|less_than_equal_to[100]'),
            array('field' => 'item[melting_to]', 'label' => 'Melting To', 'rules' => 'trim|required|numeric|less_than_equal_to[100]'),

      		);
    }

}

//class

