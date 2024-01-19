<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class production_summary_model extends BaseModel {
  protected $table_name = "";
  function __construct($data=array()) {
    parent::__construct($data);
  }
  function multi_array_search_with_condition($array, $condition)
  {
      function search($array, $search_list) { 
  
    // Create the result array 
    $result = array(); 
  
    // Iterate over each array element 
    foreach ($array as $key => $value) { 
  
        // Iterate over each search condition 
        foreach ($condition as $k => $v) { 
      
            // If the array element does not meet 
            // the search condition then continue 
            // to the next element 
            if (!isset($value[$k]) || $value[$k] != $v) 
            { 
                  
                // Skip two loops 
                continue 2; 
            } 
        } 
      
        // Append array element's key to the 
        //result array 
        $result[] = $value; 
    } 
  
    // Return result 
    pd($result); 
    return $result; 
} 
  
  }

}

//class