<?php

class Bw_account_model extends BaseModel {

  protected $table_name = "bw_accounts";
  protected $id = "id";
  public $router_class = "bw_accounts";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array(
      	'field' => 'bw_accounts[factory_name]', 
      	'label' => 'Factory Name', 
      	'rules' => array('trim','required')),
      array(
        'field' => 'bw_accounts[balance_gross]', 
        'label' => 'Balance Gross', 
        'rules' => array('trim','numeric','required')),
    array(
        'field' => 'bw_accounts[b_gross]', 
        'label' => 'B Gross', 
        'rules' => array('trim','numeric','required')),
    array(
        'field' => 'bw_accounts[w_gross]', 
        'label' => 'W Gross', 
        'rules' => array('trim','numeric','required')),
    );
  }
}