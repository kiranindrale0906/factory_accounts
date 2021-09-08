<?php

class Empty_packet_model extends BaseModel {

  protected $table_name = "empty_packets";
  protected $id = "id";
  public $router_class="empty_packets";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
            array('field' => 'empty_packets[weight]', 'label' => 'Weight', 
            'rules' => array('trim','required','numeric')),
            array('field' => 'empty_packets[qty]','label' => 'Quantity', 
            'rules' => array('trim','required','numeric')));
  }
}
