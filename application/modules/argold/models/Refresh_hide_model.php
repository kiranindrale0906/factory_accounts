<?php

class Refresh_hide_model extends BaseModel {
  protected $table_name= 'refresh';
  public $router_class= 'refresh_hides';
  public function __construct($data = array()){
    parent::__construct($data);
  }
  public function before_validate(){
    $this->attributes['refresh_hide'] = ($this->attributes['refresh_hide'] == 0) ? 1 : 0;
  }

  public function validation_rules($klass='') {
    $rules = array(array('field' => 'refresh_hides[id]', 'label' => 'id',
                         'rules' => 'required'));
    return $rules;
  }
}