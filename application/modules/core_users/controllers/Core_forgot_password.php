<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Core_forgot_password extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('User_model'));
    $this->load->library('encrypt');
    $this->data['layout'] = 'login';
  }

  public function store(){
    $this->data['redirect_url']=BASE_URL."users/login/create";
    parent::update(0);
  }

  public function _before_save($formdata, $action){
    $user = $this->User_model->get('id',array("email_id" => $formdata['forgot_password']['email_id']));
    if(!empty($user)):
      $formdata['forgot_password']['id'] = $user[0]['id'];
      $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'.$formdata['forgot_password']['email_id'];
      $formdata['forgot_password']['reset_token'] =md5(substr(str_shuffle($string), 0, 100));
    endif;
    return $formdata;
  }
}
?>