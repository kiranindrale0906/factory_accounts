
<?php

class Opening_quator_model extends BaseModel {

  protected $table_name = "opening_loss_vouchers";
  public $router_class = "opening_quators";
  protected $id = "id";

  public function __construct($data = array()){
    parent::__construct($data);
    $this->load->model(array('masters/account_model', 'transactions/rate_cut_issue_voucher_model'));
  }


  public function validation_rules($klass='') {
    $rules[] = array('field' => 'opening_quators[quator]', 
                     'label' => 'Quator',
                     'rules' => 'trim|required');
    return $rules;
  }
}