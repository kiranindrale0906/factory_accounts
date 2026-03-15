<?php
require_once APPPATH . "modules/core_users/models/Core_login_model.php";
class  Ad_login_model extends Core_login_model {
	public $router_class = 'ad_login';
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    $rules = array(
              array('field' => 'ad_login[email_id]',
                    'label' => 'Username',
                    'rules' => array('trim', 'required')),
              array('field' => 'password',
                    'label' => 'Password',
                    'rules' => array('trim', 'required', array('verify_password_message',
                                                                array($this,'verify_password'))),
                    'errors' => array('verify_password_message' => 'Please enter a valid username and password'))
            );
    return $rules;
  }

  public function verify_password($encrypted_password) {
    $is_password_right = $this->ldap->connect($this->attributes['email_id'],$encrypted_password,false);
    return $is_password_right;
  }

  public function after_save($action){
    $user_user_role_model = new users_user_role_model;
    $get_user_role = $user_user_role_model->find('',array('user_id'=>$this->formdata['user_roles']['user_id']));
    if(empty($get_user_role)){
      $user_user_role_model->attributes = $this->formdata['user_roles'];
      $user_user_role_model->store();
    }
  }

  /*public function after_save($action){
    if(!empty($this->formdata) && isset($this->formdata['username'])){
      $this->user_model->set_user_data_in_session(array('id'=>$this->formdata['username']));
    }*/
  //}
}

