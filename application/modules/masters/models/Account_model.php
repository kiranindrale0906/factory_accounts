<?php
class Account_model extends BaseModel {
  protected $table_name = 'ac_account';
  protected $id = 'id';
  public $router_class='accounts'; 
  public function __construct($data=array()) {
    parent::__construct($data);
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
        'field' => 'accounts[group_code]',
        'label' => 'Group Name',
        'rules' => 'trim|required',),
      array(
        'field' => 'accounts[cont_person]',
        'label' => 'Contact Person',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[salesman_code]',
        'label' => 'Salesman Code',
        'rules' => 'trim|numeric',),
      array(
        'field' => 'accounts[address]',
        'label' => 'Address',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[city]',
        'label' => 'City Name',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[state]',
        'label' => 'State Name',
        'rules' => 'trim',),
      array(
        'field' => 'accounts[pin]',
        'label' => 'Pin',
        'rules' => 'trim|numeric',),
      array(
        'field' => 'accounts[area]',
        'label' => 'Area',
        'rules' => 'trim',),
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

  public function check_repeated_account_name($account_name) {
    return parent::check_unique('name');
  }
}
