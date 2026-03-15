<?php
class Metal_receipt_voucher_detail_model extends BaseModel {
  protected $table_name = 'ac_vouchers';
  protected $id = 'id';
  public $router_class='metal_receipt_voucher_details'; 
  public function __construct($data=array()) {
    parent::__construct($data);
  }
  public function before_validate() {
    $this->attributes['factory_fine'] = $this->attributes['debit_weight']*$this->attributes['debit_weight']/100;
    $this->attributes['fine'] = $this->attributes['debit_weight']*$this->attributes['purity']/100;parent::before_validate();
  }
  public function validation_rules($klass='') {
    return array(
      array(
        'field'  => 'metal_receipt_voucher_details[voucher_number]',
        'label'  => 'Name',
        'rules'  =>array('trim','required')),
      array(
        'field'  => 'metal_receipt_voucher_details[debit_weight]',
        'label'  => 'Debit Weight',
        'rules'  =>array('trim','required')),
      array(
        'field'  => 'metal_receipt_voucher_details[purity]',
        'label'  => 'Purity',
        'rules'  =>array('trim','required')),
      array(
        'field'  => 'metal_receipt_voucher_details[factory_purity]',
        'label'  => 'Factory Purity',
        'rules'  =>array('trim','required')),
      
      array(
        'field'  => 'metal_receipt_voucher_details[account_name]',
        'label'  => 'Account Name',
        'rules'  =>array('trim','required')),
      );
      }
}  