<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Sales_voucher_client_model.php";
class Sales_voucher_model extends Sales_voucher_client_model {
  public $router_class = "Sales_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }
}

//class