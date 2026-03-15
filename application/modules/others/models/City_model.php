<?php

class City_model extends BaseModel {

  protected $table_name = "ac_city";
  protected $id = "id";
  public $router_class = "cities";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
            array('field' => 'cities[name]', 'label' => 'Name', 'rules' => 'trim|required')
          );
  }
}