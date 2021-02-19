<?php

class Chitti_hide_model extends BaseModel {
  protected $table_name= 'chitties';
  public $router_class= 'chitti_hides';
  public function __construct($data = array()){
    parent::__construct($data);
  }
  public function before_validate(){
    $this->attributes['chitti_hide'] = ($this->attributes['chitti_hide'] == 0) ? 1 : 0;
  }

  public function validation_rules($klass='') {
    $rules = array(array('field' => 'chitti_hides[id]', 'label' => 'id',
                         'rules' => 'required'));
    return $rules;
  }
}