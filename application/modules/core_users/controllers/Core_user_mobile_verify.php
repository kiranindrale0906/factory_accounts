<?php
class Core_user_mobile_verify extends BaseController {
  public function __construct() {
    parent::__construct();
  }

  public function _before_save($formdata,$action) {
  	if($action=="store"){
  		$formdata['user_mobile_verify']['mobile_verified']=$_SESSION['mobile_no'];
	  	$formdata['user_mobile_verify']['id']=$_SESSION['user_id'];
	  	unset($formdata['user_mobile_verify']['verify_code']);
	  	return $formdata;	
  	}
  	if($action=="update"){
  		$formdata['user_mobile_verify']['mobile_verified']=$_SESSION['mobile_no'];
  		$formdata['user_mobile_verify']['mobile_verify_code']=mt_rand(1000, 9999);
	  	$formdata['user_mobile_verify']['id']=$_SESSION['user_id'];
	  	unset($formdata['user_mobile_verify']['verify_code']);
	  	return $formdata;	
  	}
  }

  public function store(){
  	$this->data['redirect_url']=base_url();
  	parent::store();
  }

  public function update($id) {
    $this->data['message']='SMS Sent';
    parent::update(0);
  }
}