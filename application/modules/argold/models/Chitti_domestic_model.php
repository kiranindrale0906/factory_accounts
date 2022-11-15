<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . "modules/argold/models/Chitti_model.php";  
  class Chitti_domestic_model extends Chitti_model {
  	public $router_class = "chitti_domestics";
    
    function __construct($data=array()) {
      parent::__construct($data);
      $this->load->model(array('ac_vouchers/voucher_model'));
    } 

    public function after_save($action) {
	pd($this->attributes);

      $metal_issue_vouchers = $this->voucher_model->find('sum(rate * credit_weight) as amount', array('chitti_id' => $this->attributes['id']));
     $metal_issue_vouchers['amount']=(isset($metal_issue_vouchers['amount'])&&$metal_issue_vouchers['amount']!=NULL)?$metal_issue_vouchers['amount']:0;    
      $this->load->model(array('transactions/cash_issue_voucher_model'));
      $this->cash_issue_voucher_model->create_cash_vouchers_for_chitti($this->attributes['id'], $metal_issue_vouchers['amount']);
    }

  }
