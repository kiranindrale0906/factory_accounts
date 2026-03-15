<?php 
class Expense_register_model extends BaseModel{
  public $router_class = 'expense_registers';
  protected $table_name= 'ac_voucher';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
