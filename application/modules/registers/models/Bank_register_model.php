<?php 
class Bank_register_model extends BaseModel{
  public $router_class = 'bank_registers';
  protected $table_name= 'ac_vocher';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
