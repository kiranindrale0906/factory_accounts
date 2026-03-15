<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Core_register extends BaseController {

  public function __construct(){
    parent::__construct();
    $this->data['layout'] = 'login';
  }

  public function _after_save($formdata, $action){
   redirect(base_url().'users/login/create');
  }
}
