<?php

class Packing_slip_detail_model extends BaseModel {

  protected $table_name = "packing_slip_details";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'packing_slip_details[packing_slip_id]', 
                     'label' => 'packing_slip_id',
                     'rules' => 'trim|required');
    return $rules;
  }
  public function update_packing_slip_ids($voucher_details,$packing_slip_details) {
    if(!empty($voucher_details)){
      foreach ($voucher_details as $index => $voucher_detail) {
        if (isset($voucher_detail['id'])) {
        $voucher_obj = new voucher_model($voucher_detail);
        $voucher_obj->attributes['packing_slip_balance'] = $voucher_detail['packing_slip_balance']+$packing_slip_details['gross_weight'];
        if($packing_slip_details['weight']==$voucher_obj->attributes['packing_slip_balance']){
          $voucher_obj->attributes['packing_slip_id'] = 0;
        }
        $voucher_obj->update(false);
        // $ledger_details=$this->ledger_model->find('',array('voucher_id'=>$voucher_detail['id']));
        // $ledger_obj = new ledger_model($ledger_details);
        // $ledger_obj->attributes['packing_slip_id'] = 0;
        // $ledger_obj->update(false);
        }
      }
    }
  }
}