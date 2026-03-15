<?php

class Narration_model extends BaseModel {

  protected $table_name = "ac_narration";
  protected $id = "id";
  public $router_class="narrations";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
			array('field' => 'narrations[name]', 'label' => 'Name', 
            'rules' => array('trim','required',array('unique_department',
                                            array($this, 'check_department_unique')),
            array('category_special_charactor',array($this, 'check_special_charactor'))),
            'errors'=> array('unique_department' => "The selected combination of name and purity already exist.",'category_special_charactor' => "Remove special charactor from category..")),
      array('field' => 'narrations[chain_purity]', 'label' => 'Purity', 
            'rules' => array('trim','required')),
      array('field' => 'narrations[chain_margin]', 'label' => 'Wastage', 
            'rules' => array('trim','required')));
  }
  public function check_department_unique(){
    $fields = array('name', 'chain_purity');
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
