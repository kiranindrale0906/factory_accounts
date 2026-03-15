<?php
class Authorization {
  function check_url_authorization(){
    $current_url=base_url().@$_SERVER['REDIRECT_QUERY_STRING'];
    $ci =& get_instance();
    $ci->load->model(array('users/Users_user_role_model','users/User_role_permission_model','users/user_model'));
    $url = $ci->router->module.'/'.$ci->router->class.'/'.$ci->router->method;
    if(is_api_request()){
      $array = $ci->input->request_headers();
      $header = array_change_key_case($array, CASE_LOWER);
      if(!empty($header['authtoken'])){
        $user_id = $ci->user_model->find('id',array('authToken'=>$header['authtoken']))['id'];
        $user_session_data = $ci->user_model->set_user_data_in_session(array('id'=>$user_id));
        $_SESSION = $user_session_data;
      }else{
        if(!in_array($url, available_urls_before_login())){
          set_status_header(401);
          echo json_encode(array('status'=>'fail','message'=>'Please provide authtoken to access this api.'));exit;
        }
        return true;
      }
    }

    $action = $ci->router->method;
    $user_id = @$_SESSION['user_id'];
    $user_email_id = @$_SESSION['email_id'];
    $user_mobile_no = @$_SESSION['mobile_no'];   
    $user_role_ids_array = @$_SESSION['user_role_ids'];
    $email_flag=false;
    
    if(EMAIL_VERIFICATION && !empty($_SESSION['user_id']) && !in_array($url,available_urls_after_login())) {
      $check_email_verification=$ci->user_model->get('id', array('id'=>$user_id, 'email_verified'=>$user_email_id));
      if(empty($check_email_verification) 
        && ($current_url!=ADMIN_PATH."users/user_email_verify/create" 
        && $current_url!=ADMIN_PATH."users/user_email_verify/store" && $current_url!=ADMIN_PATH."users/user_email_verify/update/0")) {
          redirect(ADMIN_PATH."users/user_email_verify/create");
      }
      if($check_email_verification)
        $email_flag=true;
      
    }
    else
      $email_flag=true;
    
    if(MOBILE_VERIFICATION && !empty($_SESSION['user_id']) && $email_flag==true && !in_array($url,available_urls_after_login())) {
      $check_mobile_verification=$ci->user_model->get('id', array('id'=>$user_id, 'mobile_verified'=>$user_mobile_no));
      if(empty($check_mobile_verification) 
        && ($current_url!=ADMIN_PATH."users/user_mobile_verify/create" 
        && $current_url!=ADMIN_PATH."users/user_mobile_verify/store" && $current_url!=ADMIN_PATH."users/user_mobile_verify/update/0")) {
        redirect(ADMIN_PATH."users/user_mobile_verify/create");
      }
    }
    
    if (!in_array($url, available_urls_before_login()) && !in_array($url,available_urls_after_login())) {
      
      $user_role_ids_array = $_SESSION['user_role_ids'];
      $user_id = $_SESSION['user_id'];
      
      if(is_api_request() && empty($user_role_ids_array)){ 
        set_status_header(401);
        echo json_encode(array('status'=>'fail','message'=>'Invalid authtoken'));exit;
      }

      $role_permissions = ''; 
      if (!empty($user_role_ids_array)) {
        if ($action == 'update')
          $action = 'edit';
        elseif ($action == 'store')
          $action = 'create';

        $role_permissions = '';
        if ($action=='index' || $action=='create' || $action=='edit' || $action=='view' || $action=='delete'){

          $user_role_ids = implode(', ',$user_role_ids_array);
          $role_permissions = $ci->User_role_permission_model->find('*',
                                   array('controller_name' =>$ci->router->module.'/'.$ci->router->class,
                                     $action => 1, 'where_in' => array('user_role_id' => $user_role_ids)
                                                        ));
        }
      }

      if (empty($role_permissions) 
          /*&& !($action == 'index')*/) {
        $array = $ci->input->request_headers();
        $header = array_change_key_case($array, CASE_LOWER);
        if ($this->is_ajax()) {
          echo ('Access Denied'); 
          die();
        } elseif(array_key_exists ('authorization', $header ) || array_key_exists ('authtoken', $header)){
          set_status_header(403);
          echo json_encode(array('status'=>'fail','message'=>'Permission Denied, Please contact admin.'));
          exit;
        }
        $ci->load->view('errors/html/403_access_denied');
        die();
      }
    }
  }
  private function is_ajax() {
    $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    return $is_ajax;
  }
}

?>