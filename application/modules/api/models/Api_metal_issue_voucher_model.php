<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/transactions/models/Metal_issue_voucher_model.php";
class Api_metal_issue_voucher_model extends Metal_issue_voucher_model {
  function __construct($data=array()) {
    parent::__construct($data);
  }
}