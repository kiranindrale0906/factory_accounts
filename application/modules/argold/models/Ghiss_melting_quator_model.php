
<?php

class Ghiss_melting_quator_model extends BaseModel {

  protected $table_name = "ac_vouchers";
  public $router_class = "ghiss_melting_quators";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
    $this->load->model(array('masters/account_model', 'transactions/rate_cut_issue_voucher_model'));
  }


  public function validation_rules($klass='') {
    $rules[] = array('field' => 'ghiss_melting_quators[quator]', 
                     'label' => 'Weight',
                     'rules' => 'trim|required|numeric|greater_than_equal_to[0]');
    return $rules;
  }
}