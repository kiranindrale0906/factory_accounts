<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Cash_gst_register_model extends BaseModel {
  protected $table_name = "ac_vouchers";
  function __construct($data=array()) {
    parent::__construct($data);
  }

}

//class