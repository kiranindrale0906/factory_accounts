<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . "modules/argold/models/Chitti_model.php";  
  class Chitti_domestic_model extends Chitti_model {
  	public $router_class = "chitti_domestics";
    
    function __construct($data=array()) {
      parent::__construct($data);
    } 

    public function before_validate() {
      pd($this->attributes);
    }

    public function after_save($action) {
      $this->load->model(array('transactions/cash_issue_voucher_model'));
      $this->cash_issue_voucher_model->create_cash_vouchers_for_chitti($this->attributes['id']);
    }

  }