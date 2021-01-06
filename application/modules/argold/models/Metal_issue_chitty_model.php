<?php

class Metal_issue_chitty_model extends BaseModel {

  protected $table_name = "chitties";
  public $router_class = "metal_issue_chitties";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
    $this->load->model(array('masters/account_model', 'transactions/rate_cut_issue_voucher_model'));
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'metal_issue_chitties[id]', 
                     'label' => 'id',
                     'rules' => 'trim|required');
    return $rules;
  }

  public function before_validate(){ 
    $chitti_ids=array_column($this->formdata['metal_issue_details'], 'chitti_id');
    $metal_vouchers = $this->voucher_model->find('sum(credit_weight) as credit_weight,sum(fine) as fine,(sum(credit_weight*purity) / sum(credit_weight)) as purity,
                         (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                         "" as voucher_number,packet_no,voucher_date,group_concat(narration) as narration, argold_id as argold_id', 
                         array('where_in'=>array('id'=>$chitti_ids)), array());
    $this->attributes['weight']=$this->attributes['weight']+$metal_vouchers['credit_weight'];
    $this->attributes['fine']=$this->attributes['fine']+$metal_vouchers['fine'];
  }
  public function after_save($action){
    if(!empty($this->formdata['metal_issue_details'])){
      foreach ($this->formdata['metal_issue_details'] as $index => $voucher_detail) {
        if (isset($voucher_detail['chitti_id'])) {
          $voucher_detail['id']=$voucher_detail['chitti_id'];
          $voucher_obj = new voucher_model($voucher_detail);
          $voucher_obj->attributes['chitti_id'] = $this->attributes['id'];
          $voucher_obj->update(false);
        }
      }
    }
  }
}