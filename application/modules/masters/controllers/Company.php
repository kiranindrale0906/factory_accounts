<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->data['file_data'] = array(array('file_field_name'=>'logo',
                                           'file_controller'=>'company'));
  }

  public function index() {
  	if(!empty($_POST['set_company_id'])) {
  		$_SESSION['company_id']=$_POST['set_company_id'];
      echo json_encode(array('status'=>'success','js_function'=>'location.reload()')); die;
  	}
  	parent::index();
  }

  
}
