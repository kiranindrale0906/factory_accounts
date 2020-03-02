<?php
/*
**Version 1.1.
**Developed by Bhaskar Dutt.
**Developed for Ascra technology.
**This class is used to create migration and create a file according to needed.
**Remember to true migration before execute it.
**Use autoexecute migration to avoide call of class manually.
*/
class Update_image_sizes extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index($field_name,$controller_name,$size_name,$table)
  {
    $resize_array = array();
    $get_file_names = $this->db->select($field_name)->from($table)->get()->result_array();
    $get_folder_content = image_sizes($field_name,$controller_name);
    $get_folder = get_file_content($field_name,$controller_name);
    if(isset($get_folder_content[$size_name]))
      $resize_array[$size_name] = $get_folder_content[$size_name];
    
      foreach ($get_file_names as $key => $file_name) {
        if(!empty($file_name[$field_name])){
          if(UPLOAD_ON == 'aws'){
            $get_images_url[] = $this->upload_file->get_file_url($get_folder['folder'].'/original/'.$file_name[$field_name],'',true);
          }else{
            $get_images_url[] = FCPATH.$get_folder['folder'].'/original/'.$file_name[$field_name];
          }
        }
      }
    $this->upload_file->updateMediaUsingLink($get_images_url,$field_name,$controller_name,$resize_array,$get_folder['folder'],true);
    echo 'New Size created for '.$field_name.' '.$size_name.' size';
  }		
}//end of class.
?>