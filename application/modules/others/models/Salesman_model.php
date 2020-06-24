<?php

class Salesman_model extends BaseModel {

  protected $table_name = "ac_salesman";
  protected $id = "id";
  public $router_class = "salesmans";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'salesmans[name]', 
        'label' => 'Name', 
        'rules' => 'trim|required'),
      array(
        'field' => 'salesmans[salesman_code]', 
        'label' => 'Salesman Code', 
        'rules' => 'trim|required'),
    );
  }
}
?>