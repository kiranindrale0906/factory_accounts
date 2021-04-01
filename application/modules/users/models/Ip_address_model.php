<?php
class Ip_address_model extends BaseModel {
  protected $table_name = 'ip_addresses';
  protected $id = 'id';

  public function __construct($data = array()) {
    parent::__construct($data);
  }
  public function validation_rules($klass='') {
    return array(
            array('field' => 'ip_addresses[ip_address]', 
                  'label' => 'Ip Address', 
                  'rules' => 'trim|required'),
           );
  }
}