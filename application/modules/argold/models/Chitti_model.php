<?php

class Chitti_model extends BaseModel {

  protected $table_name = "chitties";
  public $router_class = "chittis";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  

 public function save($after_save=true){
  $chitti_ids=array_column($this->formdata['chitti_details'], 'chitti_id');
  $chitti_details=$this->voucher_model->get('sum(credit_weight) as credit_weight,
                                             (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                                             (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,"" as voucher_number,packet_no,voucher_date',array('where_in'=>array('packet_no'=>$chitti_ids),'where'=>array('account_name'=>$this->attributes['account_name'],'purity'=>$this->attributes['purity'])),array(),array('group_by'=>'packet_no,voucher_date'));
    foreach ($chitti_details as $index => $chitti_detail) {
      $start_process['weight']=$chitti_detail['credit_weight'];
      $start_process['fine']=$chitti_detail['credit_weight']*$chitti_detail['factory_purity']/100;
      $start_process['purity']=$this->attributes['purity'];
      $start_process['factory_purity']=$chitti_detail['factory_purity'];
      $start_process['date']=$chitti_detail['voucher_date'];
      $start_process['account_name']=$this->attributes['account_name'];
      $start_process['packet_no']=$chitti_detail['packet_no'];
      $process_obj = new Chitti_model($start_process);
      $process_obj->before_validate();
      $process_obj->store();

    }

}


  public function after_save($action){
  	$chittis=array();
    if (!isset($this->formdata['chittis']) || empty($this->formdata['chittis'])) return;
    $chitti_details=$this->voucher_model->get('',array('packet_no'=>$this->formdata['chittis']['packet_no'],'account_name'=>$this->attributes['account_name'],'purity'=>$this->attributes['purity']),array());
  	foreach ($chitti_details as $index => $chitti_detail) {
  	  if (isset($chitti_detail['id'])) {
  			$chittis['chitti_id'] = $this->attributes['id'];
  		  $chitti_details_model = new voucher_model($chittis);
     		$chitti_details_model->update(false,array('id'=>$chitti_detail['id']));
  		}
    }
	}  

	public function validation_rules($klass='') {
    $rules= array(array('field' => 'chittis[date]', 'label' => 'Date',
									      'rules' => 'trim|required'));
    return $rules;
  }
}