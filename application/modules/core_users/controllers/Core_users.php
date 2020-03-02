<?php
class Core_users extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->helper(array('core_users/core_users'));
    // $this->redirect_after_save = 'view'; 
    $this->load->model(array('User_role_model',
                             'Users_user_role_model'));
  }

  public function _get_form_data(){
    $this->data['user_role_options'] = $this->User_role_model->get('id,name');
    if($this->router->method == 'store' || $this->router->method == 'update'){
     $this->data['users_user_role_ids'] = @$_POST['users_user_roles']['user_role_id']; 
    }
    else if($this->router->method == 'edit'){
      $users_user_roles = $this->Users_user_role_model->get('user_role_id', array('where' => array('user_id' => $this->data['record']['id'])));
      $this->data['users_user_role_ids'] = array_column($users_user_roles, 'user_role_id');
    }
  }

  public function _get_view_data(){
    $users_user_roles = $this->Users_user_role_model->get('user_role_id', array('where' => array('user_id' => $this->data['record']['id'])));
    $users_user_role_ids = implode(",",array_column($users_user_roles, 'user_role_id'));
    if (!empty($users_user_role_ids)){
      $user_role_names = $this->User_role_model->get('name', 
                                                      array('where_in' => 
                                                            array('id' => array($users_user_role_ids))));
      $this->data['record']['user_role_id'] = implode(",",array_column($user_role_names, 'name'));
    }
  }

  public function edit($user_id){
    if($this->input->get('delete_sessions') == 1){
      if($this->user_model->delete_all_user_sessions($user_id))
        redirect(base_url('users'));
    }
    else
      parent::edit($user_id);
  }
}
