<?php 
class Cash_register_model extends BaseModel{
  public $router_class = 'cash_registers';
  protected $table_name= 'ac_voucher';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
