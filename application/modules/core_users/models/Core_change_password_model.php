<?php
class  Core_change_password_model extends BaseModel {
  protected $table_name = 'users'; 
  protected $id = 'id';
  public $router_class = 'change_password';
  public function __construct($data=array()) {
    parent::__construct($data);
  }
  public function validation_rules($klass='') {
    $rules = array(
              array('field' => 'change_password[old_password]',
                    'label' => 'Contact No',
                    'rules' => array('trim', 'required', 'max_length[50]', 
                               array('verify_old_password_message',array($this,'verify_old_password'))),
                    'errors' => array('verify_old_password_message' => 'Your Old password is incorrect.')),
              array('field' => 'change_password[new_password]',
                    'label' => 'Password',
                    'rules' => 'trim|required|max_length[50]|matches[confirm_password]'),
              array('field' => 'confirm_password',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|max_length[50]')
            );
    return $rules;
  }
  public function verify_old_password($old_password) {
    $encrypted_password = $this->change_password_model->find('encrypted_password', array("email_id" => $_SESSION['email_id'], "id" => $_SESSION['user_id']));
    return ( !empty($encrypted_password) && ($encrypted_password['encrypted_password'] == md5($this->attributes['old_password'])) ) ? true : false;
  }
}
