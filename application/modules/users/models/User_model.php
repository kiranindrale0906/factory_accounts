<?php
require_once APPPATH . "modules/core_users/models/Core_user_model.php";
class User_model extends Core_user_model {
	protected $table_name="ac_users";
  public $router_class="users";
	//protected $load_trigger = true;
  public function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('masters/company_model'));
  }

  public function after_save($action) {
    $this->save_user_roles();
  }

  private function save_user_roles(){
    if(!empty($this->formdata['users_user_roles']['user_role_id'])):
      if($this->_is_user_roles_updated($this->attributes['id'], $this->formdata['users_user_roles']['user_role_id'])){
        $this->users_user_role_model->delete('',array('user_id' => $this->attributes['id']),true);
        foreach($this->formdata['users_user_roles']['user_role_id'] as $index => $user_role_id):
          $users_user_role  = new Users_user_role_model();
          $users_user_role->attributes['user_role_id'] = $user_role_id;
          $users_user_role->attributes['user_id'] = $this->attributes['id'];
          $users_user_role->save();
        endforeach;
        $this->delete_all_user_sessions($this->attributes['id']);
      }
    endif;
  }

  public function validate($validation_klass='') {
    $this->before_validate();
    $rules = $this->validation_rules();
    $users_user_roles_rules = $this->users_user_role_model->validation_rules('');
    $rules = array_merge($rules, $users_user_roles_rules);
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_data($this->formdata);
    return $this->form_validation->run();
  }

  public function validation_rules($klass='') {
    $basic_validation = array();
    $password_validation = array();
    $rules = array();

    $basic_validation =  array(
                          array('field' => 'users[name]', 'label' => 'User Name', 
                                'rules' => 'trim|required|max_length[50]'),
                          array('field' => 'users[email_id]', 'label' => 'Email',
                                'rules' => array('trim', 'required', 'max_length[50]', 'valid_email',
                                           array('unique_email', array($this, 'is_email_unique'))),
                                'errors'=> array('unique_email' => "Email already exists.")),
                          array('field' => 'users[mobile_no]', 'label' => 'Contact No',
                                'rules' => 'trim|required|max_length[50]'));
    if($this->router->method == 'create' || $this->router->method == 'store') {
      $password_validation = array(
                              array('field' => 'users[password]', 'label' => 'Password',
                                    'rules' => 'trim|required|max_length[255]|matches[confirm_password]'),
                              array('field' => 'confirm_password', 'label' => 'Confirm Password',
                                    'rules' => 'trim|required|max_length[50]'));
    }
    
    return $rules = array_merge($basic_validation, $password_validation);
  }

  public function is_email_unique($str) { 
    return parent::check_unique('email_id');
  }

  public function before_save($action) {
    if($action == 'store') {
      $this->attributes['password'] = md5($this->attributes['password']);
      //unset($this->attributes['password']);
    }
    $this->attributes['all_details']=!empty($_POST['users']['all_details'])?$_POST['users']['all_details']:0;
    $this->attributes['arg_details']=!empty($_POST['users']['arg_details'])?$_POST['users']['arg_details']:0;
    $this->attributes['arf_details']=!empty($_POST['users']['arf_details'])?$_POST['users']['arf_details']:0;
    $this->attributes['arc_details']=!empty($_POST['users']['arc_details'])?$_POST['users']['arc_details']:0;
    $this->attributes['vodator_report']=!empty($_POST['users']['vodator_report'])?$_POST['users']['vodator_report']:0;
    $this->attributes['production_report']=!empty($_POST['users']['production_report'])?$_POST['users']['production_report']:0;
    $this->attributes['do_not_check_ip']=!empty($_POST['users']['do_not_check_ip'])?$_POST['users']['do_not_check_ip']:0;
  }

  public function set_user_data_in_session($where_condition) {
    $user = $this->find('',$where_condition);

    $user_role_ids = $this->get_user_role_ids($user['id']);
    $this->delete_all_user_sessions($user['id']);
    $this->update_db_session($user['id']);
    return  array(
              'user_id'         => $user['id'],
              'name'            => $user['name'],
              'mobile_no'       => $user['mobile_no'],
              'all_details'        => $user['all_details'],
              'arg_details'        => $user['arg_details'],
              'arf_details'        => $user['arf_details'],
              'arc_details'        => $user['arc_details'],
              'do_not_check_ip'        => $user['do_not_check_ip'],
              'vodator_report'        => $user['vodator_report'],
              'production_report'        => $user['production_report'],
              'email_id'        => $user['email_id'],
//              'authToken'       => $user['authToken'],
              'last_sign_in_at' => $user['last_sign_in_at'],
              'user_role_ids'   => $user_role_ids,
              'is_email_verify' => @$user['is_email_verify'],
              'company_id'    => $this->company_model->find('id')['id'],
//              'password_updated_at' => $user['password_updated_at'],
              'controller_list' => $this->get_user_controller_list($user_role_ids)
            );
  }

  public function update_db_session($user_id) {
    if( ! empty($user_id)) {
      $this->db->update('ci_sessions', array('user_id' => $user_id), array('id' => session_id()));
    }
  }

  public function delete_all_user_sessions($user_id = null) {
    if( ! empty($user_id)) {
      return $this->db->delete('ci_sessions', array('user_id' => $user_id));
    } 
  }

  private function get_user_role_ids($user_id) {
    $user_roles = $this->users_user_role_model->get('user_role_id', array('user_id'=>$user_id));

    // $user_role_ids = implode(', ', array_column($user_roles, 'user_role_id'));
    return array_column($user_roles, 'user_role_id');
  }

  public function get_user_controller_list($user_role_ids) {
    $user_role_ids=!empty($user_role_ids)?$user_role_ids:0;
    $controller_list = $this->user_role_permission_model->get('controller_name 
                                                              as controller_name',
                                                              array('where_in' => 
                                                                array('user_role_id' => $user_role_ids)));
    
    return array_column($controller_list, 'controller_name');
  }

  private function _is_user_roles_updated($user_id, $new_roles) {
    $current_roles = $this->get_user_role_ids($user_id);
    if(count(array_diff($current_roles, $new_roles)) == 0 && count(array_diff($new_roles, $current_roles)) == 0)
      return false;
    else
      return true;
  }
}