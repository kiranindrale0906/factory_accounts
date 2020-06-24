<?php
  defined('BASEPATH') OR exit('No direct script access allowed.');

  function get_page_no_from_url(){
    if(strpos($_SERVER['REQUEST_URI'], "?") !== FALSE){
      $whatIWant = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "?") + 1);
      $whatiget = explode('&', $whatIWant);
      foreach ($whatiget as $key12 => $value12) {
        $arr = explode("=", str_replace("%5B%5D","",$value12),2);
        $arr = explode("=", str_replace("[]","",$value12),2);
        if($arr[0] == "page_no"){
          return (int)$arr[1] -1;
        }
      }
    }
    return 0;
  }

  function check_filters(){
    if(empty($_GET) || count($_GET) <= 0)
      return false;
    if(!empty(getTableSettings()['inbuilt_url_parameters']))
      $keys = array_diff(array_keys($_GET), getTableSettings()['inbuilt_url_parameters']);
    else
      $keys = array_keys($_GET);
    if(count(array_diff($keys,array('page_no','extension',"1","","order_column","order_by"))) <= 0)
      return false;
    return true;
  }

  function remove_operators($data) {//filter query will execute query according to filter
    $data = str_replace(">=","",$data);
    $data = str_replace('<=',"", $data);
    $data = str_replace('=',"", $data);
    $data = str_replace('<',"", $data);
    $data = str_replace('>',"", $data);
    return $data;
  }

  function get_params(){
    if(!empty($_GET) && count($_GET) > 0)
      return array_keys($_GET);
    return array();
  }

  function filter_select_state($value,$options){
    if(is_array($options) && is_array($value) && count(array_diff($value, $options)) <= 0)
      return 'selected="selected"';
    if(!is_array($options) && is_array($value) && in_array($options, $value))
      return 'selected="selected"';   
    if(is_array($options) && in_array($value, $options))
      return 'selected="selected"'; 
    if($options == $value) 
      return 'selected="selected"'; 
    return '';
    // $param[$heading[$param['key']][1]]
  }

  function remove_spaces_from_value($value){
    $value = trim(preg_replace('/\s+/', ' ', $value));
    $value = str_replace('%20', '', $value);
    $value = str_replace(' ', '', $value);
    return $value;
  }

  function remove_spaces_from_mysql_column($colmn){
    return 'REPLACE(REPLACE('.$colmn.'," ",""),"\t","")';
  }

  function get_from_alias($value,$default_value){
    if (!empty($value) && strrpos($value," as ") === FALSE)
      return explode(" ", $value)[0];
    else if (!empty($value) && strrpos($value," as ") !== FALSE)
      return substr($value,0,strrpos($value," as "));
    else 
      return $default_value;
  }

  function add_inbuilt_url_parameters_form(){
    $query_string = $_SERVER['QUERY_STRING'];
    parse_str($query_string,$temp);
    parse_str(urldecode($temp["query_string"]),$array);
    if(empty($array) || count($array) <= 0)
      return "";
    if(!empty(getTableSettings()['inbuilt_url_parameters'])){
      $url = "";
      foreach(getTableSettings()['inbuilt_url_parameters'] as $val){
        if(!empty($array[$val])) $url .=$val."=".$array[$val]."&";
      }
      return $url;
    }
    else
      return "";
  }

  function add_inbuilt_url_parameters(){
    if(empty($_GET) || count($_GET) <= 0)
      return "";
    if(!empty(getTableSettings()['inbuilt_url_parameters'])){
      $url = "";
      foreach(getTableSettings()['inbuilt_url_parameters'] as $val){
        if(!empty($_GET[$val])) $url .=$val."=".$_GET[$val]."&";
      }
      return $url;
    }
    else
      return "";
  }

  function get_url(){
     if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
      $link = "https"; 
      else
        $link = "http"; 
      // Here append the common URL characters. 
      $link .= "://"; 
      // Append the host(domain name, ip) to the URL. 
      $link .= $_SERVER['HTTP_HOST']; 
      // Append the requested resource location to the URL 
      $link .= $_SERVER['REQUEST_URI'];     
      // Print the link 
      return $link; 
  }

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

  function get_connector($url){
    $connector = '?';
    $is_question = substr_count($url, "?");
    if($is_question>=1)
      $connector = '&';

    return $connector;
  }

