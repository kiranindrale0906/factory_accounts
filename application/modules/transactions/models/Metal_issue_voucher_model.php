<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Metal_issue_voucher_model extends Voucher_model {
  protected $prefix = 'MI';
  protected $voucher_type = 'metal issue voucher';
  protected $account_type = 'account';
  public $router_class = "metal_issue_vouchers";
  protected $insert_to_ledger = true;

  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='',$index='') {
    if(empty($index)) $rules = parent::validation_rules($klass);
    if(!empty($index)) {
      $rules[] = array('field' => 'metal_issue_vouchers['.$index.'][credit_weight]', 
                     'label' => 'Credit weight',
                     'rules' => 'trim|required|numeric|greater_than[0]');
      $rules[] = array('field' => 'metal_issue_vouchers['.$index.'][factory_purity]', 
                    'label' => 'Factory Purity',
                    'rules' => 'trim|required|numeric|less_than_equal_to[100]');
  
    }
    
    return $rules;

  }

  public function before_save($action) {
    $purity = $this->attributes['purity'];
    $factory_purity = $this->attributes['factory_purity'];
    $credit_weight = $this->attributes['credit_weight'];
    $purity_margin=($factory_purity-$purity)*$credit_weight/100;
    $this->formdata[$this->router_class]['purity_margin'] = $purity_margin;
    parent::before_save($action);
  }
}

//class