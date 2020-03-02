<?php
require_once APPPATH . "modules/core_users/models/Core_login_model.php";
class  Login_model extends Core_login_model {
	protected $table_name = 'ac_users'; 
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function _generate_token(){
    $this->load->helper('security');
    $salt = do_hash(time().mt_rand());
    $new_key = substr($salt, 0, 20);

    return $new_key;
  }

  public function validation_rules($klass='') {
    $rules = array(
              array('field' => 'login[email_id]',
                    'label' => 'Email',
                    'rules' => array('trim', 'required', 'valid_email'/*, 
                                      array('user_has_role_message',
                                            array($this,'user_has_role'))*/),                    
                    'errors' => array('user_has_role_message' => 'Please enter a valid email')),
              array('field' => 'password',
                    'label' => 'Password',
                    'rules' => array('trim', 'required', array('verify_password_message',
                                                                array($this,'verify_password'))),
                    'errors' => array('verify_password_message' => 'Please enter a valid password'))
            );
    return $rules;
  }

  public function verify_password($encrypted_password) {
    $hashed_password = $this->login_model->find('password', 
    																						array("email_id" => $this->attributes['email_id']), '', 
    																						array('row_array' => true));
    if(!empty($hashed_password)){
      $verified = (md5($encrypted_password) == $hashed_password['password']) ? true : false;
      if(password_verify($encrypted_password, $hashed_password['password'])) {
        return true;
      }else{
        if($verified) return $verified;
      }
    }
    else{
      return false;
    }
  }

  public function user_has_role($email_id) {
    $user = $this->login_model->get('id', array("email_id" => $this->attributes['email_id']), '', 
    																array('row_array' => true));
    $user_roles = $this->users_user_role_model->get('user_role_id', array('user_id'=>$user['id']));
    return ( ! empty($user_roles));
  }

}