<?php defined('BASEPATH') OR exit('No direct script access allowed.');

if(!function_exists('validate_slim_image')){
    function validate_slim_image($file_name="slim",$postdata){
        $Ci =& get_instance();
        $Ci->load->library('slim');
         $image = $Ci->slim->getImages($file_name);
         if (!empty($postdata['id']) && empty($_POST[$file_name])) {
             return array("status" => "success" ,'msg' => '');
         }else if ($image == false) {
            return array("status" => "failure" ,'msg' => 'Please Upload gif,jpg,png and jpeg File');
        }else{
            return array("status" => "success" ,'msg' => '');
        }
    }
}

if(!function_exists('validate_images')){
 function validate_images($file,$allowed_extensions,$update=false){
    $error['status']=true;
    $error['msg']='';
    if ($update ==false) {
         if (empty($file['name'])) {
        $error['msg']="Please select Image to upload";
        $error['status']=false;
        }
    }
    if (!empty($file['name'])) {
        $img_path = pathinfo($file["name"], PATHINFO_EXTENSION);
        if(!in_array(strtolower($img_path), $allowed_extensions)){
            $error['msg']="Invalid file format, Please Upload ".implode('/',$allowed_extensions)." files.";
            $error['status']=false;
        }
    }
    return $error;
  }
}

if(!function_exists('validate_document')){
 function validate_document($file,$allowed_extensions,$update=false){
    $error['status']=true;
    $error['msg']='';   
    if ($update ==false) {
         if (empty($file['name'])) {
        $error['msg']="Please select Document to upload (Document size might be exceed)";
        $error['status']=false;
        }
    }
    if (!empty($file['name'])) {
        $img_path = pathinfo($file["name"], PATHINFO_EXTENSION);
        if(!in_array(strtolower($img_path), $allowed_extensions)){
            $error['msg']="Invalid file format, Please Upload ".implode('/',$allowed_extensions)." files.";
            $error['status']=false;
        }
    }
    return $error;
  }
}
if(!function_exists('uploadImage')){
    function uploadImage($folder_name,$files)
    {   

        // print_r($folder_name);exit;
      CreateFolderbyname($folder_name);
        $ci = &get_instance();
        $filename=array();
        if (!empty($files['name'])) {
            $uplaodFileName = date("YmdHis")."_".RenameUploadFile($files['name']);
            $_FILES['userfile']['name']= $uplaodFileName;
            $_FILES['userfile']['type']= $files['type'];
            $_FILES['userfile']['tmp_name']= $files['tmp_name'];
            $_FILES['userfile']['error']= $files['error'];
            $_FILES['userfile']['size']= $files['size'];
            $image = new Imagick($files['tmp_name']);
            $image->setImageCompressionQuality(70);
            $image->writeImage('./uploads/'.$folder_name.'/'.$uplaodFileName);
            return $uplaodFileName;
            // $ci->upload->initialize(set_upload_options($folder_name));
            // $upload=$ci->upload->do_upload();
            // if($upload)
            // {
            //     return $uplaodFileName;
            // }else{
            //     echo "<pre>"; print_r($ci->upload->display_errors()); echo "</pre>";
            // }
        }  
    }
}
// if(!function_exists('uploadImage')){
//     function uploadImage($folder_name,$files,$width=1200,$height=1200)
//     {   
//         // print_r($folder_name);exit;
//        // print_r($width);print_r($height);exit;
//         $data=array();
//         $ci = &get_instance();
//         $filename=array();
//             CreateFolderbyname($folder_name);
//             $file_path='';
//             if (!empty($files['name'])) {
//                 $uplaodFileName = RenameUploadFile($files['name']);
//                  $files['name']= date("YmdHis")."_".rand(10,100).$uplaodFileName;

//                 //$_FILES['userfile']['name']= date("YmdHis")."_".rand(10,100).$uplaodFileName;
//                 // $_FILES['userfile']['type']= $files['type'];
//                 // $_FILES['userfile']['tmp_name']= $files['tmp_name'];
//                 // $_FILES['userfile']['error']= $files['error'];
//                 // $_FILES['userfile']['size']= $files['size'];
//                // $ci->upload->initialize(set_upload_options($folder_name));
//                 //$upload=$ci->upload->do_upload();
//               //  if($upload)
//                // {
//                   //   $data=$ci->upload->data();
//                   // return $data['file_name'];


//                    // $filename=FRONTEND_PATH.'uploads/'.$folder_name."/".$_FILES['userfile']['name'];
//                     $filename=$uplaodFileName;
//                     // $this->db->update("fl_items",array("image1"=>$filename),array("id"=>$item_id));
       
                       
//                        CreateFolderbyname($folder_name.'/');
//                        CreateFolderbyname($folder_name.'/larg');
//                        $file_path = 'uploads/'.$folder_name."/".$files['name'];
                     
//                      //print_r($_FILES['userfile']);exit;
//                         $imagick = new Imagick($files['tmp_name']);
//                         $imagick->setImageCompression(Imagick::COMPRESSION_LZW);
//                         $imagick->setImageCompressionQuality(80);

//                         $filterType = 1;
//                         $blur = 1;
//                         $bestFit = true;
//                         $imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, $blur, $bestFit);
//                         // $real_path = dirname(dirname(dirname(__FILE__)))."/uploads/".$folder_name.'/large/'.$files['name'];
//                         // $imagick->writeImage($real_path);
//                         // $cropWidth = $imagick->getImageWidth();
//                         // $cropHeight = $imagick->getImageHeight();
//                         // $cropZoom = false;
//                         // if ($cropZoom) {
//                         //     $newWidth = $cropWidth / 2;
//                         //     $newHeight = $cropHeight / 2;
                     
//                         //     $imagick->cropimage(
//                         //         $newWidth,
//                         //         $newHeight,
//                         //         ($cropWidth - $newWidth) / 2,
//                         //         ($cropHeight - $newHeight) / 2
//                         //     );
                     
//                         //     $imagick->scaleimage(
//                         //         $imagick->getImageWidth() * 4,
//                         //         $imagick->getImageHeight() * 4
//                         //     );
//                         // }
//                         $imagick->writeImage($file_path);

//                 // }else{
//                 //     echo "<pre>"; print_r($ci->upload->display_errors()); echo "</pre>";
//                 // }
//             }
//           return $file_path; 
//     }
// }

?>