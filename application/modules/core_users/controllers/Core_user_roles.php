<?php

class Core_user_roles extends BaseController {
  public function __construct($data=array()) {
    parent::__construct($data);
    $this->redirect_after_save =='index';
    $this->load->model(array('users/User_role_permission_model'));
  }

  public function _get_form_data(){
    $this->data['controllers'] = $this->user_role_model->get_controller_list();
    if($this->router->method == 'edit' || $this->router->method == 'update')
      $id = $this->data['record']['id'];
    else
      $id = '';
    $this->data['user_role_permissions'] = $this->getUserrolePermissions($id);
  }

  private function getUserrolePermissions($user_role_id='') {
    $user_role_permissions = array();

    if(!empty($user_role_id)):
      $query = "SELECT * FROM user_role_permissions WHERE id in (SELECT min(id) FROM user_role_permissions WHERE user_role_id =".$user_role_id." GROUP BY module_name)";
      $user_role_permissions = $this->db->query($query)->result_array();
    endif;
    
    $user_controllers = array_column($user_role_permissions, 'module_name');
    $controllers = $this->user_role_model->get_controller_list();
    foreach ($controllers as $key => $controller) { 
      if (!in_array($key, $user_controllers)) {
        $user_role_permission = array();
        $user_role_permission['module_name'] = $key;
        array_push($user_role_permissions, $user_role_permission);
      }
    }
    return $user_role_permissions;
  }

  public function view($id){ 
   if($_GET['check'] == 'permissions'){
     $this->data['user_role_permissions'] = $this->getUserrolePermissions($id);
     $this->data['id'] = $id;
     $this->data['title'] = 'Check Permissions';
     $this->data['data'] = $this->load->view('core_users/user_roles/view', $this->data, TRUE);
     $this->data['status'] = "success";
     echo json_encode($this->data);
   }else{
      redirect(base_url().'users/user_roles');
   }
  }

}