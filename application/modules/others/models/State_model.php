<?php

class State_model extends BaseModel {

  protected $table_name = "ac_state";
  protected $id = "id";
  public $router_class = "states";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
            array('field' => 'states[name]', 'label' => 'Name', 'rules' => 'trim|required')
          );
  }
}