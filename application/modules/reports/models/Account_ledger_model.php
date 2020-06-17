<?php 
class Account_ledger_model extends BaseModel{
  public $router_class = 'account_ledgers';
  protected $table_name= 'ac_ledger';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
