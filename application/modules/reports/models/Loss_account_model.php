<?php

class Loss_account_model extends BaseModel {

  protected $table_name = "bw_accounts";
  protected $id = "id";
  public $router_class = "bw_accounts";
  function __construct($data=array()) {
      parent::__construct($data);
  }
}