<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Purchase_price_receipt_voucher_client_model.php";
class Purchase_price_receipt_voucher_model extends Purchase_price_receipt_voucher_client_model {
  public $router_class = "purchase_price_receipt_vouchers";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_rate]', 'label' => 'Gold Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_rate_purity]', 'label' => 'Gold Rate Purity','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_weight]', 'label' => 'Gold Weight','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_weight_purity]', 'label' => 'Gold Weight Purity','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[debit_amount]', 'label' => 'Debit Amount','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[transaction_type]', 'label' => 'Transaction Type','rules' => 'trim|required');
    return $rules;
  }
}

//class