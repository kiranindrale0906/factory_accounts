<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*version 1.1*/
trait Filter_trait  {
  private function getOrderHtml($heading) //order html
  {
    $order_by = "";
    if ($heading[2]) {
      $orderByData = array('heading'=>urlencode($heading[3]),'orderData'=>$this->orderData,
                          'page_url'=>$this->page_url);
      // pd($this->orderData);
      $order_by = $this->load->view('layouts/application/list/table_sort',$orderByData,true);
    }
    return $order_by;
  }

  private function getFilterHtml($heading, $k) //get filter HTML
  {
    $filter_by = "";
    $current_url = base_url().$this->module;
    $search_param = $heading[3];
    $module = $this->module;
    $get_current_coulmn_status = $this->get_current_column_get_data();
    $selected_column = $get_current_coulmn_status['selected_column'];
    $ordered_columns = $get_current_coulmn_status['ordered_columns'];
    $dashboard_id = $get_current_coulmn_status['dashboard_id'];
    $query_string = $_SERVER['QUERY_STRING'];
    $where_data = array();
    $where_data_with_operator = array();
    parse_str($query_string,$_GET);

    $where_array = (isset($_GET['where'])?$_GET['where']:array());
    foreach ($where_array as $array_key => $array_value) {
      if(!empty($array_value)){
        $where_data[$array_key] = $array_value;
        $where_data_with_operator[$array_key] = $array_value;
      }
    }
    $like_array = (isset($_GET['like'])?$_GET['like']:array());
    $where_set = array();
    foreach ($like_array as $like_key => $like_value) {
      $where_data[remove_operators($like_key)] = $like_value;
      $where_data_with_operator[$like_key] = $like_value;
    }
    $date_array = (isset($_GET['date'])?$_GET['date']:array());
    foreach ($date_array as $date_key => $date_value) {
        $where_data[remove_operators($date_key)][] = $date_value;
        $where_data_with_operator[$date_key] = $date_value;
    }
    $or_where_array = (isset($_GET['or_where'])?$_GET['or_where']:array());
    foreach ($or_where_array as $or_where_key => $or_where_value) {
        $where_data[remove_operators($or_where_key)] = $or_where_value;
        $where_data_with_operator[$or_where_key] = $or_where_value;
    }

    $_SESSION['query_string_filter'] = $where_data_with_operator;
    $_SESSION['query_values'] = $where_data;
    if ($heading[4]) {
      $filterHtml = array('k'=>$k,
                          'headingFunction'=>$this->headingFunction,
                          'search_url'=>$this->search_url,'current_url'=>$current_url,
                          'module'=>$module,'search_param'=>$search_param,
                          'query_string'=>basename($_SERVER['QUERY_STRING']),'dashboard_id'=>$dashboard_id);
       $filter_by = $this->load->view('layouts/application/list/table_filter',$filterHtml,TRUE);
    }
    return $filter_by;
  }

  private function filterHtml() {
    $html = '';
    $result['current_url'] = base_url().$this->module.'/'.$this->controller;
    if (!empty($this->getData)) :
        $result['param'] = $this->getData;
        $result['heading'] = $this->theadColumn;
        $html = $this->load->view('sys/search/view', $result, true);
    endif;
    return $html;
  }
}

?>