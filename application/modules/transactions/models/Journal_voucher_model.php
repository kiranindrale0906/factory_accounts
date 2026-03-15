<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Journal_voucher_client_model.php";
class Journal_voucher_model extends Journal_voucher_client_model {
  public $router_class = "journal_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }


public function validation_rules($klass='') {
  $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
  $rules[] = array('field' => $this->router_class.'[from_account_name]', 'label' => 'From Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[from_group_name]',
                     'label' => 'From Group Name',
                     'rules'  =>array('trim','required',
                                array('group_name_error_msg',array($this,'check_group_name_exist'))),
                     'errors' => array('group_name_error_msg'=>'Group name not exist in group master.'));
    $rules[] = array('field' => $this->router_class.'[to_group_name]',
                     'label' => 'To Group Name',
                     'rules'  =>array('trim','required',
                                array('group_name_error_msg',array($this,'check_group_name_exist'))),
                     'errors' => array('group_name_error_msg'=>'Group name not exist in group master.'));
    $rules[] = array('field' => $this->router_class.'[amount]', 'label' => 'Amount','rules' => 'trim|required');
   
 return $rules;
  }
}
