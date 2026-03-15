<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Receipt_not_sent_argold_model extends BaseModel {
  protected $table_name = "receipt_not_sent_argold";
  //protected $insert_to_ledger = true;
  function __construct($data=array()) {
    parent::__construct($data);
  }
}

//class