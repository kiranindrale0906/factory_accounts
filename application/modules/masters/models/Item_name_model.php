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
			array('field' => 'item_names[name]', 'label' => 'Name', 
            'rules' => array('trim','required',array('unique_name',
                                            array($this, 'check_name_unique')), 'errors'=> array('unique_name' => "The selected  name already exist.")),
            ),
      );
  }
  public function check_name_unique(){
    $fields = array('name');
    return parent::check_unique($fields);
  }
  public function check_special_charactor($fields){
     $charactors = preg_match('/[^a-zA-Z0-9.\d]/', $fields);
     if($charactors!=0){
     return false;
     }else{
      return true;
     }
   } 
}
