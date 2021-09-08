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
  ?>