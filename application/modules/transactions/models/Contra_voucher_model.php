<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/models/Contra_voucher_client_model.php";
class Contra_voucher_model extends Contra_voucher_client_model {
  public $router_class = "contra_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }
}
