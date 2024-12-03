<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Voucher_model extends BaseModel {
  protected $table_name = "ac_vouchers";
  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('masters/period_model', 'masters/setting_model', 
                             'transactions/Receipt_not_sent_argold_model'));
    if (!class_exists("Ledger_model")) {
      $this->load->model("transactions/Ledger_model");
    }
  }

  public function validation_rules($klass='') {
    $rules[] =array('field' => $this->router_class.'[voucher_date]', 'label' => 'Date',
                    'rules' => array('trim', 'required', 
                               array('validate_voucher_date', array($this, 'check_period_exists'))),
                    'errors'=>array('validate_voucher_date' => "Please set the Financial year from master."));
    // $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name',
    //                  'rules' => 'trim|required');
 
    if($this->router->class=="bank_issue_vouchers" || $this->router->class=="bank_receipt_vouchers") {
      $rules[] = array('field' => $this->router_class.'[bank_name]', 'label' => 'Bank Name',
                       'rules' => 'trim|required');
    }

    if($this->router->class=="expense_vouchers") {
      $rules[] = array('field' => $this->router_class.'[to_group_name]', 'label' => 'To Group Name',
                       'rules'  =>array('trim','required',
                                  array('group_name_error_msg',array($this,'check_group_name_exist'))),
                       'errors' => array('group_name_error_msg'=>'Group name not exist in group master.'));
      $rules[] = array('field' => $this->router_class.'[debit_amount]', 'label' => 'Amount',
                       'rules' => 'trim|required');
    }

    if (($this->router->class == "cash_receipt_vouchers") ||($this->router->class == "bank_receipt_vouchers")) {
      $rules[] = array('field' => $this->router_class.'[debit_amount]', 
                       'label' => 'Amount',
                       'rules' => 'trim|required|numeric|greater_than[0]');
    }

    if (($this->router->class == "cash_issue_vouchers") ||($this->router->class == "bank_issue_vouchers")) {
      $rules[] = array('field' => $this->router_class.'[credit_amount]', 
                       'label' => 'Amount',
                       'rules' => 'trim|required|numeric|greater_than[0]');
    }

    return $rules;
  }

  protected function get_purity_validation_rules() {
    if($this->formdata[$this->router_class]['receipt_type']=="Unrecoverable Loss"){
      return array('field' => $this->router_class.'[purity]', 'label' => 'Purity',
                 'rules' => array('trim','required','numeric'));
    }else{
    return array('field' => $this->router_class.'[purity]', 'label' => 'Purity',
                 'rules' => array('trim','required','numeric','less_than_equal_to[150]'/*,'greater_than[0]'*/,
                                  //array('purity_error_msg', array($this,'check_purity_exist'))
                                 ),
                 'errors' => array('purity_error_msg'=>'Purity not exist in Purity master.'));
    }
  }

  protected function get_account_validation_rules() {
    return array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name',
                 'rules' => array('trim','required',array('account_error', array($this,'check_account_exist'))),
                 'errors' => array('account_error'=>'Account not exist in Account master.'));
  }

  protected function get_factory_purity_validation_rules() {
    if($this->formdata[$this->router_class]['receipt_type']=="Unrecoverable Loss"){
      return array('field' => $this->router_class.'[factory_purity]', 'label' => 'Purity',
                 'rules' => array('trim','required','numeric'));
    }else{

    return array('field' => $this->router_class.'[factory_purity]', 'label' => 'Purity',
                 'rules' => array('trim','required','numeric','less_than_equal_to[150]'/*,'greater_than[0]'*/));
    }
  }

  protected function get_receipt_type_validation_rules() {
    return array('field' => $this->router_class.'[receipt_type]', 'label' => 'Receipt Type',
                 'rules' => 'trim|required');
  }

  protected function get_debit_weight_validation_rules() {
    return array('field' => $this->router_class.'[debit_weight]', 'label' => 'Weight',
                 'rules' => 'trim|required|numeric|greater_than[0]');
  }

  protected function get_credit_weight_validation_rules() {
    return array('field' => $this->router_class.'[credit_weight]', 'label' => 'Credit Weight',
                 'rules' => 'trim|required|numeric|greater_than[0]');
  }
  
  protected function get_credit_amount_validation_rules() {
    return array('field' => $this->router_class.'[credit_amount]', 'label' => 'Credit Amount',
                 'rules' => 'trim|required|numeric|greater_than[0]');
  }

  protected function get_debit_amount_validation_rules() {
    return array('field' => $this->router_class.'[debit_amount]', 'label' => 'Debit Amount',
                 'rules' => 'trim|required|numeric|greater_than[0]');
  }

  protected function get_narration_validation_rules() {
    return array('field' => $this->router_class.'[narration]', 'label' => 'Item Name',
                 'rules' => 'trim|required');
  }

  protected function get_gold_rate_validation_rules() {
    return array('field' => $this->router_class.'[gold_rate]', 'label' => 'Gold Rate',
                 'rules' => 'trim|required');
  }

  protected function get_gold_rate_purity_validation_rules() {
    return array('field' => $this->router_class.'[gold_rate_purity]', 'label' => 'Gold Rate Purity',
                 'rules' => 'trim|required');
  }

  protected function get_gold_weight_validation_rules() {
    return array('field' => $this->router_class.'[gold_weight]', 'label' => 'Gold Weight',
                 'rules' => 'trim|required');
  }

  protected function get_gold_weight_purity_validation_rules() {
    return array('field' => $this->router_class.'[gold_weight_purity]', 'label' => 'Gold Weight Purity',
                 'rules' => 'trim|required');
  }

  protected function get_sale_type_validation_rules() {
    return array('field' => $this->router_class.'[sale_type]', 'label' => 'Sale Type',
                 'rules' => 'trim|required');
  }

  protected function get_site_name_validation_rules() {
    return array('field' => $this->router_class.'[site_name]', 'label' => 'Site Name',
                 'rules' => 'trim|required');
  }


  public function check_group_name_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
      $groups=$this->group_model->find('id as id',array('name'=>$name));
    return (empty($groups)) ? false : true;
  }

  public function check_narration_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
      $narration=$this->narration_model->find('id as id',array('name'=>$name));
    return (empty($narration)) ? false : true;
  } 

  public function check_purity_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
      $purity=$this->purity_model->find('id as id',array('purity'=>$name));
    return (empty($purity)) ? false : true;
  }

  public function check_account_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
      $account_name=$this->account_model->find('id as id',array('name'=>$name));
    return (empty($account_name)) ? false : true;
  }

  public function check_department_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
      $department=$this->department_model->find('id as id',array('name'=>$name));
    return (empty($department)) ? false : true;
  }

  public function check_period_exists($voucher_date) {
    $voucher_date=date('Y-m-d',strtotime($voucher_date));  
    $period_id = $this->period_model->get('id', array('where'=> array('"'.$voucher_date.'" between date_from and date_to'=>NULL)));
    if(!empty($period_id[0]['id']))
      return $period_id[0]['id'];
    else
      return false;
  }

  public function before_save($action) {
    unset($this->attributes['arg_weight']);
    if($action=='store') $this->set_user_define_data();
  }

  private function set_user_define_data() {
    if($this->router_class=="metal_issue_vouchers") {
      if(!is_numeric($this->attributes['company_id'])) {
        $company_detail=$this->company_model->find('id',array('name'=>$this->attributes['company_id']));
        $this->attributes['company_id']=$company_detail['id'];
      }
    }

    $this->formdata[$this->router_class]['suffix'] = $this->prefix;
    $this->formdata[$this->router_class]['voucher_type'] = $this->voucher_type;
    
    $account=array();
    if(!empty($this->attributes['account_name']))
      $account = $this->account_model->find('id, group_id, route_group, sub_group_id', 
                                            array('name' => $this->attributes['account_name']));
    
    if (!empty($account['id'])) {    
      $this->formdata[$this->router_class]['group_id'] = !empty($account['group_id']) ? $account['group_id'] : 0;
      $this->formdata[$this->router_class]['sub_group_id'] = !empty($account['sub_group_id']) ? $account['sub_group_id'] : 0;
      $this->formdata[$this->router_class]['route_group'] = !empty($account['route_group']) ? $account['route_group'] : '';
    }

    $account_name=isset($this->attributes['account_name'])?$this->attributes['account_name']:'';
    if (empty($account['id'])) {
      $sub_groups = $this->setting_model->find('id, value', array('name' => 'Sub Group'));
      $account_detail['name'] =$account_name;
      $account_detail['sub_group_code'] = !empty($sub_groups['value']) ? $sub_groups['value'] : '';
      $account_detail['sub_group_id'] = !empty($sub_groups['id']) ? $sub_groups['id'] : 0;
      $obj_account = new account_model($account_detail);
      $account_details=$obj_account->store(false);
      $account['id']=$account_details['id'];      
    }

    $this->formdata[$this->router_class]['account_id'] = $account['id'];

    $period_id = $this->check_period_exists($this->attributes['voucher_date']);   //this needs to move to before validation
    $this->formdata[$this->router_class]['period_id'] = $period_id;

    $voucher_serial_number = $this->create_voucher_serial_number($this->voucher_type, $period_id);
    $this->formdata[$this->router_class]['voucher_serial_number'] = $voucher_serial_number;

    $voucher_number = $this->create_voucher_number($this->prefix,$voucher_serial_number,
                                                   $this->attributes['voucher_date']);
    $this->formdata[$this->router_class]['voucher_number'] = $voucher_number;
  }

  private function create_voucher_serial_number($voucher_type,$period_id) {
    $voucher_serial_number = $this->get_serial_number($voucher_type, $period_id);
    $company_id = (!empty($this->session->userdata('company_id')) ? $this->session->userdata('company_id') : 0);
    $voucher_serial_number = $voucher_serial_number + 1;
    return $voucher_serial_number;
  }

  private function create_voucher_number($prefix,$voucher_serial_number,$date) {
    $voucher_number = $prefix . '/' . $voucher_serial_number . '/' . date('dmy', strtotime($date));
    return $voucher_number;
  }

  private function get_serial_number($voucher_type,$period_id='') {
    $company_id = (!empty($this->session->userdata('company_id')) ? $this->session->userdata('company_id') : 0);
    $result = $this->find('max(voucher_serial_number) as max_serial_number', array('period_id' => $period_id,                         'company_id' => $company_id,                       'voucher_type' => $voucher_type));
    if(!empty($result['max_serial_number']))
      return $result['max_serial_number'];
    else
      return 0;
  }

  public function after_save($action) {
    // if ($action=="update" && isset($id))
    //   $this->ledger_model->delete('', array('table_id' => $id), true);

    // $ledger_data = $this->ledger_model->set_data($this->attributes, $this->router->class, $this->prefix, $this->table_name);
    $ledger_obj = new ledger_model(array('voucher_id' => $this->attributes['id']));
    $ledger_obj->before_validate();
    $ledger_obj->save();
  }
  
}
