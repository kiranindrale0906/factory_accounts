<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Interest_issue_voucher_client_model.php";
class Interest_issue_voucher_model extends Interest_issue_voucher_client_model {
  public $router_class = "interest_issue_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }

public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[amount]', 'label' => 'Amount','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[group_name]', 'label' => 'Group Name','rules' => 'trim|required');
   return $rules;
  }
}

//class