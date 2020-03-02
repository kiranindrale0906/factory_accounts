<?php
class  Core_forgot_password_model extends BaseModel {
  protected $table_name = 'users'; 
  protected $load_trigger = true;
  public $router_class='forgot_password';
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='', $index=0) {
    $rules = array(
              array('field' => 'forgot_password[email_id]',
                    'label' => 'Email',
                    'rules' => array('trim', 'required', 'valid_email', 
                               array('verify_email_message',array($this,'verify_email'))),
                    'errors' => array('verify_email_message' => 'Your email address is not registered in system'))
            );
    return $rules;
  }

  public function verify_email($email) {
    $user_id = $this->forgot_password_model->get('id', array("email_id" => $this->attributes['email_id']));
    return (!empty($user_id[0]['id']) ) ? true : false;
  }

}
