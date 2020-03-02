<?php

class Period_model extends BaseModel {
  protected $table_name = "periods";
  protected $id = "id";

  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
    	array(
        'field' => 'periods[name]', 
        'label' => 'Name', 
        'rules' => 'trim|required'),
      array(
        'field' => 'periods[date_from]', 
        'label' => 'Date From', 
        'rules' => 'trim|required'),
      array(
        'field' => 'periods[date_to]', 'label' => 'Date',
        'rules' => array('trim', 'required', 
                      array('validate_date_from', array($this->Period_model, 'validate_date_greater_than'))),
        'errors'=>array('validate_date_from' => "Date should be greater than date from.")));
  }

  public function validate_date_greater_than($date_to) {
    $result=FALSE;
    if(empty($_POST[$this->router->class]["date_to"])) {
      $result=TRUE; 
    }
    else if(empty($_POST[$this->router->class]["date_to"])) {
      $result=TRUE;  
    }
    else {
      if($date_to<$_POST[$this->router->class]["date_from"])
        $result=FALSE;
      else
        $result=TRUE;
    }
    return $result;
  }
}
