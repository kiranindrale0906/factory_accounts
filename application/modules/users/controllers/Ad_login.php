<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/core_users/controllers/Core_login.php";
class Ad_login extends Core_login {
  public function __construct() {
    parent::__construct();
    $this->load->helper('core_users/core_login');
    $this->load->model(array('users/user_model','users/users_user_role_model'));
  }

   public function _before_save($formdata, $action){
  	$get_login_data = $this->ldap->connect($formdata['ad_login']['email_id'],$formdata['password']);
  	if($get_login_data){
  		$formdata['ad_login']['name'] = $get_login_data['username'];
      $formdata['ad_login']['id']   = 3;
      $formdata['ad_login']['last_sign_in_at'] = date('Y-m-d H:i:s');
      $formdata['ad_login']['last_sign_in_ip'] = $_SERVER['REMOTE_ADDR'];
      $formdata['user_roles']['user_id'] = $get_login_data['username'];
      $formdata['user_roles']['user_role_id'] = 2;
  	}
	  return $formdata;
  }


   public function _after_save($formdata, $action){
    $user_data = $this->User_model->set_user_data_in_session(array("email_id" => $formdata['ad_login']['email_id']));
    $this->session->set_userdata($user_data);
    if(isset($_SESSION['http_referer']) && !(empty($_SESSION['http_referer'])))
      $redirect_url =  $_SESSION['http_referer'];
    else
      $redirect_url = base_url();
    redirect($redirect_url);
  }

}
