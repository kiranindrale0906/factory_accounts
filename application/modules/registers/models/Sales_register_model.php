<?php 
class Sales_register_model extends BaseModel{
  public $router_class = 'sales_registers';
  protected $table_name= 'ac_voucher';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
