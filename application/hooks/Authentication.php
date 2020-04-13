<?php
class Authentication {
  function check_authentication() {
    $ci =& get_instance();
    $ci->load->helper('authentication/authentication');
    $ci->load->model('users/user_model');
    $ci->load->model('users/users_user_role_model');
    $url = $ci->router->module.'/'.$ci->router->class.'/'.$ci->router->method;
    if( ! empty($_SESSION['user_id'])):
      $ci->user_model->update_db_session($_SESSION['user_id']);
    endif;
    if(isset($_GET['access_token']) && !empty($_GET['access_token'])):
      $_SESSION = $ci->user_model->set_user_data_in_session(array("access_token" => $_GET['access_token']));
    endif;
    if(!isset($_SESSION['user_id'])
      && empty($_SESSION['user_id']) 
      && !in_array($url, available_urls_before_login())):
      if(isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']))
        $_SESSION['http_referer'] = uri_string().'?'.$_SERVER['QUERY_STRING'];
      else
        $_SESSION['http_referer'] = uri_string();
      redirect(base_url().'users/login/create');
    elseif(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && in_array($url, available_urls_before_login()) && !in_array($url, excluded_urls_before_after_login())):
      redirect(base_url());
    endif;
  }
}
?>
