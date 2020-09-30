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
        'field' => 'bw_accounts[arg_balance_gross]', 
        'label' => 'ARG Balance Gross', 
        'rules' => array('trim','numeric','required')),
       array(
        'field' => 'bw_accounts[arf_balance_gross]', 
        'label' => 'ARF Balance Gross', 
        'rules' => array('trim','numeric','required')),
       array(
        'field' => 'bw_accounts[arc_balance_gross]', 
        'label' => 'ARC Balance Gross', 
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