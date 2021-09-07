<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Rate_cut_booking_weight_issue_voucher_client_model.php";
class Rate_cut_booking_weight_issue_voucher_model extends Rate_cut_booking_weight_issue_voucher_client_model {
  public $router_class = "rate_cut_booking_weight_issue_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }

   public function validation_rules($klass='') {
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_rate]', 'label' => 'Gold Rate','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[gold_rate_purity]', 'label' => 'Gold Rate Purity','rules'  =>array('trim','required','numeric','less_than_equal_to[100]',array('purity_error_msg',array($this,'check_purity_exist'))),
                     'errors' => array('purity_error_msg'=>'Purity not exist in Purity master.'));
    $rules[] = array('field' => $this->router_class.'[amount]', 'label' => 'Amount','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[credit_weight]', 'label' => 'Credit Weight','rules' => 'trim|required');
    $rules[] = array('field' => $this->router_class.'[transaction_type]', 'label' => 'Transaction Type','rules'  =>array('trim','required',array('transaction_error_msg',array($this,'check_cash_bill_exist'))),
                     'errors' => array('transaction_error_msg'=>'Transaction Type not exist.'));
    return $rules;
  }

  public function check_cash_bill_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $accounts=$this->cash_bill_model->find('id as id',array('name'=>$name));
    return (empty($accounts)) ? false : true;
  }
}

//class