<?php

class Opening_balance_model extends BaseModel {
  protected $table_name = "ac_opening_balance";
  public $router_class="opening_balance";
  function __construct($data=array()) {
    parent::__construct($data);
  }

  
  public function validation_rules($klass='') {

    return array(
      array(
        'field' => 'opening_balance[date]', 
        'label' => 'Date', 
        'rules'  =>array('trim','required')),
      array(
        'field' => 'opening_balance[account_name]', 
        'label' => 'Account name', 
        'rules'  =>array('trim','required',
                    array('check_account_name_error',array($this,'check_account_name_exist'))),
        'errors' => array('check_account_name_error'=>'Account Name not exist in Account master.')),
      array(
        'field' => 'opening_balance[group_code]',
        'label' => 'Sub Group Name',
        'rules'  =>array('trim','required',
                    array('check_group_name_error',array($this,'check_group_name_exist'))),
        'errors' => array('check_group_name_error'=>'Group Code not exist in group master.')),
      array(
        'field' => 'opening_balance[cash_bill_type]',
        'label' => 'Cash Bill Type',
        'rules'  =>array('trim','required',
                    array('check_cash_bill_error',array($this,'check_cash_bill_exist'))),
        'errors' => array('check_cash_bill_error'=>'Cash / Bill value not exist.')),
      );
  }

  public function check_group_name_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $groups=$this->group_model->find('id as id',array('name'=>$name));
    return (empty($groups)) ? false : true;
  }
  public function check_account_name_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $accounts=$this->account_model->find('id as id',array('name'=>$name));
    return (empty($accounts)) ? false : true;
  }
  public function check_cash_bill_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $accounts=$this->cash_bill_model->find('id as id',array('name'=>$name));
    return (empty($accounts)) ? false : true;
  }

}


