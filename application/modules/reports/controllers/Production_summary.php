<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->_get_form_data();
    $this->get_production_summary();
    $this->load->render($this->router->class."/index", $this->data);
  }

  public function _get_form_data() {
    if(!isset($this->data['record'])) $this->data['record'] = array();
    
    $this->data['site_name']    = (!empty($_GET['site_name'])) ? $_GET['site_name'] : '';
    $this->data['product_name'] = (!empty($_GET['product_name'])) ? $_GET['product_name'] : '';
    $this->data['in_purity']    = (!empty($_GET['in_purity'])) ? $_GET['in_purity'] : '';
    $this->data['account_name'] = (!empty($_GET['account_name'])) ? $_GET['account_name'] : '';
    $this->data['category_one'] = (!empty($_GET['category_one'])) ? $_GET['category_one'] : '';
    $this->data['group_by']     = (!empty($_GET['group_by'])) ? $_GET['group_by'] : '';
    //if (!empty($_GET['production_summary']['machine_size'])) $this->data['record']['machine_size'] = $_GET['production_summary']['machine_size'];
    //if (!empty($_GET['production_summary']['design_code']))  $this->data['record']['design_code']  = $_GET['production_summary']['design_code'];

    $this->data['site_names']   = array('AR Gold', 'ARC', 'ARF');
    $url = '';
    if ($this->data['site_name'] == 'AR Gold') $url = API_ARG_BASE_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARF') $url = API_ARF_BASE_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC') $url = API_ARC_BASE_PATH."issue_departments/api_issue_departments/create";
      
    if (!empty($url)) {
      $records=json_decode(curl_post_request($url, $this->data));
      $this->data = array_merge($this->data, json_decode(json_encode($records), true));
      if (!isset($this->data['product_names'])) $this->data['product_names'] = array();
      if (!isset($this->data['in_purities']))   $this->data['in_purities']   = array();
      if (!isset($this->data['account_names'])) $this->data['account_names'] = array();
      if (!isset($this->data['category_ones'])) $this->data['category_ones'] = array(); 
    }

    //$this->data['product_names'] = array_unique(array_merge($argold_data['product_names']['names'], $argold_data['product_names']['names']));
    //$this->data['in_purities']   = array_unique(array_merge($argold_data['in_purities']['names'],   $argold_data['in_purities']['names']));
    //$this->data['account_names'] = array_unique(array_merge($argold_data['account_names']['names'], $argold_data['account_names']['names']));
    //$this->data['category_ones'] = array_unique(array_merge($argold_data['category_ones']['names'], $argold_data['category_ones']['names']));
    //$this->data['machine_sizes'] = get_dropdown_array(array_unique(array_merge($arf_data['machine_sizes']['names'], $argold_data['machine_sizes']['names'])), true);
    //$this->data['design_codes']  = get_dropdown_array(array_unique(array_merge($arf_data['design_codes']['names'], $argold_data['design_codes']['names'])), true);
  }

  private function get_production_summary() {
    if (!isset($_GET)) {
      $_GET['production_summary']= array();
      $this->data['records'] = array('data' => array());
      return;
    }
    $this->data['production_summary'] = $_GET;

    if ($this->data['site_name'] = '' || $this->data['site_name'] == 'AR Gold') {
      $url = API_ARG_BASE_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_records = json_decode(json_encode($records), true);    
    }
    if (empty($argold_records['data'])) $argold_records['data'] = array();

    if ($this->data['site_name'] = '' || $this->data['site_name'] == 'ARF') {
      $url = API_ARF_BASE_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_records = json_decode(json_encode($records), true);
    }
    if (empty($arf_records['data'])) $arf_records['data'] = array();

    if ($this->data['site_name'] = '' || $this->data['site_name'] == 'ARC') {
      $url = API_ARC_BASE_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }
    if (empty($arc_records['data'])) $arf_records['data'] = array();

    if ($this->data['site_name'] == '') {
      $records = array_merge($arf_records['data'], $argold_records['data'], $arc_records['data']);
    }

    $date_wise_data = array();
    if ($this->data['group_by'] == 'Date') {
      foreach ($records as $record) {      
        if (!isset($date_wise_data[$record['created_at']])) $date_wise_data[$record['created_at']] = array('records' => array(), 'issue_gpc_out' => 0);
        $date_wise_data[$record['created_at']]['records'][] = $record;
      }
    } elseif ($this->data['group_by'] == 'Month') {
      foreach ($records as $record) {      
        if (!isset($date_wise_data[substr($record['created_at'], 0, 7)])) $date_wise_data[substr($record['created_at'], 0, 7)] = array('records' => array(), 'issue_gpc_out' => 0);
        $date_wise_data[substr($record['created_at'], 0, 7)]['records'][] = $record;
      }
    } else {
      foreach ($records as $record) { 
        $date_wise_data['All']['records'][] = $record;
      }
    }
    ksort($date_wise_data);
    $this->data['records'] = array('data' => $date_wise_data);
  }
}
