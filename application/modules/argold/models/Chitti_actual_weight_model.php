<?php

class Chitti_actual_weight_model extends BaseModel {
  protected $table_name= 'chitties';
  public $router_class= 'chitti_actual_weights';
  public function __construct($data = array()){
    parent::__construct($data);
  }
  public function before_validate(){
    $this->attributes['diff_weight'] = $this->attributes['expected_weight'] - $this->attributes['actual_weight'];
  }

  public function validation_rules($klass='') {
    $rules = array(array('field' => 'chitti_actual_weights[id]', 'label' => 'id',
                         'rules' => 'required'),
                   array('field' => 'chitti_actual_weights[actual_weight]', 'label' => 'Actual Weight',
                         'rules' => 'required'));
    return $rules;
  }
}