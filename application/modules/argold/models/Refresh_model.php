<?php

class Refresh_model extends BaseModel {

  protected $table_name = "refresh";
  public $router_class = "refresh";
  protected $id = "id";

  public function __construct($data = array()){
		parent::__construct($data);
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
      $refresh_detail_data['purity'] = $this->attributes['purity'];
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