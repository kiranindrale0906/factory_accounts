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
                    array('check_name_error',array($this,'check_name_exist'))),
        'errors' => array('check_name_error'=>'Name is alreay exist.')),
      
      );
  }

  public function check_name_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $item_names=$this->item_name_model->find('id as id',array('name!='=>$name));
    return (empty($item_names)) ? false : true;
  }
  
}
