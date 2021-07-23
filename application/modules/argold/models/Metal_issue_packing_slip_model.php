<?php

class Metal_issue_packing_slip_model extends BaseModel {

  protected $table_name = "packing_slip_details";
  public $router_class = "metal_issue_packing_slips";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
    $this->load->model(array('masters/account_model', 'transactions/rate_cut_issue_voucher_model','transactions/ledger_model','argold/packing_slip_detail_model'));
  }
  public function validation_rules($klass='') {
    $rules[] = array('field' => 'metal_issue_packing_slips[id]', 
                     'label' => 'id',
                     'rules' => 'trim|required');
    return $rules;
  }

  public function before_validate(){
    $this->attributes['net_weight']=$this->attributes['gross_weight']-$this->attributes['stone'];
    $this->attributes['pure']=$this->attributes['net_weight']*$this->formdata['metal_issue_packing_slips']['purity']/100;
    $this->attributes['total']=$this->attributes['net_weight']*$this->attributes['making_charge'];
  }
  public function after_save($action){
    $packing_slips=$this->packing_slip_model->find('',array('id'=>$this->formdata['metal_issue_packing_slips']['packing_slip_id']));
    $packing_slip_details=$this->packing_slip_detail_model->find('sum(net_weight) as net_weight,
                                                          sum(making_charge) as making_charge,
                                                          sum(pure) as pure,
                                                          sum(total) as total,
                                                          sum(quantity) as quantity,
                                                          sum(stone) as stone,site_name',
                                                        array('packing_slip_id'=>$this->formdata['metal_issue_packing_slips']['packing_slip_id']));
    $packing_slips['net_weight']=$packing_slip_details['net_weight'];
    $packing_slips['making_charge']=$packing_slip_details['making_charge'];
    $packing_slips['pure']=$packing_slip_details['pure'];
    $packing_slips['quantity']=$packing_slip_details['quantity'];
    $packing_slips['total']=$packing_slip_details['total'];
    $packing_slip_obj = new packing_slip_model($packing_slips);
    $packing_slip_obj->update(true);
  }
}