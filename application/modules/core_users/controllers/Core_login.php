<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Core_login extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('users/User_model','users/users_user_role_model','users/user_role_permission_model'));
    if ($this->db->table_exists('ip_addresses'))
      $this->load->model('users/ip_address_model');
    $this->data['layout'] = 'login';
  }

  public function store(){
    parent::update(0);
  }

  public function _before_save($formdata, $action) {
    $id = $this->User_model->get('id',array("email_id" => $formdata['login']['email_id']), '',array('row_array' => true))['id'];
    $formdata['login']['id'] = $id;
    $formdata['login']['last_sign_in_at'] = date('Y-m-d H:i:s');
    $formdata['login']['last_sign_in_ip'] = $_SERVER['REMOTE_ADDR'];
    return $formdata;
  } 

  public function _after_save($formdata, $action){
    $user_data = $this->User_model->set_user_data_in_session(array("email_id" => $formdata['login']['email_id']));
    
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
