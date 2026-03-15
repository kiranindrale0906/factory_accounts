<?php

class Packing_slip_model extends BaseModel {

  protected $table_name = "packing_slips";
  public $router_class = "packing_slips";

  public function __construct($data = array()){
		parent::__construct($data);
    $this->load->model(array('transactions/rate_cut_issue_voucher_model','transactions/ledger_model'));
  }
  
  public function validation_rules($klass='') {
    $rules= array(array('field' => 'packing_slips[date]', 'label' => 'Date',
                        'rules' => 'trim|required'),
                  array('field' => 'packing_slips[account_name]', 'label' => 'Account Name',
                            'rules' => array('trim','required',array('check_account_name_error_msg', array($this,'check_account_name_exist'))),
                              'errors' => array('check_account_name_error_msg' => 'Please select at least one detail',
                                       'required' => 'Account Name is required')));
    
    return $rules;
  }
  public function check_account_name_exist($name) {
    if(empty($this->formdata['packing_slip_details'])){
      return false;
    }else{
      return true;
    }
    
  }

  public function before_validate(){
    if (!isset($this->formdata['packing_slip_details']) || empty($this->formdata['packing_slip_details'])) return;
     
    $packing_slip_ids=array_column($this->formdata['packing_slip_details'], 'packing_slip_id');
    if (!isset($packing_slip_ids) || empty($packing_slip_ids)) return;
      $packing_slip_id_details=array();
      $packing_slips=array();
      foreach ($packing_slip_ids as $index => $packing_slip_id) {
        $chittis=explode('-', $packing_slip_id);
        $packing_slip_id_details[$index]['packet_no']=$chittis[0];
        $packing_slip_id_details[$index]['argold_id']=$chittis[1];
      }
      $packet_nos=array_column($packing_slip_id_details, 'packet_no');
      $argold_ids=array_column($packing_slip_id_details, 'argold_id');


      $select = 'sum(credit_weight) as credit_weight,
                 sum(packing_slip_net_weight) as packing_slip_net_weight,
                 sum(packing_slip_making_charge) as packing_slip_making_charge,
                 sum(packing_slip_total) as packing_slip_total,
                 sum(packing_slip_pure) as packing_slip_pure,
                 sum(packing_slip_stone) as packing_slip_stone,
                 sum(packing_slip_quantity) as packing_slip_quantity,
                 (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                 (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                 "" as voucher_number, packet_no, voucher_date';
      $packing_slip_details=$this->voucher_model->find($select, array('packet_no' => $packet_nos,
                                                                'argold_id' => $argold_ids,
                                                                'account_name' => $this->attributes['account_name']));
     $making_charge=$stone=$quantity=$gross_weight=$net_weight=$pure=$total=0;
    foreach ($this->formdata['packing_slip_details'] as $index => $value) {
      if(!empty($value['packing_slip_id'])){
        $making_charge+=$value['packing_slip_making_charge'];
        $gross_weight+=$value['packing_slip_gross_weight'];
        $stone+=$value['packing_slip_stone'];
        $quantity+=$value['packing_slip_quantity'];
        $net_weight+=$value['packing_slip_gross_weight']-$value['packing_slip_stone'];
      }
    }
    $this->attributes['date']=date('Y-m-d',strtotime($this->attributes['date']));
    $this->attributes['weight']=$packing_slip_details['credit_weight'];
    $this->attributes['gross_weight']=$gross_weight;
    $this->attributes['purity']=$packing_slip_details['purity'];
    $this->attributes['factory_purity']=$packing_slip_details['factory_purity'];
    $this->attributes['net_weight']=$net_weight;
    $this->attributes['quantity']=$quantity;
    $this->attributes['making_charge']=$making_charge;
    $this->attributes['stone']=$stone;
    $this->attributes['pure']=($net_weight*$packing_slip_details['purity']/100);
    $this->attributes['total']=($net_weight*$making_charge);
  }

   public function after_save($action){
    if (!isset($this->formdata['packing_slip_details']) || empty($this->formdata['packing_slip_details'])) return;
    $this->set_packing_slip_id_in_metal_issue_vouchers();
	}  

  private function set_packing_slip_id_in_metal_issue_vouchers() {
    $packing_slips=array();
    if (!empty($this->formdata['packing_slip_details'])) {
    foreach ($this->formdata['packing_slip_details'] as $index => $packing_slip_detail) {
      if(!empty($packing_slip_detail['packing_slip_id'])){
      $packing_slips=explode('-', $packing_slip_detail['packing_slip_id']);
      if(!empty($packing_slip_detail['voucher_id'])){

      $packing_details = $this->voucher_model->find('', array('id' => $packing_slip_detail['voucher_id']));
      }else{

          $packing_details = $this->voucher_model->find('sum(credit_weight) as credit_weight,sum(packing_slip_balance) as packing_slip_balance,
                   (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                   (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,id,site_name', array('packet_no' => $packing_slips[0],
                                                              'argold_id' => $packing_slips[1],
                                                              'account_name' => $this->attributes['account_name']
                                                              ));
      }
        $packing_details['packing_slip_id'] = $this->attributes['id'];
        $packing_details['voucher_date'] = $this->attributes['date'];
        $packing_details['packing_slip_balance'] =$packing_details['packing_slip_balance']- $packing_slip_detail['packing_slip_gross_weight'];
        $voucher_obj = new voucher_model($packing_details);
        $voucher_obj->update(false);
        $this->create_packing_slip_details($packing_details,$packing_slip_detail);
      }}
    }
  }
  private function create_packing_slip_details($packing_details,$packing_slip_details) {
    $this->load->model('argold/packing_slip_detail_model');
     $packing_slip_detail_data = array();
      $packing_slip_detail_data['weight'] = $packing_details['credit_weight'];
      $packing_slip_detail_data['purity'] = $packing_details['purity'];
      $packing_slip_detail_data['quantity'] = $packing_slip_details['packing_slip_quantity'];
      $packing_slip_detail_data['packing_slip_id'] = $packing_details['packing_slip_id'];
      $packing_slip_detail_data['voucher_id'] = $packing_details['id'];
      $packing_slip_detail_data['balance'] = $packing_details['packing_slip_balance'];
      $packing_slip_detail_data['stone'] = !empty($packing_slip_details['packing_slip_stone_percentag'])?($packing_slip_details['packing_slip_gross_weight']*$packing_slip_details['packing_slip_stone_percentag']/100):$packing_slip_details['packing_slip_stone'];
      $packing_slip_detail_data['gross_weight'] = $packing_slip_details['packing_slip_gross_weight'];
      $packing_slip_detail_data['net_weight'] = $packing_slip_details['packing_slip_gross_weight']-$packing_slip_detail_data['stone'];
      $packing_slip_detail_data['pure'] = $packing_slip_detail_data['net_weight']*$packing_details['purity']/100;
      $packing_slip_detail_data['making_charge'] = $packing_slip_details['packing_slip_making_charge'];
      $packing_slip_detail_data['colour'] = $packing_slip_details['packing_slip_colour'];
      $packing_slip_detail_data['code'] = $packing_slip_details['packing_slip_code'];
      $packing_slip_detail_data['description'] = $packing_slip_details['packing_slip_description'];
      $packing_slip_detail_data['category_name'] = $packing_slip_details['packing_slip_category_name'];
      $packing_slip_detail_data['category_2'] = $packing_slip_details['packing_slip_category_2'];
      $packing_slip_detail_data['sr_no'] = $packing_slip_details['packing_slip_sr_no'];
      $packing_slip_detail_data['site_name'] = $packing_details['site_name'];
      $packing_slip_detail_data['total'] = $packing_slip_detail_data['net_weight']*$packing_slip_details['packing_slip_making_charge'];
      $obj_packing_slip_detail=new packing_slip_detail_model($packing_slip_detail_data);
      $obj_packing_slip_detail->save();
  }  
  
  public function chitti_detail_exist($name) {
    if(empty($this->formdata['packing_slip_details'])){
      return false;
    }else{
      return true;
    }
    
  }
}