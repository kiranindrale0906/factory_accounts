<?php

class Chitti_model extends BaseModel {

  protected $table_name = "chitties";
  public $router_class = "chittis";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  
  // public function before_validate(){
  //       if (isset($this->formdata['chitti_details'])  || !empty($this->formdata['chitti_details'])){
  //         $credit_weight=$fine=$purity=0;
  //         $chitti_ids=array_column($this->formdata['chitti_details'], 'chitti_id');
          
  //         $chitti_details=$this->voucher_model->get('sum(credit_weight) as credit_weight,
  //                                            (sum(credit_weight*purity) / sum(credit_weight)) as purity,
  //                                            (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,"" as voucher_number,packet_no',array('where_in'=>array('packet_no'=>$chitti_ids),'where'=>array('account_name'=>$this->attributes['account_name'],'purity'=>$this->attributes['purity'])),array(),array('group_by'=>'packet_no'));
  //         foreach ($chitti_details as $index => $chitti_detail) {
  //           $credit_weight+=$chitti_detail['credit_weight'];
  //           $fine+=$chitti_detail['credit_weight']*$chitti_detail['factory_purity']/100;
  //         }
  //         $this->attributes['weight']=$credit_weight;
  //         $this->attributes['fine']=$fine;
  //         $this->attributes['purity']=$this->attributes['purity'];
  //         $this->attributes['account_name']=$this->attributes['account_name'];
  //       }
  //     }
 public function save($after_save=false){
  $chittis=array();
   if (isset($this->formdata['chitti_details'])  || !empty($this->formdata['chitti_details'])){
          $credit_weight=$fine=$purity=0;
          $chitti_ids=array_column($this->formdata['chitti_details'], 'chitti_id');
    $chitti_details=$this->voucher_model->get('',array('where_in'=>array('packet_no'=>$chitti_ids),'where'=>array('account_name'=>$this->attributes['account_name'],'purity'=>$this->attributes['purity'])),array());
    foreach ($chitti_details as $index => $chitti_detail) {
      $start_process['weight']=$chitti_detail['credit_weight'];
      $start_process['fine']=$chitti_detail['fine'];
      $start_process['purity']=$chitti_detail['factory_purity'];
      $start_process['account_name']=$this->attributes['account_name'];
      $start_process['packet_no']=$chitti_detail['packet_no'];
      $start_process['voucher_id']=$chitti_detail['id'];
      $process_obj = new Chitti_model($start_process);
      $process_obj->before_validate();
      $process_obj->store();
      if (isset($chitti_detail['id'])) {
        $chittis['chitti_id'] = $process_obj->attributes['id'];
        $chitti_details_model = new voucher_model($chittis);
        $chitti_details_model->update(false,array('id'=>$chitti_detail['id']));
      }
    }
 }
}

 //  public function after_save($action){
 //  	$chitti_details=array();
 //    if (!isset($this->formdata['chitti_details']) || empty($this->formdata['chitti_details'])) return;
 //  	foreach ($this->formdata['chitti_details'] as $index => $chitti_detail) {
 //  	  if (isset($chitti_detail['chitti_id'])) {
 //  			$chitti_details['chitti_id'] = $this->attributes['id'];
 //  		  $chitti_details_model = new voucher_model($chitti_details);
 //     		$chitti_details_model->update(false,array('id'=>$chitti_detail['chitti_id']));
 //  		}
 //    }
	// }  

	public function validation_rules($klass='') {
    $rules= array(array('field' => 'chittis[date]', 'label' => 'Date',
									      'rules' => 'trim|required'));
    return $rules;
  }
}