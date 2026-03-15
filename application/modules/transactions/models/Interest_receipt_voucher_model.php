<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Interest_receipt_voucher_client_model.php";
class Interest_receipt_voucher_model extends Interest_receipt_voucher_client_model {
  public $router_class = "interest_receipt_vouchers";
  function __construct($data=array()) {
      parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[amount]', 'label' => 'Amount','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[group_name]',
                     'label' => 'Group Name',
                     'rules'  =>array('trim','required','numeric','less_than_equal_to[100]',array('group_error_msg',array($this,'check_group_name_exist'))),
                     'errors' => array('group_error_msg'=>'Group Name not exist in Group master.'));
   return $rules;
  }
}

//class