<?php

class Voucher_detail_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
 
}