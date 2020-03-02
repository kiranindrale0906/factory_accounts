<?php

/*
 * ************************
 * ------------------------
 * SOME HANDFUL FUNCTIONS
 * ------------------------
 * ************************
 */

//Commented by Atul 13-Dec-2019
if (!function_exists('makeDirectory')) {

    function makeDirectory($folderName, $domainName = "") {
        $targetPath = dirname(dirname(dirname(__FILE__))) . "/uploads/" . $folderName . "/";
        if (!is_dir($targetPath)) {
            $old_umask = umask(0);
            mkdir($targetPath, 0777, true);
            umask($old_umask);
        }
    }

}


if (!function_exists('search_string')) {

    function search_string($delimiter, $needle, $haystack) {
        if ('' == $needle)
            return true;
        $array = explode($delimiter, $haystack);
        return (in_array($needle, $array)) ? true : false;
    }

}
function RenameUploadFile($data) {
    $search = array("'","  "," ","(",")","&","-","\"","\\","?",":","/");
    $replace = array("","_","_","","","","","","","","","","");
    $new_data=str_replace($search, $replace, $data);
    return strtolower($new_data);
}

function CreateFolderbyname($folderName)
{
    $targetPath=dirname(dirname(dirname(__FILE__)))."/uploads/".$folderName."/";
    if(!is_dir($targetPath))
    {
        mkdir($targetPath, 0777, true);     
    }
}

function set_upload_options($path)
{   
    $config = array();
    $config['upload_path'] = './uploads/'.$path.'/';
    $config['allowed_types'] = '*';
    $config['max_size']      = '0';
    $config['overwrite']     = TRUE;
    return $config;
}

