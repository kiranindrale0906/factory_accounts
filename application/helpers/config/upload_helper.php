<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function get_file_content($field_name,$controller){
  $ci = &get_instance();
  $file_content = array('upload_on'=>LOCAL);
    $field_name=$controller."/".$field_name;
    switch($field_name){
      case 'company/logo'://
        $folder_array = array('folder'=>'uploads/logo');
        $file_content = array_merge($file_content,$folder_array);
      break;
    }
  return $file_content;
}

function image_sizes($field_name,$controller){
  $img_sizes = array();
  $ci = &get_instance();
  $file_content = get_file_content($field_name,$controller);
  $folder =  isset($file_content['folder'])?$file_content['folder']:'';
  switch($folder){
   case 'uploads/logo':
      $img_sizes['thumbnail'] = array('width'=>50, 'height'=>50, 'folder'=>'/thumb');
      $img_sizes['small'] = array('width'=>200, 'height'=>200, 'folder'=>'/small');
    break;
  }
  return $img_sizes;
}

function load_image($file_name,$return_url=false){
  $ci = &get_instance();
  return $file_name = $ci->upload_file->get_file_url($file_name,'',$return_url);
}