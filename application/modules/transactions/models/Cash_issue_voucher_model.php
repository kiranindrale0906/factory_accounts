<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Cash_issue_voucher_client_model.php";
class Cash_issue_voucher_model extends Cash_issue_voucher_client_model {
  public $router_class = "cash_issue_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }
}

//class