<?php
class Account_model extends BaseModel {
  protected $table_name = 'ac_account';
  protected $id = 'id';
  public $router_class='accounts'; 
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function before_validate() {
    $this->set_group_data();
    $this->set_account_name_data();
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field'  => 'accounts[name]',
        'label'  => 'Name',
        'rules'  =>array('trim','required',
                    array('check_repeated_account_name_error',array($this,'check_repeated_account_name'))),
        'errors' => array('check_repeated_account_name_error'=>'Account already exists.')),
      array(
        'field' => 'accounts[sub_group_code]',
        'label' => 'Sub Group Name',
        'rules'  =>array('trim','required',
                    array('check_sub_group_code_error',array($this,'check_sub_group_code_exist'))),
        'errors' => array('check_sub_group_code_error'=>'Sub group name not exist in sub group master.'))); 
  }
  private function set_group_data(){
    $sub_groups = $this->sub_group_model->find('group_id,id,route_group,group_name',array('name'=>$this->attributes['sub_group_code']));
    $this->formdata[$this->router_class]['sub_group_id'] =$sub_groups['id'];    
    $this->formdata[$this->router_class]['group_id'] =$sub_groups['group_id'];    
    $this->formdata[$this->router_class]['group_code'] =$sub_groups['group_name'];
    $this->formdata[$this->router_class]['route_group'] =$sub_groups['route_group'];
  }
  private function set_account_name_data(){
    if(!empty($this->attributes['unrecoverable_account_name'])){
    $account = $this->account_model->find('id',array('name'=>$this->attributes['unrecoverable_account_name']));
    $this->formdata[$this->router_class]['unrecoverable_account_id'] =!empty($account['id'])?$account['id']:0;    
    }
  }

  public function check_repeated_account_name($account_name) {
    return parent::check_unique('name');
  }
  public function check_sub_group_code_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
      $groups=$this->sub_group_model->find('id as id',array('name'=>$name));
      return (empty($groups)) ? false : true;
    
  }
  public function check_city_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $city=$this->city_model->find('id as id',array('name'=>$name));
    return (empty($city)) ? false : true;
  }
  public function check_state_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $state=$this->state_model->find('id as id',array('name'=>$name));
    return (empty($state)) ? false : true;
  }
  public function check_salesman_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $salesman=$this->salesman_model->find('id as id',array('salesman_code'=>$name));
    return (empty($salesman)) ? false : true;
  }
  public function check_area_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $area=$this->account_wise_detail_model->find('id as id',array('area'=>$name));
    return (empty($area)) ? false : true;
  }
}
