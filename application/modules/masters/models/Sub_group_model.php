<?php

class Sub_group_model extends BaseModel {

  protected $table_name = "ac_sub_groups";
  public $router_class="sub_groups";
  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function before_validate() {
    $groups=$this->group_model->find('id as id',array(
                                                  'name'=>$this->attributes['group_name']));
    $this->formdata[$this->router_class]['group_id']=@$groups['id'];
  }

  public function validation_rules($klass='') {
    return array(
      array(
      	'field' => 'sub_groups[name]', 
      	'label' => 'Name', 
      	'rules'  =>array('trim','required',
                    array('sub_group_name_error_msg',array($this,'check_duplicate_name'))),
        'errors' => array('sub_group_name_error_msg'=>'Sub Group name already exists.')),
       array(
        'field' => 'sub_groups[group_name]', 
        'label' => 'Name', 
        'rules'  =>array('trim','required',
                    array('group_name_error_msg',array($this,'check_group_name_exist'))),
        'errors' => array('group_name_error_msg'=>'Group name not exist in group master.')));
  }
  public function check_duplicate_name($name) {
    return parent::check_unique('name');
  }

  public function check_group_name_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $groups=$this->group_model->find('id as id',array('name'=>$name));
    return (empty($groups)) ? false : true;
  }
}
