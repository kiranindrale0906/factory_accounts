<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Purchase_voucher_client_model.php";
class Purchase_voucher_model extends Purchase_voucher_client_model {
  public $router_class = "purchase_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }

   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[rate]', 'label' => 'Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[purity]', 'label' => 'Purity','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[cash_amount]', 'label' => 'Cash Amount','rules' => 'trim|required');
    return $rules;
  }
}

//class