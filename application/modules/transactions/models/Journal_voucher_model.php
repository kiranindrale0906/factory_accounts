<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Journal_voucher_client_model.php";
class Journal_voucher_model extends Journal_voucher_client_model {
  public $router_class = "journal_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }
}
