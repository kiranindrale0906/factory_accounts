<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Expense_voucher_client_model.php";
class Expense_voucher_model extends Expense_voucher_client_model {
  public $router_class = "expense_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }
}
