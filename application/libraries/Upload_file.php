<?php
//composer require aws/aws-sdk-php
/*version 1.4*/
require FCPATH.'application/vendor/autoload.php';
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\ObjectUploader;
error_reporting(E_ALL);

Class Upload_file {
  public function __construct() {
    $this->ci = &get_instance();
    $this->s3 = S3Client::factory(array('credentials' => array(
                                  'key' => AWS_BUCKET_ACCESS_KEY,
                                  'secret' => AWS_BUCKET_SECRET_KEY),
                                  'version' => 'latest',
                                  'region'  => REGION,
                                  'ACL' => 'public-read'));
  }
 
  // private function makedirs($folder='', $mode=DIR_WRITE_MODE){      
  //   if(!empty($folder)) {
  //     if(!@is_dir(FCPATH . $folder)){
  //       @mkdir(FCPATH . $folder, $mode,true);
  //     }
  //   }
  // }

  public function download($data='',$id='',$image=false){
      $field_name = $_GET['field_name'];
      $controller = $this->ci->router->fetch_class();;
      $get_file_content = get_file_content($controller.'/'.$field_name);
      $file_url = '';
      $get_extension = pathinfo($data[$field_name])['extension'];

      if(in_array($get_extension,array('pdf','doc','docx')))
        $file_url = $get_file_content['folder'].'/'.$data[$field_name];
      else
        $file_url = $get_file_content['folder'].'/original/'.$data[$field_name];
    
      if(!empty($file_url)){
        $file_info = pathinfo($file_url);
        if(isset($file_info['extension'])){
          $file_download_url = $this->get_file_url($file_url,$field_name);
          $getmemType = extensionmemetype($file_info['extension']);
          if(!empty($file_download_url)){
            $file_headers = @get_headers($file_download_url);
            if($file_headers[0] != 'HTTP/1.1 404 Not Found'){
              if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                echo json_encode(array('success'=>1)); exit;
              }else{
                ob_clean();
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header("Content-type:".$getmemType);
                header("Content-Disposition:attachment;filename=".'document_'.$file_info['basename']."");
                $read_file = readfile($file_download_url); exit;
              }
              
            }
          }
        }
        echo json_encode(array('error'=>'614 Not valid file.'));
      }else{
        return false;
      }
  }

  public function get_file_url($file_name,$field_name='',$url_return=false){
    $file_url = pathinfo($file_name);
    if(!empty($file_name)){
      $s3Client = $this->s3;
      $cmd = $s3Client->getCommand('GetObject', [
          'Bucket' => S3_BUCKET,
          'Key' => $file_name,
      ]);

      $request = $s3Client->createPresignedRequest($cmd, '+1 minutes');
      $presignedUrl = (string)$request->getUri();
      if($url_return == true) return $presignedUrl;
      if(isset($file_url['extension']) && in_array($file_url['extension'],protected_file_types()) == false){
        if(isset($_GET['download'])){
          return $presignedUrl;
        }
        else{
          $get_content = @file_get_contents($presignedUrl);

          if($get_content != FALSE) {
            return  $get_content;
          }
          return '';
        }
      }
      else{
        $get_content = @file_get_contents($presignedUrl);
        if($get_content != FALSE) {

          return  $presignedUrl;
        }
        echo json_encode(array('error'=>'401 File not found on server.'));
      }
    }
  }

  private function rotate_image($exif_img_path, $rotate_config=array()){
    $exif = @exif_read_data($exif_img_path);
    $this->ci->load->library('image_lib'); //Load image manipulation library
    if($exif && isset($exif['Orientation'])){
      $ort = $exif['Orientation'];
      if ($ort == 6 || $ort == 5)
        $rotate_config['rotation_angle'] = '270';
      if ($ort == 3 || $ort == 4)
        $rotate_config['rotation_angle'] = '180';
      if ($ort == 8 || $ort == 7)
        $rotate_config['rotation_angle'] = '90';
      $this->ci->image_lib->initialize($rotate_config);
      if ( ! $this->ci->image_lib->rotate()){
        $error = array('error' => $this->ci->image_lib->display_errors());
        return $error;
      }
      $this->ci->image_lib->clear();
    }
    return TRUE;
  }

  private function updateMedia($image,$folder,$fileType,$controller,$field_name,$index='',$is_old_resize=false,$image_data='',$hieght=600,$width=600,$path=FALSE) {
    $class  = $this->ci->router->fetch_class();
    if($is_old_resize == false){
      makedirs($folder.'/original');
      if(isset($_FILES[$image]['name']) AND strpos($_FILES[$image]['name'], ".") == FALSE){
        $extension = substr($_FILES[$image]['type'], strpos($_FILES[$image]['type'], "/") +1);
        $_FILES[$image]['name'] = $_FILES[$image]['name'].'.'.$extension;
      }        
    }
    if($fileType != 'doc'){
      $allowed_types = "jpg|png|jpeg|gif|mp3|mp4";
      $img_sizes_arr = image_sizes($field_name,$controller);  //predefined sizes in model
      $min_width = isset($img_sizes_arr['thumbnail'])?$img_sizes_arr['thumbnail']['width']:$width;
      $min_height = isset($img_sizes_arr['thumbnail'])?$img_sizes_arr['thumbnail']['height']:$hieght;
    }else{
      $allowed_types = "pdf|txt|doc|docx";
      $min_width = '50';
      $min_height = '50';
    }
    
    $img_name = random_string('alnum', 16);  //generate random string for image name
    //We will set min height and width according to thumbnail size
    $config = array(
      'upload_path'       => $folder.'/original',
      'allowed_types'     => '*',
      'max_size'          => "10240", // File size limitation, initially w'll set to 10mb (Can be changed)
      'max_height'        => "9000", // max height in px
      'max_width'         => "9000", // max width in px
      'min_width'         => $min_width, // min width in px
      'min_height'        => $min_height, // min height in px
      'file_name'         => $img_name,
      'overwrite'         => FALSE,
      'remove_spaces'     => TRUE,
      'quality'           => '100%',
    );
    if($is_old_resize == false){
      $exif_img_path = $_FILES[$image]['tmp_name'];
      $this->rotate_image($exif_img_path);//roate image if not in right condition.    
      $this->ci->load->library('upload'); //upload library
      $initialize = $this->ci->upload->initialize($config);
      if(!$this->ci->upload->do_upload($image)){
        $error = array('error' => $this->ci->upload->display_errors());
        return $error; //error in upload
      }
      $image_data = $this->ci->upload->data(); //get uploaded image data
      $this->ci->load->library('image_lib'); //Load image manipulation library
      $thumb_img = '';
    }
    if($is_old_resize == true){
      return array('folder'=>$folder.$v['folder'],'file_name'=>$image_data['file_name']);
    }
    if(isset($img_sizes_arr)){
      return $this->resize_images($folder,$image_data,$img_sizes_arr);
    }else{
      return $image_data['file_name'];
    }
  }

  private function resize_images($folder, $image_data,$img_sizes_arr){
      foreach($img_sizes_arr as $k => $v){
        $sub_folder = $folder.$v['folder'];
        makedirs($sub_folder);
        $real_path = realpath(FCPATH .$folder);
        $resize['image_library']      = 'gd2';
        $resize['source_image']       = $image_data['full_path'];
        $resize['new_image']          = $real_path.$v['folder'].'/'.$image_data['file_name'];
        $resize['maintain_ratio']     = TRUE; //maintain original image ratio
        $resize['width']              = $v['width'];
        $resize['height']             = $v['height'];
        $resize['quality']            = '100%';
        $dim = (intval($image_data["image_width"]) / intval($image_data["image_height"])) - ($v['width'] / $v['height']);

        $resize['master_dim'] = ($dim > 0)? "height" : "width";
        $this->ci->load->library('image_lib');
        $this->ci->image_lib->initialize($resize);
        $is_resize = $this->ci->image_lib->resize();   //create resized copies
        $source_img = $real_path.$v['folder'].'/'.$image_data['file_name'];
        if($is_resize && file_exists($source_img)){
          $source_image_arr = getimagesize($source_img);
          $source_image_width = $source_image_arr[0];
          $source_image_height = $source_image_arr[1];          
          $source_ratio = $source_image_width / $source_image_height;
          $new_ratio = $v['width'] / $v['height'];
           
          if($source_ratio != $new_ratio){
            //image cropping config
            $crop_config['image_library'] = 'gd2';
            $crop_config['source_image'] = $source_img;
            $crop_config['new_image'] = $source_img;
            $crop_config['quality'] = "100%";
            $crop_config['maintain_ratio'] = FALSE;
            $crop_config['width'] = $v['width'];
            $crop_config['height'] = $v['height'];
            if($new_ratio > $source_ratio || (($new_ratio == 1) && ($source_ratio < 1))){
              $crop_config['y_axis'] = round(($source_image_height - $crop_config['height'])/2);
              $crop_config['x_axis'] = 0;
            }else{
              $crop_config['x_axis'] = round(($source_image_width - $crop_config['width'])/2);
              $crop_config['y_axis'] = 0;
            }
            $this->ci->image_lib->initialize($crop_config);
            $this->ci->image_lib->crop();
            $this->ci->image_lib->clear();
          }            
        }
      }
      if(empty($thumb_img))
        $thumb_img = $image_data['file_name'];
      return $thumb_img;
  }

   
  private function aws_file_upload($file_name, $folder, $file='', $isResize=FALSE, $temp_folder='', $file_name_resize='') {

    $bucket = S3_BUCKET;
    if(!empty($file_name) AND $file_name != 'DOC')
      $keyname = $file_name;
    else
      $keyname = $_FILES[$file]['name'];                      

    $s3 = $this->s3;
    // Prepare the upload parameters.
    if($isResize == FALSE){
      $key = md5(uniqid());
    }else{
      $key = $file_name;
    }
    if($isResize == FALSE) { //if resize true it will not check file type and name encryption of an image..
      $type = mime_content_type($_FILES[$file]['tmp_name']);
      $ext = explode('/', $type);
      $ext = $ext[sizeof($ext) - 1];
      $file_name = $folder."/{$key}.{$ext}";
    }else{
      $file_name = $folder."/".$file_name_resize;  
    }
    if(empty($temp_folder)){
      $source = fopen($_FILES[$file]['tmp_name'], 'rb');
    }else{
      $source = fopen($temp_folder, 'rb');
    }

    $uploader = new ObjectUploader($s3, $bucket, $file_name, $source);
    do {
      try {
        $result = $uploader->upload();
          if ($result["@metadata"]["statusCode"] == '200') {
            $path_info = pathinfo($result["ObjectURL"]);
            if(isset($path_info['extension']) && $path_info['extension']=='pdf'){
              return $path_info['basename'];
            }
            return $result["ObjectURL"];
          }
        } catch (MultipartUploadException $e) {
          rewind($source);
          $uploader = new MultipartUploader($s3, $source, ['state' => $e->getState()]);
          return $e;
        }
    } while (!isset($result));
  }//AWS FILE Upload function end here..


  public function upload_file_data($controller, $field_name, $index='', $is_new_size=false){
    $image_file_types = array ('image/jpeg', 'image/png','image/jpg' );
    if(!empty($index) || $index == '0')
      $type = $_FILES[$controller]['type'][$index][$field_name];
      //pr($type);
    elseif(is_array($_FILES[$controller]['type'][$field_name]) == true) 
      $type = $_FILES[$controller]['type'][$field_name][0];
    else $type = $_FILES[$controller]['type'][$field_name];
    if(in_array($type,$image_file_types)) $fileType = IMAGE;
    else $fileType = DOC;

    $file_content = get_file_content($field_name,$controller);
    $upload_to = UPLOAD_ON; 

    if($upload_to == LOCAL) $moved_to = LOCAL;
    else $moved_to = AWS;

    $folder = isset($file_content['folder'])?$file_content['folder']:'original';
    $upload = '';
    $upload = $this->updateMedia($field_name,$folder,$fileType,$controller,$field_name,$index);//update media function call..
    if($fileType == IMAGE){//upload file if it  is IMAGE
      if($is_new_size== true){
        $image_size_array =  get_new_size_images_resizing($folder);
        if(!empty($image_size_array))
            $this->ci->updateImageSizes($moved_to,$folder,$image_size_array,$column);
        }
        if($moved_to != AWS){
          if(empty($upload['error']))
            return $upload;//if image not uploaded on AWS
          else
            return $upload;
        }else{
          if(empty($upload['error'])){
            $img_sizes_arr = image_sizes($field_name,$controller);//take folder where we want to resize image..
            $file_name = $upload;
            $file_folder = $folder.'/original';
            $image_data = $this->aws_file_upload($file_name,$file_folder,$field_name);
            //upload image on bucket
            $file_uploded_name = pathinfo($image_data);
            $realpath = $folder;//path to the profile folder..
            $real_path = realpath(FCPATH .$realpath);//real path of image..
            unlink($real_path.'/original/'.$file_name);
            $original_folder = $real_path.'/'.$file_name;//original folder of image..
            $file_name_image = $file_uploded_name['filename'].'.'.$file_uploded_name['extension'];//image name..
            if(isset($img_sizes_arr) AND $image_data){
              foreach($img_sizes_arr as $key => $v){
                $image_folder = $folder.$v['folder'];//folder of an image change accroding to upload..
                $temp_folder = $real_path.$v['folder'].'/'.$file_name;
                $is_resize = TRUE;
                $resize_image = $this->aws_file_upload($file_name,
                                                        $image_folder,
                                                        $field_name,
                                                        $is_resize,
                                                        $temp_folder,
                                                        $file_name_image
                                                      );//upload image of resized..
                if($resize_image){
                  unlink($temp_folder);//unlink an image..
                  //rmdir($real_path.$v['folder']);//unlink an folder..
                }
              }
            //rmdir($folder);
            return $file_name_image;//return after croping
          } else {
            return $upload;//return without croping and resizing.
          }
        } else {
          return $upload;//if error comes return error from here
        }
      }//if image uploaded to AWS else end here
    }else {
      if($moved_to == AWS){
        $pdf_name =  $this->aws_file_upload($upload,$folder,$field_name);
        unlink(FCPATH.$folder.'/original/'.$upload);
        return $pdf_name;
      }
      return $upload;
    }//end of else
  }//end of function

  private function resizingWithNewDimenssion($image_name,$imageFolder,$field_name,$controller,$img_sizes_arr=array(),$full_path,$moved_to=UPLOAD_ON){
    $realpath = $imageFolder;
    $real_path = realpath(FCPATH .$realpath);
    if($full_path == false) $original_folder = $real_path.'/'.$image_name;
    else $original_folder = realpath(FCPATH.$imageFolder.'/'.$image_name);

    $source_image_arr = getimagesize($original_folder);
    $imageData['image_width'] = $source_image_arr[0];
    $imageData['image_height'] = $source_image_arr[1];
    $imageData['full_path'] = $original_folder;
    $imageData['file_name'] = $image_name;
    $is_resize = TRUE;
    $is_old_resize = true;
    if(empty($img_sizes_arr))
      $img_sizes_arr = image_sizes($field_name,$controller);  //predefined sizes in model
    $resize_image = $this->aws_file_upload($imageData['file_name'],$imageFolder.'/original','',$is_resize,$original_folder,$imageData['file_name']);
    if(pathinfo($original_folder)['extension'] != 'pdf' AND pathinfo($original_folder)['extension'] != 'doc' AND pathinfo($original_folder)['extension'] != 'docx' ){
      if(isset($img_sizes_arr)){
        $this->resize_images($realpath,$imageData,$img_sizes_arr);
        foreach($img_sizes_arr as $sizes_key => $sizes_value){
          $file_name = $imageData['file_name'];
          $folder = $realpath.$sizes_value['folder'];
          $resize_image = $this->aws_file_upload($file_name,$folder,'',$is_resize,$original_folder,$file_name);
            unlink($real_path.$sizes_value['folder'].'/'.$file_name);
            //rmdir($real_path.$sizes_value['folder']);
        }
        //unlink($real_path.'/'.$file_name);
      }
    }
  }

  public function updateMediaUsingLink($file,$field_name,$controller,$img_sizes_arr=array(),$folder,$full_path=false,$moved_to='AWS'){
    foreach ($file as $filekey => $file_value) {
      if(!empty($file_value)){
        if($full_path == false){
          $folder = dirname($file_value);
          $url = FCPATH.$file_value;
          $image_name = basename($file_value);
          $name = basename($url); // to get file name
        }
        else{
          $url = $file_value;
          $image_name = $file_value;
          $name = strtok(basename($url), '?'); // to get file name
          $image_name = $name; // to get file name
        };
        $new_path = FCPATH.$folder.'/'.$name;
        $file_data = file_get_contents($url); // to get file
        $get = file_put_contents($new_path, $file_data);
        $this->resizingWithNewDimenssion($image_name,$folder,$field_name,$controller,$img_sizes_arr,$full_path);
        unlink($new_path);
      }
    }
  }
  private function upload_file_settings($controller_name, $field_name,$index=''){
    if(is_array($_FILES[$controller_name]['name'][$field_name])){
      $count = count($_FILES[$controller_name]['name'][$field_name]);
      for ($i=0; $i < $count; $i++) { 
        $_FILES[$field_name]['name']       = $_FILES[$controller_name]['name'][$field_name][$i];
        $_FILES[$field_name]['type']       = $_FILES[$controller_name]['type'][$field_name][$i];
        $_FILES[$field_name]['tmp_name']   = $_FILES[$controller_name]['tmp_name'][$field_name][$i];
        $_FILES[$field_name]['error']      = $_FILES[$controller_name]['error'][$field_name][$i];
        $_FILES[$field_name]['size']       = $_FILES[$controller_name]['size'][$field_name][$i];
        $file_name[] = $this->upload_file_data($controller_name, $field_name);
      }
    }elseif(!empty($index) || $index == '0'){
        $_FILES[$field_name]['name']       = $_FILES[$controller_name]['name'][$index][$field_name];
        $_FILES[$field_name]['type']       = $_FILES[$controller_name]['type'][$index][$field_name];
        $_FILES[$field_name]['tmp_name']   = $_FILES[$controller_name]['tmp_name'][$index][$field_name];
        $_FILES[$field_name]['error']      = $_FILES[$controller_name]['error'][$index][$field_name];
        $_FILES[$field_name]['size']       = $_FILES[$controller_name]['size'][$index][$field_name];
        $file_name =  $this->upload_file_data($controller_name, $field_name, $index);
    }else{
        $_FILES[$field_name]['name']       = $_FILES[$controller_name]['name'][$field_name];
        $_FILES[$field_name]['type']       = $_FILES[$controller_name]['type'][$field_name];
        $_FILES[$field_name]['tmp_name']   = $_FILES[$controller_name]['tmp_name'][$field_name];
        $_FILES[$field_name]['error']      = $_FILES[$controller_name]['error'][$field_name];
        $_FILES[$field_name]['size']       = $_FILES[$controller_name]['size'][$field_name];
        $file_name =  $this->upload_file_data($controller_name, $field_name);
    }
    return $file_name;
  }

  public function unlinkImageAWS($file_path){
    $this->s3->deleteObject([
    'Bucket' => S3_BUCKET,
    'Key'    => $file_path
    ]);
  }
  public function upload_files($formdata, $fields_data){
    if(empty($fields_data)) return $formdata;
    foreach ($fields_data as $index => $field_data):
      $controller_name = $field_data['file_controller'];
      $field_name = $field_data['file_field_name'];
      $enable_file_upload = !(isset($field_data['disable_file_upload']));
      if(!isset($_FILES[$controller_name]['name'])) return $formdata;
      if (!isset($_FILES[$controller_name]['name'][$field_name])) {
        foreach($_FILES[$controller_name]['name'] as $index => $image_name):
          if (empty($_FILES[$controller_name]['name'][$index][$field_name])) continue;
            if($enable_file_upload) {
              $file_name = $this->upload_file_settings($controller_name, $field_name, $index);
              if(empty($file_name['error']))
                $formdata[$controller_name][$index][$field_name] = $file_name;
            }
        endforeach;
      } else {
        if (empty($_FILES[$controller_name]['name'][$field_name])) continue;
        if(is_array($_FILES[$controller_name]['name'][$field_name])){
          if($enable_file_upload) {
            $upload_file_multiple =  $this->upload_file_settings($controller_name, $field_name);
            if(empty($upload_file_multiple['error']))
            $formdata[$controller_name][$field_name] = $upload_file_multiple;
          }
        }else{
          if($enable_file_upload) {
            $file_response = $this->upload_file_settings($controller_name, $field_name);
            if(empty($file_response['error']))
              $formdata[$controller_name][$field_name] = $file_response;
          }
        }
      }
    endforeach;
    return $formdata;
  }
}//end of class

?>
