<?php

class Chalan_model extends BaseModel {

  protected $table_name = "chalans";
  public $router_class = "chalans";

  public function __construct($data = array()){
		parent::__construct($data);
    $this->load->model(array('argold/chitti_model'));
  }
  
  public function validation_rules($klass='') {
    $rules= array(array('field' => 'chalans[date]', 'label' => 'Date',
                        'rules' => 'trim|required'),
                  array('field' => 'chalans[account_name]', 'label' => 'Account Name',
                            'rules' => array('trim','required',array('check_account_name_error_msg', array($this,'check_account_name_exist'))),
                              'errors' => array('check_account_name_error_msg' => 'Please select at least one detail',
                                       'required' => 'Account Name is required')));
    
    return $rules;
  }

  public function before_validate(){
    if (!isset($this->formdata['chalan_details']) || empty($this->formdata['chalan_details'])) return;
     $making_charge=$stone=$quantity=$gross_weight=$net_weight=$pure=$total=0;
     $chalan_ids=array_column($this->formdata['chalan_details'], 'chalan_id');
     
      $select = 'sum(credit_weight) as credit_weight,
                 sum(weight) as weight,
                 sum(sgst_amount) as sgst_amount,
                 sum(cgst_amount) as cgst_amount,
                 sum(taxable_amount) as taxable_amount,
                 (sum(weight*purity) / sum(weight)) as purity';
      $chalan_details=$this->chitti_model->find($select, array('id'=>$chalan_ids));
     
    $this->attributes['date']=date('Y-m-d',strtotime($this->attributes['date']));
    $this->attributes['weight']=$chalan_details['weight'];
    $this->attributes['sgst_amount']=$chalan_details['sgst_amount'];
    $this->attributes['cgst_amount']=$chalan_details['cgst_amount'];
    $this->attributes['taxable_amount']=$chalan_details['taxable_amount'];
    $this->attributes['credit_weight']=$chalan_details['credit_weight'];
    $this->attributes['purity']=$chalan_details['purity'];
  }
  public function check_account_name_exist($name) {
    if(empty($this->formdata['chalan_details'])){
      return false;
    }else{
      return true;
    }
    
  }
  public function update_chalan_ids($chitti_details) {
    if(!empty($chitti_details)){
      foreach ($chitti_details as $index => $chitti_details) {
        if (isset($chitti_details['id'])) {
        $voucher_obj = new chitti_model($chitti_details);
        $voucher_obj->attributes['chalan_id'] = 0;
        $voucher_obj->update(false);
        }
      }
    }
  }


   public function after_save($action){
    if (!isset($this->formdata['chalan_details']) || empty($this->formdata['chalan_details'])) return;
    $this->set_chitti_id_in_metal_issue_vouchers();
	}  

  private function set_chitti_id_in_metal_issue_vouchers() {
    $chalans=array();
    if (!empty($this->formdata['chalan_details'])) {
      foreach ($this->formdata['chalan_details'] as $index => $chalan_detail) {
        if(!empty($chalan_detail['chalan_id'])){
        $chalan_details = $this->chitti_model->find('', array('id' => $chalan_detail['chalan_id']));
        $chalan_details['chalan_id'] = $this->attributes['id'];
        $voucher_obj = new chitti_model($chalan_details);
        $voucher_obj->update(false);
        }
      }
    }
  }
}