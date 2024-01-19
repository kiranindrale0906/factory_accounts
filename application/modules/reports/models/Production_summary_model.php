<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class production_summary_model extends BaseModel {
  protected $table_name = "";
  function __construct($data=array()) {
    parent::__construct($data);
  }
  function multi_array_search_with_condition($array, $condition)
  { 
    $result = array();
    foreach ($array['message'] as $key => $value) { 
        // Iterate over each search condition 
        foreach ($condition as $condition_key => $condition_value) { 
            // If the array element does not meet 
            // the search condition then continue 
            // to the next element 
            if (!isset($value[$condition_key]) || $value[$condition_key] != $condition_value) 
            { // Skip two loops 
                continue 2; 
            } 
        } // Append array element's key to the 
        //result array 
        $result[] = $value; 
    } 
  
    // Return result 
    return $result; 
  
  }

}

//class
