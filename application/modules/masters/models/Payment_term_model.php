<?php

class Payment_term_model extends BaseModel {
  protected $table_name = "ac_payment_terms";
  protected $id = "id";
  public $router_class="payment_terms";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array('field' => 'payment_terms[terms]', 'label' => 'Payment terms', 
            'rules' => array('trim','required',
                            array('error_msg_payment_terms',array($this,'check_duplicate_payment'))),
            'errors'=>  array('error_msg_payment_terms'=>'Payment term already exists'))
  	);
  }

  public function check_duplicate_payment($payment_terms) {
    return parent::check_unique('terms');
  }

}
