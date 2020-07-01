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
                                            array($this, 'check_department_unique'))),
            'errors'=> array('unique_department' => "The selected combination of name and purity already exist.")),
      array('field' => 'narrations[chain_purity]', 'label' => 'Purity', 
            'rules' => array('trim','required')),
      array('field' => 'narrations[chain_margin]', 'label' => 'Margin', 
            'rules' => array('trim','required')));
  }
  public function check_department_unique(){
    $fields = array('name', 'chain_purity');
    return parent::check_unique($fields);
  }
}
