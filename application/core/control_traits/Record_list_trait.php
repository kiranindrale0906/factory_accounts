<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*version 1.1*/
require_once APPPATH . "core/control_traits/Filter_trait.php";
trait Record_list_trait  {
  use filter_trait;
  private $page_url = '';
  private $order_url = '';
  private $url = '';
  private $select_url = '';
  private $search_url = '';
  private $pagination = '';
  private $limit = '';
  private $primary_table = '';
  private $export_limit = '';
  private $tables = array();
  private $thead = '';
  private $theadColumn = '';
  private $orderData = '';
  private $headingFunction = '';
  private $getData = '';
  private $sum = '';

  private function set_attributes($param){
    $getData = $this->getData($param);
    $this->page_no    = $getData['page_no'];
    $this->search_url = $this->router->fetch_class();
    $this->headingFunction = 'list_settings';
    $this->page_url   = $getData['page_url'];
    $this->order_url  = $getData['order_url'];
    $this->orderData  = $getData['orderData'];
    $this->export_limit = @$param['export_limit'];
    $this->primary_table = @$param['primary_table'];
    $this->getData = $getData['getData'];
    $this->tables = $param['table'];
    isset($param['limit']) ? $this->limit = $param['limit'] : $this->limit = "10";
    if (!empty($param['new_headers'])) {
      $this->theadColumn = $param['new_headers'];
    } else {
      $headingFunction = $this->headingFunction;
      $this->theadColumn = list_settings();
    }

  }

  private function _getAllRecords($where=array(), $count = FALSE,$arrange_coulmn=false,$select_column = false){
    $type = ''; $type_id = '';
    $masters['name'] = $this->router->module.'/'.$this->router->class;
    $masters['extension'] = isset($_GET['extension']) ? $_GET['extension'] : '';
    $records_count = isset($count) ? $count : '';
    return $this->getMasterRecords($masters['name'], $masters['extension'], $type, $type_id, $records_count,'','',true,$where,$select_column,$arrange_coulmn);
  }

  private function mergePerKey($diff,$default_array){
    $mergedArray = [];
    foreach ($default_array as $default_array_key => $default_array_value) 
    {
      foreach ($diff as $diff_key => $diff_value) {
          $mergedArray[$diff_key] = $diff_value; continue;
      }
      $mergedArray[] = $default_array_value;
    }
    return $mergedArray;
  }
  
  private function getMasterRecords($master_name, $extension, $type = '', $type_id = '', $count = FALSE,$is_dashboard=FALSE,$function_name='',$save_prefrences= true,$where=array(),$selectcolumn,$arrangecolumn) {
    $model_name = singular($this->router->fetch_class()).'_model';
    $this->load->model('sys/column_prefrence_model');
    if($is_dashboard == FALSE){
      $table_settings = getTableSettings('',$where);
    }else{
      $this->load->helper(array($master_name.'_dashboard'));

      $table_settings = $function_name('',$where);
    }
    $old_header = list_settings();
  
    $select_column_data = $this->column_prefrence_model->get_column_prefrences();

    if(empty($this->input->post('selected_columns')) && isset($select_column_data['select_column_json']))
      $select_column = json_decode($select_column_data['select_column_json']);
    else
      $select_column = $this->input->post('selected_columns');
  
    if(empty($this->input->post('ordered_columns')) && isset($select_column_data['arrange_column_json']))
      $arrange_column = (array) json_decode($select_column_data['arrange_column_json']);
    else
      $arrange_column = $this->input->post('ordered_columns');
      $id = isset($select_column_data['id']) ? $select_column_data['id'] : '';
    if ($this->input->post('selected_columns') == '') 
      $empty_headers = '';

    $new_headers = '';
    $arrange_column_array = '';
    if ($this->input->get('dashboard_id') != '') {
      if(!empty($arrange_column) && ($this->input->get('ordered_columns') == 1)){
        foreach ($arrange_column as $newkey => $newkeyvalue) {
          foreach ($old_header as $oldkey => $oldvalue) {
            if ($oldvalue[0] == $newkeyvalue) 
              $new_headers[] = $oldvalue;
          }
        }
      }elseif(!empty($select_column) && ($this->input->get('selected_column') == 1)){
        foreach ($select_column as $newkey => $newkeyvalue) {
          foreach ($old_header as $oldkey => $oldvalue) {
            if ($oldkey == $newkeyvalue){ 
              $new_headers[] = $oldvalue;
            }
          }
        }

      }else{
        $dashboard_headers = $this->$model_name->getDashboardColumns($this->input->get('dashboard_id'));
        foreach ($dashboard_headers as $newkey => $newkeyvalue) {
          foreach ($old_header as $oldkey => $oldvalue) {
            if ($oldvalue[0] == $newkeyvalue) 
              $new_headers[] = $oldvalue;
          }
        }
      }
    }else if (!empty($select_column) && empty($arrange_column) && ($this->input->get('selected_column') == 1)) {
      foreach ($select_column as $newkey => $newkeyvalue) {
        foreach ($old_header as $oldkey => $oldvalue) {
          if ($oldkey == $newkeyvalue){ 
            $new_headers[] = $oldvalue;
            $arrange_column[] = $oldvalue[0];
          }
        }
      } 
    }else if (empty($select_column) AND $select_column != 'null' && !empty($arrange_column)) {
      foreach ($arrange_column as $newkey => $newkeyvalue) {
        foreach ($old_header as $oldkey => $oldvalue) {
          if ($oldvalue[0] == $newkeyvalue){ 
            $new_headers[] = $oldvalue;
          }
        }
      } 
    }elseif(!empty($select_column) AND $select_column != 'null' AND !empty($arrange_column)){
      foreach ($select_column as $newkey => $newkeyvalue) {
        foreach ($old_header as $oldkey => $oldvalue) {
          if ($oldkey == $newkeyvalue){ 
            $set_header[] = $oldvalue;
            $arrange_column_set[] = $oldvalue[0];
          }
        }
      }
      if(is_array($arrange_column)){
        $diff = array_diff($arrange_column_set,$arrange_column); 
  
        //pr($arrange_column_set);
        $arrange_column = $this->mergePerKey($diff,$arrange_column);
      }
      foreach ($arrange_column as $arrangeKey => $newselectvalue) {
        foreach ($set_header as $newKey => $new_header_value) {
          if ($new_header_value[0] == $newselectvalue) 
            $new_headers[] = $new_header_value;
        }
      }
    }else 
      $new_headers = $old_header; 
  
    if($arrangecolumn == true || $selectcolumn == true){
      $column_prefrences =  array('filter_columns'=>$new_headers,
                    'table_columns'=>list_settings(),
                    'theadColumn' => $this->theadColumn);
      return $column_prefrences;
    }

    $this->save_column_prefrences($arrange_column,$save_prefrences,$id);
    $table_settings['new_headers'] = $new_headers;
    if (isset($count) && $count == TRUE) 
      return  $this->getRecordCounts($table_settings);

    $records = $this->getRecords($table_settings, $extension);
    $records['master_name'] = $master_name;
    $records['page_title'] = getTableSettings()['page_title'];
    $records['table_columns'] = list_settings();
    $records['filter_columns'] = $new_headers;
    $controller = strtoupper($this->router->class);
    unset($_SESSION[$controller.'_LISTING_HEADERS']);
    $_SESSION[$controller.'_LISTING_HEADERS'] = json_encode($new_headers);
    return $records;
  }

  private function save_column_prefrences($arrange_column_array='',$save_prefrences,$id){
    $this->load->model('sys/column_prefrence_model');
    $encoded_columns['select_column'] = json_encode($this->input->post('selected_columns'));
    if(!empty($arrange_column_array)){
      $encoded_columns['arrange_column'] = json_encode($arrange_column_array);
    }
    if(isset($_GET['selected_column']) && $_GET['selected_column'] == 1 && !empty($encoded_columns['select_column']) &&  $save_prefrences == true){
      $this->column_prefrence_model->save_column_filters($encoded_columns,$id);
    }

  }

  private function getRecords($param, $extension, $export = false) {//get records data..
    if ($extension != '') $export = true;
    $getData = $this->getData($param); 
    //pr($getData);
    $this->model->initalized($param,$getData);
    $this->set_attributes($param);
    if ($export && $extension == '.xls') {
      $this->getExelData();
      exit;
    }else {
      $this->crateThead();
      $this->createTbody();
      $get_where = isset($this->input->get()['where'])?$this->input->get()['where']:array();
      $get_like = isset($this->input->get()['like'])?$this->input->get()['like']:array();
      $merged_get = array_merge($get_where,$get_like);
      //pr($_GET);
      return array('html' => $this->html, 
                  'excel_url' => $this->order_url . "&excel=export", 
                  'thead' => $this->thead, 
                  'sum' => $this->sum, 
                  'getData' => $merged_get, 
                  'theadColumn' => $this->theadColumn, 
                  'url' => $this->url, 
                  'select_url' => $this->select_url, 
                  'table_name' => $this->tables 
                  );
    }
  }//end of function..

  private function createTbody() //create body of pages
  {
   if((isset($_GET['export']) AND !isset($_GET['page_no'])) || (isset($_GET['format']) 
                                                            AND $_GET['format'] == 'csv')): 
    $export = true;else: $export =  false; endif;
    $this->record = $this->model->fetch_records($export);
    $this->sum = $this->model->get_count_and_sum('SUM');
    $this->html = $this->record;
  }//end of filter query function 

  private function crateThead() //create thead
  {
    $this->thead = array();
    if(isset($this->theadColumn)){
      foreach ($this->theadColumn as $k => $heading) {
        $order_by = $this->getOrderHtml($heading);
        $filter_by = $this->getFilterHtml($heading, $k);
        $this->thead[$k][0] = $order_by;
        $this->thead[$k][1] = $filter_by;
        $this->thead[$k][2] = $heading[0];
      }
    }
  }

  private function getRecordCounts($param){
    return $this->model->get_count_and_sum('COUNT');
  }

  private function getData($param){
    $getData = $this->input->get();
    if (!isset($getData['page_no']) || empty($getData['page_no'])) $page_no = "1";
    else $page_no = $getData['page_no'];
    if(isset($getData['order_column']) && !empty($getData['order_column']))
    {
      $orderData[$getData['order_column']] = $getData['order_by'];
    }
    $controller = $this->router->fetch_class();
    $this->search_url = $controller;
    $module = $this->router->fetch_module();
    $page_url =  base_url() 
                .$module.'/'.  $this->search_url . "?";
    $order_url = base_url() 
                .$module.'/'.  $this->search_url . "?order_column=" 
                . @$getData['order_column'] . "&order_by=" . @$getData['order_by'];
    $url =       base_url() .$module.'/'.  $this->search_url 
                . "?order_column=" . @$getData['order_column'] . "&order_by=" 
                . @$getData['order_by'] . "&page_no=" . $page_no;
    $select_url = base_url() .$module.'/'.  $this->search_url . "?order_column=" 
                . @$getData['order_column'] . "&order_by=" . @$getData['order_by'] 
                . "&page_no=" . $page_no;
    unset($getData['page_no']);
    unset($getData['order_column']);
    unset($getData['order_by']);
    return array("getData" => $getData, "orderData" => @$orderData, "page_url" => $page_url, "order_url" => $order_url, "page_no" => $page_no, "url" => $url, "select_url" => $select_url);
  }


  private function get_current_column_get_data() //get current column
  {
    $get_data = $_GET;
    $selected_column=0;
    $ordered_columns=0;
    $dashboard_id='';
    if(array_key_exists("selected_column",$get_data) || array_key_exists("ordered_columns",$get_data)){
      $selected_column=$get_data['selected_column'];
      $ordered_columns=$get_data['ordered_columns'];
    }
    if(array_key_exists("dashboard_id",$get_data)){
      $dashboard_id=$get_data['dashboard_id'];
    }
    return array('selected_column'=>$selected_column,'ordered_columns'=>$ordered_columns,
                                                                      'dashboard_id'=>$dashboard_id);
  }

  private function _select_arrange_column($where){
    $response = $this->_getAllRecords($where,'',true);
   // $response['show_class'] = $_GET['show_class']; 
    if(isset($_GET['arrange_col']) AND $_GET['arrange_col'] == 1){
      $html = $this->load->view('sys/sys/arrange_column',$response,true);
      $title = 'Drag Column Name To Arrange Columns:';
    }else{
      $html = $this->load->view('sys/sys/select_column',$response,true);
      $title = 'Select/Deselect Columns';
    }
    echo json_encode(array("status"=>'success','data'=>$html,'open_modal'=>1,'title'=>$title));exit;
  }
}
?>