<?php

class Opening_loss_voucher_model extends BaseModel {
  protected $table_name= 'opening_loss_vouchers';
  public $router_class= 'opening_loss_vouchers';
  public function __construct($data = array()){
    parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules = array(array('field' => 'opening_loss_vouchers[loss]', 'label' => 'Loss',
                         'rules' => 'required'),
                   array('field' => 'opening_loss_vouchers[date]', 'label' => 'Date',
                         'rules' => 'required'),
                   array('field' => 'opening_loss_vouchers[out_weight]', 'label' => 'Out Weight',
                         'rules' => 'required'),
                   array('field' => 'opening_loss_vouchers[purity]', 'label' => 'Purity',
                         'rules' => 'required'));
    return $rules;
  }
  public function before_validate(){
   if (!empty($this->attributes['date']))  $this->attributes['date'] = date('Y-m-d', strtotime($this->attributes['date']));
  }
}