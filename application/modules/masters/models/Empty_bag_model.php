<?php

class Empty_bag_model extends BaseModel {

  protected $table_name = "empty_bags";
  protected $id = "id";
  public $router_class="empty_bags";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
            array('field' => 'empty_bags[weight]', 'label' => 'Weight', 
            'rules' => array('trim','required','numeric')),
            array('field' => 'empty_bags[qty]','label' => 'Quantity', 
            'rules' => array('trim','required','numeric')));
  }
}
