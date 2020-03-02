<?php

class Opening_balance_model extends BaseModel {
  protected $table_name = "ac_opening_balance";
  protected $id = "id";

  function __construct($data=array()) {
      parent::__construct($data);
  }
  
  public function validation_rules($klass='') {
    return array(
		      array('field' => 'opening_balance[date]', 'label' => 'Date', 'rules' => 'trim|required|check_date'),
		      array('field' => 'opening_balance[account_name_id]', 'label' => 'Account Name', 'rules' => 'trim|required|check_obv_amount'),
		      array('field' => 'opening_balance[group_code]', 'label' => 'Group Code', 'rules' => 'trim|required'),
		      array('field' => 'opening_balance[credit_amount]', 'label' => 'Credit Amount', 'rules' => 'trim|numeric|check_amount_opening_bal'),
		      array('field' => 'opening_balance[debit_amount]', 'label' => 'Debit Amount', 'rules' => 'trim|numeric'),
		      array('field' => 'opening_balance[credit_weight]', 'label' => 'Credit Weight', 'rules' => 'trim|numeric|check_weight_opening_bal'),
		      array('field' => 'opening_balance[debit_weight]', 'label' => 'Debit Weight', 'rules' => 'trim|numeric')
  	);
  }

}

