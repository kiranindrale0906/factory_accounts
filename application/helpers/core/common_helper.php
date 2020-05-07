<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

function pd($data, $die=1) {
  echo '<pre>';
  print_r($data);
  echo '</pre>';
  if ($die==1)
    die;
}

if ( ! function_exists('pr')) {
  function pr($arr)
  {
    echo '<pre>'; 
    print_r($arr);
    echo '</pre>';
    die;
  }
}

/**
 * [To print last query]
*/
if ( ! function_exists('lq')) {
  function lq()
  {
    $CI = & get_instance();
    echo $CI->db->last_query();
    die;
  }
}

/* var_dump data and continue the execution */
if ( ! function_exists('vd')) {
  function vd($array) {
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
  }
}

/* var_dump the data and exit */
if ( ! function_exists('xvd')) {  
  function xvd($array) {
    vd($array);exit;
  }
}
/* var_dump the data into browser console in json format and continue */
if ( ! function_exists('cvd')) { 
  function cvd($array) {
    ob_start();
    var_dump($array);
    $result = ob_get_clean();
    echo "<script>console.log(".json_encode($result, JSON_PRETTY_PRINT).");</script>";
  }
}

if (!function_exists('get_errorMsg')) {
  function get_errorMsg($msg = "") {
    if ($msg == "")
        $msg = "Oops! Error.  Please try again later!!!";
    $error_msg = array(
        "status" => "error",
        "data" => $msg
    );
    return $error_msg;
  }

}

if (!function_exists('get_validation_errors')) {
  function get_validation_errors($errors,$type=''){
    $validation_errors=array(
        'status'=>'error',
        'errors'=>$errors,
        'error_type'=>$type
    );
    return $validation_errors;
  }
}
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

if ( ! function_exists('makedirs')) {
  function makedirs($folder='', $mode=DIR_WRITE_MODE){    
    if(!empty($folder)) {
      if(!is_dir(FCPATH . $folder)){
        mkdir(FCPATH . $folder, $mode);
      }
    } 
  }
}

if (!function_exists('custom_url_manager')){
  function custom_url_manager($type='',$page_number=''){
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

      if(isset($url) && !empty($url)){
        $ordered = (isset($_GET['ordered_columns']) ? $_GET['ordered_columns'] : '');
        $selected = (isset($_GET['selected_column']) ? $_GET['selected_column'] : '');
        $page_no = (isset($_GET['page_no']) ? $_GET['page_no'] : '');
        $url = str_replace("?select_col=1&table_filter=1","",$url);$url = str_replace("&selected_column=".@$_GET['selected_column']."&ordered_columns=".@$_GET['ordered_columns'],"",$url);

        $url = str_replace("?selected_column=".@$_GET['selected_column']."&ordered_columns=".@$_GET['ordered_columns'],"",$url);
        $url = str_replace("&select_col=","",$url);
        $url = str_replace("&is_ajax=0","",$url);
        $url = str_replace("&is_ajax=1","",$url);
        $url = str_replace("&selected_column=".@$_GET['selected_column']."&ordered_columns=".@$_GET['ordered_columns'],"",$url);
        $url = str_replace("&page_no=".@$_GET['page_no'],"",$url);
        $url = str_replace("?page_no=".@$_GET['page_no'],"",$url);
        $url = str_replace("?page_no=''","",$url);
        
        // SELECT & AGRRANGE COLUMNS
        if(($selected == 1 && $ordered == 1) || $type == 'ordered_columns')
          $url .= get_connector($url)."selected_column=1&ordered_columns=1";
        elseif(($selected == 1 && $ordered != 1) || $type == 'selected_column')
          $url .= get_connector($url)."selected_column=1&ordered_columns=0";
        // PAGINATION
        if($page_no != '' || $type == 'pagination')
          $url .= get_connector($url)."page_no=".$page_number;
        return $url;
      }
      return '';
  }
}

function get_connector($url){
  $connector = '?';
  $is_question = substr_count($url, "?");
  if($is_question>=1)
    $connector = '&';

  return $connector;
}

if ( ! function_exists('get_no_of_period_from_datetime')) {
  function get_no_of_period_from_datetime($datetimefrom,$datetimeto,$period_type) {
    $date_diff=0;
    $datetime_from=date_create($datetimefrom);    
    $datetime_to=(!empty($datetimeto))?date_create($datetimeto):date_create(date('Y-m-d H:i:s'));
    $difference = date_diff($datetime_from, $datetime_to);

    switch ($period_type) {
      case 'y':
        $date_diff=$difference->y;  
      break;
      case 'm':
        $date_diff=$difference->m;  
      break;
      case 'd':
        $date_diff=$difference->d;  
      break;
      case 'h':
        $date_diff=$difference->h;  
      break;
      case 'i':
        $date_diff=$difference->i;  
      break;  
      default:
        $date_diff=$difference->s;  
      break;
    }

    return $date_diff;
  }
}

if ( ! function_exists('unset_import_data')){
  function unset_import_data($data,$unset_data){
     $record=!empty($data)?$data:array();
     if(!empty($data) && !empty($unset_data)){
        foreach ($unset_data as $key => $value) {
           if(isset($record[$value])){
            //echo $value."<br>";
            unset($record[$value]); 
           }
            
        }
     }
     return $record;
  }
}

if ( ! function_exists('remove_query_string_parameter')) {
  function remove_query_string_parameter($remove_parameter,$query_parameter,$query_string) {
    $remove_parameter=str_replace(" ","_",strtolower($remove_parameter));
    $url=$query_string;
    if(is_array($query_parameter)){
      foreach ($query_parameter as $key => $value) {
        if(strpos($value,$remove_parameter)==true) 
          $url=str_replace($value,"",$query_string);   
      }
    }
    
    return $url;
  }
}

if ( ! function_exists('protected_file_types')) {
  function protected_file_types() {
    $image_type=array('jpg','jpeg','png');
    return $image_type;
  }
}

if ( ! function_exists('process_validation_data_sequence')) {
  function process_validation_data_sequence($validation_error){    
    $collect_error=array();
    $field_prefix = 'import_data';
    $error_items=array('fl_item_gemstones','fl_item_diamonds','fl_item_metals','fl_item_collections','fl_item_recommendations');
    $already_field_name=array();
    foreach ($validation_error as  $field_name => $error) {
      if (startsWith($field_name, $field_prefix)) {
        $index_start_pos = stripos($field_name, '[') + 1;
        $index_end_pos = stripos($field_name, ']');
        $index = substr($field_name, $index_start_pos, $index_end_pos-$index_start_pos);
        
        if(!in_array($field_name,$already_field_name))  
          $collect_error[$field_name] ='Row No '.($index).': '.$error."<br>";
          
        foreach ($validation_error as $field_name_sub => $error_sub) {
          foreach ($error_items as $error_value) {
            if (startsWith($field_name_sub, $field_prefix."[".$index."][".$error_value."]") && !in_array($field_name_sub,$already_field_name)) {
              $already_field_name[]=$field_name_sub;
              $search=$field_prefix."[".$index."][".$error_value."]";
              $fieldname=str_replace($search,"",$field_name_sub);

              $index_start_pos_new = stripos($fieldname, '[') + 1;
              $index_end_pos_new = stripos($fieldname, ']');
              $index_sub = substr($fieldname, $index_start_pos_new, $index_end_pos_new-$index_start_pos_new);
            
              $row_index=$index+$index_sub;
              $collect_error[$field_name_sub] ='Row No '.$row_index.': '.$error_sub."<br>";
            }  
          }  
        }
      }
    }

    return $collect_error;
  }
}

if ( ! function_exists('get_setting_status')){
  function get_setting_status(){
     $ci =& get_instance();
     $ci->load->database();
     $query = $ci->db->get_where('fl_settings');
     if($query->num_rows() > 0){
         $result = $query->row_array();
         return $result;
     }else{
         return false;
     }
  }
}

if ( ! function_exists('get_setting_about_us')){
  function get_setting_about_us(){
     $ci =& get_instance();
     $ci->load->database();
     $query = $ci->db->get_where('fl_about_us', array('is_delete' => '0'));
     if($query->num_rows() > 0){
         $result = $query->row_array();
         return $result;
     }else{
         return false;
     }
  }
}

function unset_params($array){
  unset( $array[array_search( 'id', $array )] );
  unset( $array[array_search( 'encrypted', $array )] );
  unset( $array[array_search( 'updated_at', $array )] );
  unset( $array[array_search( 'created_at', $array )] );
  unset( $array[array_search( 'intendedwh', $array )] );
  unset( $array[array_search( 'karat', $array )] );
  unset( $array[array_search( 'total_stn_qty', $array )] );
  unset( $array[array_search( 'stone_rate/cts', $array )] );
  unset( $array[array_search( 'labour_chg_/_gram', $array )] );
  unset( $array[array_search( 'wastage_%', $array )] );
  unset( $array[array_search( 'sr_no', $array )] );
  return $array;
}

function filter_database_columns($array) {
  $array = array_filter($array, 'strlen');  //removes null values but leaves "0"
  $array = array_filter($array);
  $strtolower = array_map('strtolower',$array);
  $strtolower = array_map('trim',$strtolower);
  return array_map(function($strtolower){
      $foreignkeys = array();
      if (strpos($strtolower, '_id') !== false) {
        if(!in_array($strtolower, $foreignkeys)){
          array_push($foreignkeys, $strtolower);
        }
      }
    //$strtolower = str_replace(' ', '_', $strtolower);
    return str_replace('_id', '', $strtolower);
    return $strtolower;
  },$strtolower);
}

if ( ! function_exists('get_dropdown_value')) {
  function get_dropdown_value($selected_value,$options) {
    $option_value="";
    if(!empty($selected_value) && !empty($options)) {
      foreach ($options as $opt_key => $opt_value) {
        if($selected_value==$opt_value['id']){
          $option_value=$opt_value['name'];
        }
      }
    }
    return $option_value;
  }
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
      // pd(curl_errno($curl));
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

if ( ! function_exists('four_decimal')) {
  function four_decimal($value){
     return number_format((float)$value, 4, '.', '');
  }
}

if (!function_exists('decimal_number_format')) {
  function decimal_number_format($number, $digits=4, $default = '', $abs = true) {
    $result = $default;

    if ($number == '' || $number == '0.00') {
        return $result;
    }

    if($abs === true):
        $number = abs($number);
    endif;
    return number_format($number, $digits);
  }
}