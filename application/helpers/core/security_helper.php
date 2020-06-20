<?php
defined('BASEPATH') OR exit('No direct script access allowed.');

  if (!function_exists('sanitize_input_text')) {
    function sanitize_input_text($str){
      $CI = & get_instance();  // get instance, access the CI superobject
      return $CI->security->xss_clean($str);  //security library must be autoloaded
    }
  }

  if (!function_exists('sanitize_output_text')) {
    function sanitize_output_text($str){
      return htmlspecialchars($str);
    }
  }

  if (!function_exists('get_csrf_token')) {
    function get_csrf_token(){
      $CI = & get_instance();  // get instance, access the CI superobject
      $csrf = array(
        'name' => $CI->security->get_csrf_token_name(),  //csrf token key
        'hash' => $CI->security->get_csrf_hash()  //csrf token value
      );
      return $csrf;
    }
  }