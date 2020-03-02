<?php  defined('BASEPATH') OR exit('No direct script access allowed.');

/*replace sapces to underscore i.e headings to database coloumns*/
function export_design_excel_column($keys,$headings){
   if ($keys==true) {
      $headings = array_map(function($heading_arr)
            {
                return strtolower(str_replace(array(' ','/'), '_', trim($heading_arr)));
            }, $headings);
   }
   return $headings;
}

/*fetching array from respective site*/
function get_array_as_per_site($excel_type="",$array_type="sample_excel_columns"){
    $headings =array();
    // $helper_name = get_helper_name('_excel_helper','excel_samples');
        if (function_exists('sample_excel_columns')) {
             $custom_array = sample_excel_columns($excel_type);
             if (!empty($custom_array[$array_type])) {
                $headings = $custom_array[$array_type];
             }
        }
    return $headings;
}

/*Sample and Export Designs*/
function get_export_column_by_site($keys=false,$excel_type=""){
// print_r($excel_type);exit;

    $headings=get_array_as_per_site($excel_type,"sample_excel_columns");
       
    if (empty($headings)) {
        $headings = default_design_array($excel_type);
    }

    return export_design_excel_column($keys,$headings);
     
}

/*product Excel Mapping Array*/
function get_mapping_excel_heading($keys=false,$excel_type="get_in_touch"){

    $headings= get_array_as_per_site($excel_type,"mapping_array");
    return get_array_keys($headings,$keys);
}

/*sending mapping columns for importing Excel*/
function get_array_keys($headings,$keys=false){
        $response =array();
        $new_coloumns=array();
        $custom_headings = array_values(array_filter($headings));
        foreach ($headings as $key => $value) {
            if (!in_array($key, $custom_headings)) {
                $response[$key]=$key;
                if (!empty($value)) {
                    $response[$key]=$value;
                    $new_coloumns[$key]=$value;
                }
            }
        }
    if ($keys==true) {
        $response = (array_values($response));
    }
    $response = array_map('strtolower', $response);
    $response = array_change_key_case($response,CASE_LOWER);
   return $response;
}

/*exporting sample sequence wise*/
function get_table_columns_excel_export($headings_excel,$custom_heading=array()){
   if (!empty($custom_heading)) {
    $custom_heading =array_flip($custom_heading);
       foreach ($headings_excel as $key => $value) {
            if (in_array($value, array_keys($custom_heading))) {
               $headings_excel[$key]=$custom_heading[$value];
            }
       }
   }
   return $headings_excel;
}

/*making Exportable data*/
function fill_missing_excel_array($excel_array=array(),$excel_type="get_in_touch"){
        $excel_headings = get_export_column_by_site(true,$excel_type);
        $custom_heading =get_mapping_excel_heading($keys=false,$excel_type);
        $headings = get_table_columns_excel_export($excel_headings,$custom_heading);
        $response_array =array();
        if (!empty($excel_array)) {
            foreach ($excel_array as $key => $value) {
                $row_array=array();
                foreach ($headings as $excel_column) {
                    $row_array[$excel_column]=@$value[$excel_column];
                }
                $response_array[] =$row_array;
            }
        }
       return $response_array;
}

/*default columns for sample and Export*/
function default_design_array($excel_type=""){
    // $default_array['get_in_touch']= array('Name','Email Id','Contact No','Message','Date','Time');
    $default_array['contact_us']= array('Name','Email ID','Contact Number','Description','Date','Time');
    if (array_key_exists($excel_type, $default_array)) {
       return $default_array[$excel_type];
    }else{
        return array();
    }
}