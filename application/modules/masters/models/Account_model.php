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
        'errors' => array('check_sub_group_code_error'=>'Sub group name not exist in sub group master.')),
      array(
        'field' => 'accounts[cont_person]',
        'label' => 'Contact Person',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[salesman_code]',
        'label' => 'Salesman Code',
        'rules'  =>array('trim','numeric',
                    array('check_salesman_exits_error',array($this,'check_salesman_exist'))),
        'errors' => array('check_salesman_exits_error'=>'Salesman not exist in saleman master.')),
      array(
        'field' => 'accounts[address]',
        'label' => 'Address',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[city]',
        'label' => 'City Name',
        'rules'  =>array('trim',
                    array('check_city_exits_error',array($this,'check_city_exist'))),
        'errors' => array('check_city_exits_error'=>'City not exist in city master.')),
      array(
        'field' => 'accounts[state]',
        'label' => 'State Name',
        'rules'  =>array('trim',
                    array('check_state_exits_error',array($this,'check_state_exist'))),
        'errors' => array('check_state_exits_error'=>'State not exist in state master.')),
      array(
        'field' => 'accounts[pin]',
        'label' => 'Pin',
        'rules' => 'trim|numeric',),
      array(
        'field' => 'accounts[area]',
        'label' => 'Area',
        'rules'  =>array('trim',
                    array('check_area_exits_error',array($this,'check_area_exist'))),
        'errors' => array('check_area_exits_error'=>'Area not exist in account wise detail master.')),
      array(
        'field' => 'accounts[interest_rate]',
        'label' => 'Interest Rate',
        'rules' => 'trim|numeric',),
      array(
        'field' => 'accounts[salary]',
        'label' => 'Salary',
        'rules' => 'trim|numeric'),
      array(
        'field' => 'accounts[off_tel]',
        'label' => 'Office No.',
        'rules' => 'trim|min_length[5]|max_length[10]|regex_match[/^[0-9]*$/]',
        'errors'=>  array('regex_match'=>"enter valid Office No.")),
      array(
        'field' => 'accounts[res_tel]',
        'label' => 'Residential No.',
        'rules' => 'trim|numeric',),
      array(
        'field' => 'accounts[email]',
        'label' => 'Email',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[web_address]',
        'label' => 'Web Address',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[cst_no]',
        'label' => 'Cst. No.',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[pan_no]',
        'label' => 'Pan. No.',
        'rules' => 'trim|alpha_numeric',
        'errors'=>  array('regex_match'=>"Enter valid PAN Number"),),
      array(
        'field' => 'accounts[sms_mobile_no]',
        'label' => 'Sms Mobile No.',
        'rules' => 'trim|numeric'),
      array(
        'field' => 'accounts[fine_wt_limit]',
        'label' => 'Fine Weight Limit',
        'rules' => 'trim|numeric'),
      array(
        'field' => 'accounts[coll_days]',
        'label' => 'Coll. Days',
        'rules' => 'trim|numeric',),
      array(
        'field' => 'accounts[payment_terms]',
        'label' => 'Payment Terms',
        'rules' => 'trim'),
      array(
        'field' => 'accounts[cr_days]',
        'label' => 'Cr. Days',
        'rules' => 'trim|numeric'),
      array(
        'field' => 'accounts[srv_tax_no]',
        'label' => 'Srv. Tax No',
        'rules' => 'trim|numeric'),
      array(
        'field' => 'accounts[mvat_lst_no]',
        'label' => 'Mvat/Lst No.',
        'rules' => 'trim|numeric')); 
  }
  private function set_group_data(){
    $sub_groups = $this->sub_group_model->find('group_id,id',array('name'=>$this->attributes['sub_group_code']));
    $groups = $this->group_model->find('route_group,name',array('id'=>$sub_groups['group_id']));
    $this->formdata[$this->router_class]['sub_group_id'] =$sub_groups['id'];    
    $this->formdata[$this->router_class]['group_id'] =$sub_groups['group_id'];    
    $this->formdata[$this->router_class]['group_code'] =$groups['name'];
    $this->formdata[$this->router_class]['route_group'] =$groups['route_group'];
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
