<?php
class Voucher_listing_model extends BaseModel {
  protected $table_name = 'ac_vouchers';
  protected $id = 'id';
  public $router_class='voucher_listing'; 
  public function __construct($data=array()) {
    parent::__construct($data);
  }
}
