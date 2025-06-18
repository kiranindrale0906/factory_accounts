<?php

class Item_name_model extends BaseModel {

  protected $table_name = "ac_item_names";
  protected $id = "id";
  public $router_class="item_names";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
			array(
        'field' => 'item_names[name]', 
        'label' => 'name', 
        'rules'  =>array('trim','required',
                    array('check_name_error',array($this,'check_duplicate_name'))),
        'errors' => array('check_name_error'=>'Item name already exists.')),
      
      );
  }

  public function check_duplicate_name($name) {
    return parent::check_unique('name');
  }
  
}
