<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Gold_rate_model extends BaseModel {
  protected $table_name = "ac_gold_rates";
  function __construct($data=array()) {
    parent::__construct($data);
  }
}