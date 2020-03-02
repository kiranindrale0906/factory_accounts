<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->data['file_data'] = array(array('file_field_name'=>'logo',
                                           'file_controller'=>'company'));
  }
}
