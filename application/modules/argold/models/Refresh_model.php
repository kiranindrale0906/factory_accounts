<?php

class Refresh_model extends BaseModel {

  protected $table_name = "refresh";
  public $router_class = "refresh";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
  }
  
  public function before_validate() {
    $total_weight=$total_fine=$total_factory_fine=0;
    foreach ($this->formdata['refresh_details'] as $refresh_detail) {
      $total_weight+=$refresh_detail['weight'];
      $total_fine+=$refresh_detail['fine'];
      $total_factory_fine+=$refresh_detail['factory_fine'];
    }
    $this->attributes['weight']=$total_weight;
    $this->attributes['fine']=$total_fine;
    $this->attributes['factory_fine']=$total_factory_fine;
    $this->attributes['purity']=($total_fine/$total_weight)*100;
    $this->attributes['factory_purity']=($total_factory_fine/$total_weight)*100; 
  }
  public function after_save($action) {
    parent::after_save($action);
    $this->create_refresh_details();
  }

  private function create_refresh_details() {
    $this->load->model('argold/refresh_detail_model');
    if(empty($this->formdata['refresh_details'])) return true;

    foreach ($this->formdata['refresh_details'] as $refresh_detail) {
      $refresh_detail_data = array();
      $refresh_detail_data=$refresh_detail;
      $refresh_detail_data['refresh_id'] = $this->attributes['id'];
      $obj_refresh_detail=new refresh_detail_model($refresh_detail_data);
      $obj_refresh_detail->save();
    }
  }  
	public function validation_rules($klass='') {
    $rules[] = array('field' => 'refresh[weight]', 
                     'label' => 'Weight',
                     'rules' => 'trim|required|numeric|greater_than[0]');
    $rules[] = array('field' => 'refresh[purity]', 
                     'label' => 'Purity',
                     'rules' => 'trim|required|numeric|greater_than[0]');
    return $rules;
  }
}