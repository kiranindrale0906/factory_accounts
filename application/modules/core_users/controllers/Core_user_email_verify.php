<?php
class core_user_email_verify extends BaseController {
  public function __construct() {
    parent::__construct();
  }

  public function _before_save($formdata,$action) {
  	if($action=="store") {
  		$formdata['user_email_verify']['email_verified']=$_SESSION['email_id'];
	  	$formdata['user_email_verify']['id']=$_SESSION['user_id'];
	  	unset($formdata['user_email_verify']['verify_code']);
	  	return $formdata;	
  	}
  	else if($action=="update") {
  		$formdata['email_id']=$_SESSION['email_id'];
			$formdata['user_email_verify']['email_verify_code']=mt_rand(1000, 9999);
      $formdata['user_email_verify']['id']=$_SESSION['user_id'];
	  	unset($formdata['user_email_verify']['verify_code']);
	  	return $formdata;		
  	}
  } 
  
  public function store(){
  	$this->data['redirect_url']=base_url();
  	parent::store();
  }

  public function update($id) {
    $this->data['message']='Email Sent';
  	parent::update(0);
  }
}