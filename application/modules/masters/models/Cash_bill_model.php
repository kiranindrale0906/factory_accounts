<?php

class Cash_bill_model extends BaseModel {

  protected $table_name = "ac_cash_bill";
  protected $id = "id";
  public $router_class = "";
  function __construct($data=array()) {
      parent::__construct($data);
  }
}

//class