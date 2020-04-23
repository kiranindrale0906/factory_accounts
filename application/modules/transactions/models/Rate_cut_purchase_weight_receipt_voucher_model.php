<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Rate_cut_purchase_weight_receipt_voucher_client_model.php";
class Rate_cut_purchase_weight_receipt_voucher_model extends Rate_cut_purchase_weight_receipt_voucher_client_model {
  public $router_class = "rate_cut_purchase_weight_receipt_vouchers";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_rate]', 'label' => 'Gold Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_rate_purity]', 'label' => 'Gold Rate Purity','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[amount]', 'label' => 'Amount','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[debit_weight]', 'label' => 'Debit Weight','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[transaction_type]', 'label' => 'Transaction Type','rules' => 'trim|required');
    return $rules;
  }
}

//class