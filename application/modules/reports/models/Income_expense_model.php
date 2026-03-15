<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income_expense_model extends BaseModel {
  protected $table_name = "ac_vouchers";
  function __construct($data=array()) {
    parent::__construct($data);
  }
}