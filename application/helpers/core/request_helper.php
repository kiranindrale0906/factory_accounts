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
if (!function_exists('get_curl_expenses')) {
  function get_curl_expenses($url){

   $curl = curl_init();

 	curl_setopt_array($curl, array(
 	 CURLOPT_URL => $url,
 	 CURLOPT_RETURNTRANSFER => true,
  	 CURLOPT_ENCODING => '',
  	 CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
  	 CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',CURLOPT_SSL_VERIFYPEER => false,
         CURLOPT_HTTPHEADER => array(
         'Cookie: ci_session=igld4p8e8kndnb6l7e2547jalsvqq4vr'
  	),
	));

	$response = curl_exec($curl);
        if ($response === false) {
    	echo 'cURL Error: ' . curl_error($curl);
	} else {
    // Print the response
    	return  $response;
	}} }
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
//       pd($curl);
        $response = curl_exec($curl);
//pd($response);
        if(curl_errno($curl))
          $response=array('status'=>'error','response'=>json_encode($response));
        curl_close($curl);
        return $response;
      } else
        return 'API URL and/or access token not defined';
    }
  }
  if (!function_exists('get_web_page')) {
     function get_web_page($url) {
      $options = array(
          CURLOPT_RETURNTRANSFER => true,   // return web page
          CURLOPT_HEADER         => false,  // don't return headers
          CURLOPT_FOLLOWLOCATION => true,   // follow redirects
          CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
          CURLOPT_ENCODING       => "",     // handle compressed
          CURLOPT_USERAGENT      => "test", // name of client
          CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
          CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
          CURLOPT_TIMEOUT        => 120,    // time-out on response
      ); 

      $ch = curl_init($url);
      curl_setopt_array($ch, $options);

      $content  = curl_exec($ch);

      curl_close($ch);

      return $content;
    }
  }
 if(!function_exists('curl_get_erp_token')){
   function curl_get_erp_token($uri="", $data = array()) {
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://erp.ar-gold.in/api/method/custom_app.api.login.get_access_token?usr=administrator&pwd=Ascra%408848',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
      'Cookie: full_name=Guest; sid=Guest; system_user=no; user_id=Guest; user_image='
      ),
     ));

     $response = curl_exec($curl);

    curl_close($curl);
    return $response;
   }}
  if (!function_exists('curl_post_erp_request')) {
    function curl_post_erp_request($uri, $data = array()) {
    $records = json_decode(curl_get_erp_token($url="", $_GET=array()));
    $erp_records = json_decode(json_encode($records), true);

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL =>$uri,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
          //'Authorization: token 4e7ab0aec03a4f2:7066e1925da5f9d',4e7ab0aec03a4f2:7c92597cb5b8fd4
          //'Authorization: token 4e7ab0aec03a4f2:a2e2945d24fa0af',
          'Authorization:'.$erp_records['message']['data']['access_token'],// token 4e7ab0aec03a4f2:6018c5bb3901e34',
       	//'Authorization'=>$erp_records['message']['data']['access_token'],
          'Content-Type: application/json',
          'Accept: application/json',
          'Cookie: sid=Guest'
        ),
      ));
    $response = curl_exec($curl);
/*    if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
}pd($error_msg);
*/
    curl_close($curl);
    return $response;
    }
  }
  if (!function_exists('curl_get_erp_request')) {
    function curl_get_erp_request($uri, $data = array()) {
//pd($this->curl_get_erp_token());
      $records = json_decode(curl_get_erp_token($url="", $_GET=array()));
      $erp_records = json_decode(json_encode($records), true);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $uri,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
         // 'Authorization: token 4e7ab0aec03a4f2:9616a7717360494',
//          'Authorization: token 4e7ab0aec03a4f2:7066e1925da5f9d',
         // 'Authorization: token 4e7ab0aec03a4f2:a2e2945d24fa0af',
        //  'Authorization: token 4e7ab0aec03a4f2:7c92597cb5b8fd4',
          'Authorization:'.$erp_records['message']['data']['access_token'],
          'Cookie: sid=Guest'
        ),
      ));
      $response = curl_exec($curl);

      curl_close($curl);
      return $response;

    }
  }
