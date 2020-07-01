<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

 function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

  if (!function_exists('is_api_request')) {
    function is_api_request() {
      $array = array(); //$this->input->request_headers();
      $header = array_change_key_case($array, CASE_LOWER);
      if(array_key_exists ('authorization', $header ) || array_key_exists ('authtoken', $header )){
        return TRUE;
      }
      return FALSE; 
    }
  }

  if (!function_exists('curl_post_request')) {
    function curl_post_request($uri, $data = array()) {
      if(!empty($uri)) {
        $api_url=$uri;
        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  http_build_query($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'access_token:'.ACCESS_TOKEN
        ]);

        $response = curl_exec($curl);
        if(curl_errno($curl))
        {
            $response=array('status'=>'error','response'=>json_encode($response));
        }
        curl_close($curl);
        return $response;
      }
      else
      {
        return 'API URL and/or access token not defined';
      }
    }
  }