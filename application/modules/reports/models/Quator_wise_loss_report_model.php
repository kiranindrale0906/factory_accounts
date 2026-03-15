<?php

class Quator_wise_loss_report_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  protected $id = "id";
  public $router_class = "ac_vouchers";
  function __construct($data=array()) {
      parent::__construct($data);
  }
}