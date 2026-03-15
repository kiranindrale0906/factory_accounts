<?php
defined('BASEPATH') OR exit('No direct script access allowed.');

  function makedirs($folder='', $mode=DIR_WRITE_MODE){    
    if(!empty($folder)) {
      if(!@is_dir(FCPATH . $folder)){
        @mkdir(FCPATH . $folder, $mode,true);
      }
    }
  }

  function protected_file_types() {
    $image_type=array('jpg','jpeg','png');
    return $image_type;
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

  function get_import_file_validation_errors($field_prefix = 'import_data') {
    $ci =& get_instance();
    if (empty($ci->form_validation->error_array())) return array();
    $errors = array();
    foreach ($ci->form_validation->error_array() as $field_name => $error) {
      if (startsWith($field_name, $field_prefix)) {
        $index_start_pos = stripos($field_name, '[') + 1;
        $index_end_pos = stripos($field_name, ']');
        $index = substr($field_name, $index_start_pos, $index_end_pos-$index_start_pos);
        if(is_numeric($index))
          $errors[] = 'Row No '.$index.': '.$error;  
        else
          $errors[] = $error;  
      }
    } 
    return $errors;
  }
