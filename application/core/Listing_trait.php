<?php

/*************************************************************************
*
* ASCRA TECHNOLOGIES CONFIDENTIAL
* __________________
*
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Ascra Technologies and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Ascra Technologies
* and its suppliers and may be covered by U.S. and Foreign Patents,
* patents in process, and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Ascra Technologies.
*/

/*version : 1.3*/

defined('BASEPATH') OR exit('No direct script access allowed');
trait Listing_trait  {
  private $group_by = '';
  private $tables = array();
  //private $search_url = '';
  private $headingFunction = '';
  private $theadColumn = '';
  private $limit = '';
  private $orderData = '';
  private $page_no = '';
  private $where = '';
  private $extra_select_column = '';
  private $count_column = '';
  private $getData = '';
  private $join_type = '';
  private $join_conditions = array();
  private $order_by = '';
  private $stored_procedure = '';
  private $export_limit = '';
  private $primary_table = '';

  public function __construct($data='') 
  {
    parent::__construct();

  }

  public function initalized($param,$getData) 
  {
    $this->extra_select_column = $param['extra_select_column'];
    $this->count_column = isset($param['count_column']) ? $param['count_column'] : '*';
    $this->tables = $param['table'];
    $this->headingFunction = 'list_settings';
    $this->where = $param['where'];
    $this->order_by = $param['order_by'];
    $this->stored_procedure = @$param['stored_procedure'];
    $this->export_limit = @$param['export_limit'];
    $this->primary_table = @$param['primary_table'];
    isset($param['filename']) ? $this->filename = $param['filename'] : $this->filename = $this->tables;
    isset($param['limit']) ? $this->limit = $param['limit'] : $this->limit = "10";
    isset($param['join_type']) ? $this->join_type = $param['join_type'] : $this->join_type = "";
    isset($param['group_by']) ? $this->group_by = $param['group_by'] : $this->group_by = "";
    isset($param['join_conditions']) ? $this->join_conditions = $param['join_conditions'] : $this->join_conditions = array();
    if (!empty($param['new_headers'])) {
      $this->theadColumn = $param['new_headers'];
    } else {
      $headingFunction = $this->headingFunction;
      $this->theadColumn = $headingFunction();
    }

    $this->orderData  = $getData['orderData'];
    $this->page_no    = $getData['page_no'];
    $this->getData    = $getData['getData'];
  }

 public function get_count_and_sum($action='COUNT'){
    if($action == 'COUNT')
     return $this->fetch_records('',true);
    else{
      $get_sum = 0;
      if(isset($this->theadColumn)):
        foreach ($this->theadColumn as $column) {
          if(isset($column[11]) AND $column[11] == true){
            if(isset($column[6]) && !empty($column[6])){
              $explode = explode(' as ', $column[6]);
              if(isset($explode[1]))
                $this->db->select('SUM('.$explode[0].') as '.$explode[1]);
              else
                $this->db->select_sum($column[1]);
            }
            else $this->db->select_sum($column[1]);
            $get_sum++;
          }
        }
      endif;
      if($get_sum !=0)
        return $this->fetch_records('',true,true);
    }
    
  }

  public function get_filter_column_value($third_column){
    if(isset($this->theadColumn)):
        foreach ($this->theadColumn as $column) {
          if(isset($column[3]) AND $column[3] == $third_column){
            return substr($column[6], 0, strrpos($column[6], " as "));
          }
        }
    endif;
  }

  public function fetch_records($export = false,$count=false,$sum=false) //record will fetch from here..
  {
    $join = array();
    if (is_array($this->tables)) {
      foreach ($this->tables as $key => $table) {
        if ($key != "0") {
          $join[] = array($table, $this->join_conditions[$key - 1], $this->join_type);
        }
      }
    }
    if($count == false):
      $select = $this->getSelectcolumn();
      $where  = $this->filterQuery();
      $order  = $this->getOrderQuery();
      $limit  = $this->limitQuery();
      $start  = !empty($this->limitQuery()[0])?$this->limitQuery()[0]:0;
      $group  = !empty($this->group_by)?$this->group_by:'id';
    else:
      $order  = $start  = $group  = "";
      $limit  = array('','');
      $where = $this->filterQuery();
      if($sum == false)
        $this->db->select("COUNT(".$this->count_column.") as total_count");
    endif;
    if(!isset($order)) $order ='';
      $model = singular($this->router->class).'_model';
      $result_array = $this->$model->get(array(),$where,$join,
                                                          array('order_by'=>$order,
                                                                'group_by'=>$group,
                                                                'limit'=>$limit,
                                                                'table'=>$this->primary_table));
    if($count == false)return $result_array; 
    else{
      if($sum == false)
        return $result_array[0]['total_count'];
      else
        return $result_array;
    };
  }//end of function.

  private function limitQuery()//limit query will be executed from here..
  {
    if(isset($this->export_limit) AND isset($_GET['page_no']) AND 
              isset($_GET['export']) AND $_GET['export'] == 1 AND !empty($this->export_limit)):
      $start = ($_GET['page_no'] - 1) * $this->export_limit;
      if(isset($_GET['format']) AND $_GET['format'] == 'csv'):
        $limit = '';
      else : 
        $limit = $this->export_limit;   
      endif;
    elseif(!isset($this->export_limit) AND (isset($_GET['page_no']) 
                    AND isset($_GET['export']) AND $_GET['export'] == 1) AND empty($this->export_limit)):
     $limit = 1000;
     $start = ($_GET['page_no'] - 1) * 1000;      
    else:
      $start = ($this->page_no - 1) * $this->limit;
      $limit = $this->limit;
    endif; 
    if(isset($_GET['show_all']) AND $_GET['show_all'] == true) return array(0,''); 
    return array($start, $limit);
  }//end of function..

  private function filterQuery()//filter query will execute query according to filter
  {
    $where = $where_data = array();
    if(!empty($this->where))
      $where_data['where'] = $this->where;
    $query_string = $_SERVER['QUERY_STRING'];
    parse_str($query_string,$_GET);

    $or_where = (isset($_GET['or_where'])?$_GET['or_where']:array());
    foreach ($or_where as $or_where_key => $or_where_value) {
      foreach ($or_where_value as $k1 => $v1) {
        $key = remove_operators($or_where_key);
        if(strpos($or_where_key,"having%") !== FALSE && !empty($v1))
          $key = $this->get_filter_column_value($key);
        $where_data["or_where"][$key."="][] = $v1;
      }
    }

    $where_array = (isset($_GET['where'])?$_GET['where']:array());
    foreach ($where_array as $array_key => $array_value) {
      if(!empty($array_value)){
        $key = $array_key;
        if(strpos($array_key,"having%") !== FALSE)
          $key = $this->get_filter_column_value(remove_operators($array_key));
        $where_data[$key] = $array_value;
      }
    }

    $date_array = (isset($_GET['date'])?$_GET['date']:array());
    foreach ($date_array as $date_key => $date_value) {
        $where_data[$date_key] = date_format(date_create($date_value),DATEFORMAT);
    }    

    $like_array = (isset($_GET['like'])?$_GET['like']:array());
    foreach ($like_array as $like_key => $like_value) {
      $key = remove_operators($like_key);
      if(strpos($like_key,"having%") !== FALSE)
        $key = $this->get_filter_column_value($key);
      $where_data['like'][remove_spaces_from_mysql_column($key)] = 
                                                                array(remove_spaces_from_value($like_value));
    }

    return $where_data;
  }//end of function..

  private function getSelectcolumn() //get select column
  {
    $column[9] = '';
    $select = '';
      if(isset($this->theadColumn)):
        foreach ($this->theadColumn as $column) {
          if ($column[1] != 'action' && $column[1] != 'checkbox') {
            if (isset($column[6]) AND (empty($column[9]))) 
              $this->db->select($column[6]);
            elseif(isset($column[6]) AND isset($column[9]) AND (!empty($column[9]) AND $column[9] != 'image'))
              $this->db->select($column[6]);
            elseif(isset($column[9]) AND $column[9] == 'image' AND $column[9] !== 1)
                                                                        //if image set in setting
              $this->db->select("(CASE 
                              WHEN ".$column[1]." IS NULL 
                              THEN '".$column[10]."'            
                              ELSE ".$column[1]."
                          END) as ".$column[1]);
            else $this->db->select($column[1] . ' as "' .$column[1].'"');
          }
        }
      endif;
      if(!isset($_GET['export']) && empty($_GET['export'])){
        if (!empty($this->extra_select_column)) $this->db->select($this->extra_select_column);
      }

  }//end of function..

  private function getOrderQuery(){//order query for procedure and simple query
    $order_by = '';
    if(isset($this->orderData) AND !empty($this->orderData)){
      foreach ($this->orderData as $key => $order) {
        $key = str_replace("having%", "", $key);
        $order_by .= ' '.$key.' '.$order; 
      }
    }else{
      if(isset($this->order_by) AND !empty($this->order_by)){
        $order_by .= ' '.$this->order_by; 
      }
    }
    return $order_by;
  }//end of function;

  public function getDashboardColumns($dashboard_id) 
  {
    $this->load->model('dashboards/dashboard_model');
    $columns = $this->dashboard_model->get('column_name',
                                                  array('where'=>array('id'=>decoding($dashboard_id))));
    $column_name = $columns[0]['column_name'];
    if(count($column_name)>0):
      $result = json_decode($column_name);
    else:
      $result = '';
    endif;
    return $result;
  }
}