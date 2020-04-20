<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Metal_issue_voucher_client_model.php";
class Metal_issue_voucher_model extends Metal_issue_voucher_client_model {
  public $router_class = "metal_issue_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }
}

//class