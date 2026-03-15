<?php

class Loss_report_detail_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $id = "id";
  public $router_class = "ac_vouchers";
  function __construct($data=array()) {
      parent::__construct($data);
  }
}