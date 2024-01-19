<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class production_summary_model extends BaseModel {
  protected $table_name = "";
  function __construct($data=array()) {
    parent::__construct($data);
  }
  function multi_array_search_with_condition($array, $condition)
  {
      $foundItems = array();

      foreach($array as $item)
      {
          $find = TRUE;
          foreach($condition as $key => $value)
          {
              if(isset($item[$key]) && $item[$key] == $value)
              {
                  $find = TRUE;
              } else {
                  $find = FALSE;
              }
          }
          if($find)
          {
              array_push($foundItems, $item);
          }
      }
      return $foundItems;
  }

}

//class