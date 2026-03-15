<?php

class Account_wise_detail_model extends BaseModel {

  protected $table_name = "ac_account_wise_details";
  protected $id = "id";
  public $router_class = "account_wise_details";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
            array('field' => 'account_wise_details[name]', 'label' => 'Name', 'rules' => 'trim|required'),
            array('field' => 'account_wise_details[area]', 'label' => 'Area', 'rules' => 'trim|required')
          );
  }
  }