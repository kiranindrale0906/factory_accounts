<?php 
class Email_verification extends BaseController {
  protected $load_helper = false;
  public function __construct() {
    parent::__construct();
    $this->load->model('core_users/core_user_model');
  }
  
  public function update($id){ 
    $user_data['id']=$id;
    $user_data['is_email_verify'] =1;
    $user = new Core_user_model($user_data);
    $user->save();
    $session_data = $this->core_user_model->set_user_data_in_session(array('id' => $user_data['id']));
    $this->session->set_userdata($session_data);
    redirect(base_url()); 
  }

}
