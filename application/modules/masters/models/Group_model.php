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

  public function after_save($action){
    $sub_groups=$this->sub_group_model->find('route_group,group_id',array('group_id'=>$this->attributes['id']));

    if($action=='update' && $sub_groups['route_group']!=$this->attributes['route_group']){
      $sub_group_process=array(
        'route_group'=>$this->attributes['route_group']
        );
      $sub_group_condition=array('group_id'=>$sub_groups['group_id']);
      $process_obj = new sub_group_model($sub_group_process);
      $process_obj->update(false,$sub_group_condition); 

      $account_process=array(
        'route_group'=>$this->attributes['route_group']
        );
      $account_condition=array('group_id'=>$sub_groups['group_id']);
      $process_obj = new account_model($account_process);
      $process_obj->update(false,$account_condition); 
    }

  }
}
