<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/core_users/controllers/Core_login.php";
class Login extends Core_login {
  public function __construct($data=array()) {
    parent::__construct($data);
    $this->load->helper('core_users/core_login');
  }

  public function _before_save($formdata, $action) {
    $id = $this->User_model->get('id',array("email_id" => $formdata['login']['email_id']), '',
    														array('row_array' => true))['id'];
    $formdata['login']['id'] = $id;
    $formdata['login']['last_sign_in_at'] = date('Y-m-d H:i:s');
    $formdata['login']['last_sign_in_ip'] = $_SERVER['REMOTE_ADDR'];
    return $formdata;
  } 

  public function _after_save($formdata, $action) {
     $user_data = $this->User_model->set_user_data_in_session(
    							array("email_id" => $formdata['login']['email_id']));
    if(!is_api_request()) {
    $this->session->set_userdata($user_data);
    if(isset($_SESSION['http_referer']) && !(empty($_SESSION['http_referer'])))
      $redirect_url =  $_SESSION['http_referer'];
    else
      $redirect_url = base_url();
      redirect($redirect_url);
    }
  }
}
