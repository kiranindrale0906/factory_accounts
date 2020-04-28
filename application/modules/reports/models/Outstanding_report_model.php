<?php 
class Outstanding_report_model extends BaseModel{
  public $router_class = 'outsatnding_reports';
  protected $table_name= 'ac_ledger';
  public function __construct($data = array()){
    parent::__construct($data);
  }

}
