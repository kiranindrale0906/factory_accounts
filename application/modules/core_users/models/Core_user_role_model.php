<?php

class Core_user_role_model extends BaseModel {
  protected $table_name = 'user_roles';
  protected $id = 'id';

  public function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('users/User_role_permission_model', 'users/users_user_role_model'));
  }

  public function after_save($action) {
    if(isset($this->formdata['user_role_permissions']))
      $user_role_permissions = $this->formdata['user_role_permissions'];
    else
      $user_role_permissions = array();

    if($this->_is_permissions_updated($this->attributes['id'], $user_role_permissions)){
      $this->User_role_permission_model->delete('', array('user_role_id'=>$this->attributes['id']), TRUE);
      foreach ($user_role_permissions as $module_name => $role_permission) {
        $controller_list = $this->get_controller_list($module_name);
        foreach($controller_list as $controller_name){
          $user_role_permission = new User_role_permission_model($role_permission);
          $user_role_permission->attributes['module_name'] = $module_name;
          $user_role_permission->attributes['controller_name'] = $controller_name;
          $user_role_permission->attributes['user_role_id'] = $this->attributes['id'];
          $user_role_permission->store();
        }
      }
      $this->delete_all_user_sessions_by_role($this->attributes['id']);
    }
  }

  public function validation_rules($klass='') {
    return array( array( 'field' => 'user_roles[name]',
                         'label' => 'Name',
                         'rules' => 'trim|required'));
  }

  public function get_controller_list($module_name='') {
    $modules = array('users' => array('users/users','users/user_roles'),
                     'tutorials' => array('tutorials/industries','tutorials/occupations','tutorials/employees','tutorials/transactions'/*,'tutorials/vendors','tutorials/my_documents_and_images'*/),
                     'communications' => array('communications/sms_logs','communications/email_logs'),
                     'workflows' => array('workflows/workflows', 'workflows/workflow_arcs',
                                          'workflows/workflow_workitems', 
                                          'workflows/workflow_places',
                                          'workflows/workflow_cases',
                                          'workflows/workflow_transitions', 
                                          'workflows/workflow_tokens'));
    return (!empty($module_name) ? $modules[$module_name] : $modules);
  }

  private function _get_current_permissions($role_id) {
    $this->db->distinct();
    $role_permissions = $this->User_role_permission_model->get('module_name, index,create,edit,view,delete', array('user_role_id'=>$role_id));
    $permissions = ['index','create','edit','view','delete'];
    $current_permissions = array();
    $modules = array_column($role_permissions, 'module_name');
    foreach ($modules as $index => $module){
      unset($role_permissions[$index]['module_name']);
      foreach($permissions as $permission)
        if($role_permissions[$index][$permission] == 0)
          unset($role_permissions[$index][$permission]);
      $current_permissions[$module] = $role_permissions[$index];
    };
  
    return $current_permissions;
  }

  private function _is_permissions_updated($role_id, $new_permissions) {
    $current_permissions = $this->_get_current_permissions($role_id);
    $is_updated = false;
    $current_modules = array_keys($current_permissions);
    $new_modules = array_keys($new_permissions);
    if(count(array_diff($current_modules, $new_modules)) != 0 || count(array_diff($new_modules, $current_modules)) != 0) {
      $is_updated = true;
    }
    if( ! $is_updated){
      foreach($new_permissions as $module => $new_permission){
        if(count(array_diff_key($current_permissions[$module], $new_permission)) != 0 || count(array_diff_key($new_permission, $current_permissions[$module])) != 0)
        {
            $is_updated = true;
        }
      }
    }
    return $is_updated;
  }

  public function delete_all_user_sessions_by_role($role_id = null){
    if( ! empty($role_id)){
      $user_ids = $this->_get_users_by_role($role_id);
      if( ! empty($user_ids)) {
        $this->db->where_in('user_id',$user_ids)
                 ->delete('ci_sessions');
      }
    } 
  }

  private function _get_users_by_role($role_id) {
    $users = $this->users_user_role_model->get('user_id', array('user_role_id'=>$role_id));
    return $user_ids = array_column($users, 'user_id');
  }

}
