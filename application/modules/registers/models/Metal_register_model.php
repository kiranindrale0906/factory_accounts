<?php 
class Metal_register_model extends BaseModel{
  public $router_class = 'metal_registers';
  protected $table_name= 'ac_vouchers';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
