<?php

class Search_model extends BaseModel
{
  public function __construct() {
    parent::__construct();
  }

 public function getDropdownData($custom_query,$column){
    $query = $this->db->query($custom_query);
    if($query->num_rows()):
      $dropDownData = $query->result_array();
      foreach ($dropDownData as $index => $dropdown)
        $dropDownArray[] = $dropdown[$column];
      return $dropDownArray;
    endif;
    return false;
  }

  public function getAutoCompeleteData($table,$column,$where){
    $this->db->select('DISTINCT('.$column.')');
    $this->db->where($column.'!=','');
    $this->db->from($table);
    $this->db->like($where);
    $this->db->limit(15);
    $query = $this->db->get();
    if($query)
      return $query->result_array();
    else
      return false;
  }

}
