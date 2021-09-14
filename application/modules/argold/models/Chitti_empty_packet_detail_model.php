<?php

class Chitti_empty_packet_detail_model extends BaseModel {

  protected $table_name = "chitti_empty_packet_details";
  public $router_class = "chitti_empty_packet_details";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  
  public function save($after_save = true) {
    if(empty($this->formdata['empty_packet_details'])) return true;
    $this->chitti_empty_packet_detail_model->delete('',array('chitti_id'=>$this->attributes['chitti_id']));
    foreach ($this->formdata['empty_packet_details'] as $empty_packet_detail) {
      $empty_packet_detail['chitti_id']=$this->attributes['chitti_id'];
      $obj_empty_packet_detail=new chitti_empty_packet_detail_model($empty_packet_detail);
      $obj_empty_packet_detail->store(false);
    }
  }  
	public function validation_rules($klass='') {
    $rules[] = array('field' => 'chitti_empty_packet_details[chitti_id]', 
                     'label' => 'chitti_id',
                     'rules' => 'trim|required');
     return $rules;
  }
}