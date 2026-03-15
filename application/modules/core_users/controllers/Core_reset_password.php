<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Core_reset_password extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('User_model'));
    $this->data['layout'] = 'login';
  }

  public function _before_save($formdata, $action){
    $user = $this->User_model->get('id', array("reset_token" => $formdata['reset_password']['reset_token']."'"));
    $formdata['reset_password']['id'] = $user[0]['id'];
    $formdata['reset_password']['encrypted_password'] = md5($formdata['reset_password']['password']);
    $formdata['reset_password']['reset_token'] = '';
    unset($formdata['reset_password']['password']);
    return $formdata;
  }

  public function _after_save($formdata, $action){
    redirect(BASE_URL);
  }

  public function edit($reset_token) {
    $user = $this->User_model->get('id', array("reset_token" => $reset_token));
    if(empty($user))
      redirect(BASE_URL.'users/login');
    else {
      $this->data['record']['reset_token'] = $reset_token;
      parent::edit($reset_token);
    }

  }

}
?>  
