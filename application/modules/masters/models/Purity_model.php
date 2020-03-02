<?php

class Purity_model extends BaseModel {

  protected $table_name = "ac_purity";
  protected $id = "id";
  public $router_class="purity";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
  	return array(
			array('field' => 'purity[purity]', 'label' => 'Purity', 
            'rules' => array('trim','required','numeric',
                        array('error_msg_purity',array($this,'check_duplicate_purity'))),
            'errors'=>  array('error_msg_purity'=>'Purity already exists'))
		);
  }

  public function check_duplicate_purity($purity) {
    return parent::check_unique('purity');
  } 
}
