<?php
class  Core_reset_password_model extends BaseModel {
  protected $table_name = 'users'; 
  protected $id = 'id';
  public $router_class = 'reset_password';
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules = array(
              array('field' => 'reset_password[password]',
                    'label' => 'Password',
                    'rules' => array('trim', 'required'),
                  ),
              array('field' => 'confirm_password',
                    'label' => 'Confirm Password',
                    'rules' => array('trim', 'required', 'matches[reset_password[password]]'),
                  ),
            );
    return $rules;
  }

}
