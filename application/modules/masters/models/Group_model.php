<?php

class Group_model extends BaseModel {

  protected $table_name = "ac_groups";
  public $router_class="groups";
  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array(
      	'field' => 'groups[name]', 
      	'label' => 'Name', 
      	'rules'  =>array('trim','required',
                    array('group_name_error_msg',array($this,'check_duplicate_name'))),
        'errors' => array('group_name_error_msg'=>'Group name already exists.')));
  }

  public function check_duplicate_name($name) {
    return parent::check_unique('name');
  }
}
