<?php

defined('BASEPATH') OR exit('No direct script access allowed.');
/*
if (!function_exists('userdataFromUsername')) {

    function userdataFromUsername($username) {
        $ci = &get_instance();
        $result=$ci->db->get_where("users",array("email"=>$username))->row_array();
        return $result;
    }

}*/

function pd($data, $die=1) {
  echo '<pre>';
  print_r($data);
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



if (!function_exists('query_record')) {

    function query_record($record, $params) {
        $data = array();
         $j=0;
        foreach ($record['list'] as $key => $value) {
            $i = 0;
            foreach ($value as $v) {
                $data[$key][$i] = $v;
                $i++;
            }
            $j++;
        }
        if(isset($record['total'])){
            $data[$j] =$record['total'];
        }
        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => intval($record['totalRecords']),
            "recordsFiltered" => intval($record['totalRecords']),
            "data" => $data
        );
        return json_encode($json_data);
    }
}



if (!function_exists('get_successMsg')) {

    function get_successMsg($id = "") {
        $msg = 'Added';
        if ($id != "")
            $msg = 'Updated';
        $success_msg = array(
            "status" => "success",
            "data" => $msg . " Successfully!!!"
        );
        return $success_msg;
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
    function get_validation_errors($errors,$type='')
    {
        $validation_errors=array(
            'status'=>'error',
            'errors'=>$errors,
            'error_type'=>$type
        );
        return $validation_errors;
    }
}

function resize_image($temp_path, $new_path, $size, $name = '') {
    $width = $size['width'];
    $height = $size['height'];

    // $image = new Imagick($temp_path);
    $imagick = new \Imagick($filename);
    $imagick->setImageCompression(Imagick::COMPRESSION_LZW);
    $imagick->setImageCompressionQuality(10);
    $blur = 1;
    $bestFit = true;
    $image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, $blur, $bestFit);
    $image->writeImage($new_path);
    if (!empty($name))
        return $name;
    else
        return $new_path;
}

function upload_images($folder, $file_name, $tmp_name) {
    list($width, $height) = getimagesize($tmp_name);
    $folder_name[0] = $folder . '';
    $folder_name[1] = $folder . '/large';
    $folder_name[2] = $folder . '/small';
    $folder_name[3] = $folder . '/thumb';
    $sizes[0] = array('width' => $width, 'height' => $height);
    $sizes[1] = array('width' => '640', 'height' => '640');
    $sizes[2] = array('width' => '200', 'height' => '200');
    $sizes[3] = array('width' => '60', 'height' => '60');

    $name = $file_name;
    foreach ($sizes as $k => $size) {
        $new_name = $name;
        if ($k == 0) {
            $new_name = $file_name;
        }
        makeDirectory($folder_name[$k]);
        $new_path = resize_image($tmp_name, './uploads/' . $folder_name[$k] . '/' . $new_name, $size, $new_name);
    }
    return $new_path;
}

 function get_image_html($fieldvalue)
{
    $ext = pathinfo(basename($fieldvalue), PATHINFO_EXTENSION);
    $image_html="";
    if(in_array($ext,array('png','jpg','jpeg'))){ 
        $image_html= '<img class="img-popup" src="'.IMAGE_UPLOAD_PATH.$fieldvalue.'" height="80px" width="80px" >';

    }else if(in_array($ext,array('pdf'))){ 
        $image_html= '<a href="'.IMAGE_UPLOAD_PATH.$fieldvalue.'" target="_blank"><img src="'.FRONTEND_PATH.'assets/Admin/images/pdf.png" height="80px" width="80px"></a>';
    }else if(in_array($ext,array('doc','docx'))){ 
        $image_html = '<a href="'.IMAGE_UPLOAD_PATH.$fieldvalue.'" target="_blank"><img src="'.FRONTEND_PATH.'assets/Admin/images/document.png" height="80px" width="80px"></a>';
    }else { 
       $image_html = '<a href="'.IMAGE_UPLOAD_PATH.$fieldvalue.'" target="_blank"><img src="'.FRONTEND_PATH.'assets/Admin/images/other_document.png" height="80px" width="80px"></a>';
    }
    return $image_html;

}






function generate_captcha()
{
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $shuffle_letters = str_shuffle($letters);
        $letter = substr($shuffle_letters,1,5);
        $vals = array(
        'word'          => $letter,
        'img_path'      => './uploads/',
        'img_url'       => FRONTEND_PATH.'uploads',
        'font_path' => FRONTEND_PATH. 'captcha/verdana.ttf',
        //'font_path'     => './path/to/fonts/texb.ttf',
        'img_width'     => 150,//'200px',
        'img_height'    => 60,//'60px',
        'expiration'    => 7200,
        'word_length'   => 100,
        'font_size' => 100,
        'img_id'        => 'Imageid',
        //'type' =>true,
        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

        // White background and border, black text and red grid
        'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                // 'text' => array(128, 128, 128),
                'grid' => array(200, 200, 200)
        )
    );
    $cap = create_captcha($vals);
    $cap['letter'] = $letter;
    return $cap;
}

