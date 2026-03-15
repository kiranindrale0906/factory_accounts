<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Domestic_export_ledger_model extends BaseModel {
  protected $table_name = "ac_vouchers";
  function __construct($data=array()) {
    parent::__construct($data);
  }

}

//class