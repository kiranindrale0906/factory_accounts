<?php

class Sub_group_model extends BaseModel {

  protected $table_name = "ac_sub_groups";
  public $router_class="sub_groups";
  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function before_validate() {
    $groups=$this->group_model->find('id as id,route_group',array(
                                                  'name'=>$this->attributes['group_name']));
    $this->formdata[$this->router_class]['group_id']=@$groups['id'];
    $this->formdata[$this->router_class]['route_group']=@$groups['route_group'];
  }


  public function after_save($action){
    $accounts=$this->account_model->find('group_id',array('sub_group_id'=>$this->attributes['id']));
    if($action=='update' && $accounts['group_id']!=$this->attributes['group_id']){
      $start_process=array(
        'group_id'=>$this->attributes['group_id'],
        'group_code'=>$this->attributes['group_name'],
        'route_group'=>$this->attributes['route_group']
        );
      $condition=array('group_id'=>$accounts['group_id']);
      $process_obj = new account_model($start_process);
      $process_obj->update(false,$condition); 
    }

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
    $groups=$this->group_model->find('id as id',array('name'=>$name));
    return (empty($groups)) ? false : true;
  }
}
