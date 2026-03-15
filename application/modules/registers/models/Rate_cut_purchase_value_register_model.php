<?php 
class Rate_cut_purchase_value_register_model extends BaseModel{
  public $router_class = 'rate_cut_purchase_value_registers';
  protected $table_name= 'ac_voucher';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
