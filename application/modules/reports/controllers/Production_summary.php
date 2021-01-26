<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model', 'argold/refresh_detail_model'));
  }

  public function index() {
    $this->_get_form_data();
    $this->get_production_summary();
    if ($this->data['site_name'] == '')
      $this->get_refresh_details();
    else 
      $this->data['refresh_details'] = array();
    $this->get_groups();
    $this->load->render($this->router->class."/index", $this->data);
  }

  public function _get_form_data() {
    if(!isset($this->data['record'])) $this->data['record'] = array();
    
    $this->data['site_name']    = (!empty($_GET['site_name']))    ? $_GET['site_name'] : '';
    $this->data['product_name'] = (!empty($_GET['product_name'])) ? $_GET['product_name'] : '';
    $this->data['in_purity']    = (!empty($_GET['in_purity']))    ? $_GET['in_purity'] : '';
    $this->data['account_name'] = (!empty($_GET['account_name'])) ? $_GET['account_name'] : '';
    $this->data['category_one'] = (!empty($_GET['category_one'])) ? $_GET['category_one'] : '';
    $this->data['group_by']     = (!empty($_GET['group_by']))     ? $_GET['group_by'] : '';
    $this->data['machine_size'] = (!empty($_GET['machine_size'])) ? $_GET['machine_size'] : '';
    $this->data['design_code']  = (!empty($_GET['design_code']))  ? $_GET['design_code'] : '';

    $this->data['site_names']   = array('AR Gold Jan 2021', 'ARC Jan 2021', 'ARF Jan 2021', 'AR Gold Nov 2020', 'ARC Nov 2020', 'ARF Nov 2020');
    $url = '';
    if     ($this->data['site_name'] == 'AR Gold Jan 2021') $url = API_ARG_JAN2021_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARF Jan 2021')     $url = API_ARF_JAN2021_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC Jan 2021')     $url = API_ARC_JAN2021_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'AR Gold Nov 2020') $url = API_ARG_NOV2020_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARF Nov 2020')     $url = API_ARF_NOV2020_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC Nov 2020')     $url = API_ARC_NOV2020_PATH."issue_departments/api_issue_departments/create";
      
    if (!empty($url)) {
      $records = json_decode(curl_post_request($url, $this->data));
      $this->data = array_merge($this->data, json_decode(json_encode($records), true));
      if (!isset($this->data['product_names'])) $this->data['product_names'] = array();
      if (!isset($this->data['in_purities']))   $this->data['in_purities']   = array();
      if (!isset($this->data['account_names'])) $this->data['account_names'] = array();
      if (!isset($this->data['category_ones'])) $this->data['category_ones'] = array(); 
      if (!isset($this->data['machine_sizes'])) $this->data['machine_sizes'] = array(); 
      if (!isset($this->data['design_codes']))  $this->data['design_codes']  = array(); 
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
      $this->data['production_details'] = array();
      return;
    }
    $this->data['production_summary'] = $_GET;

    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold Jan 2021') {
      $url = API_ARG_JAN2021_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_jan2021_records = json_decode(json_encode($records), true);    
    }
    if (empty($argold_jan2021_records['data'])) $argold_jan2021_records['data'] = array();

    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold Nov 2020') {
      $url = API_ARG_NOV2020_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_nov2020_records = json_decode(json_encode($records), true);    
    }
    if (empty($argold_nov2020_records['data'])) $argold_nov2020_records['data'] = array();

    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF Jan 2021') {
      $url = API_ARF_JAN2021_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_jan2021_records = json_decode(json_encode($records), true);
    }
    if (empty($arf_jan2021_records['data'])) $arf_jan2021_records['data'] = array();

    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF Nov 2020') {
      $url = API_ARF_NOV2020_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_nov2020_records = json_decode(json_encode($records), true);
    }
    if (empty($arf_nov2020_records['data'])) $arf_nov2020_records['data'] = array();

    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC Jan 2021') {
      $url = API_ARC_JAN2021_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_jan2021_records = json_decode(json_encode($records), true);
    }
    if (empty($arc_jan2021_records['data'])) $arc_jan2021_records['data'] = array();

    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC Nov 2020') {
      $url = API_ARC_NOV2020_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_nov2020_records = json_decode(json_encode($records), true);
    }
    if (empty($arc_nov2020_records['data'])) $arc_nov2020_records['data'] = array();

    $records = array_merge($argold_nov2020_records['data'], $argold_jan2021_records['data'], 
                           $arf_jan2021_records['data'], $arf_nov2020_records['data'],
                           $arc_jan2021_records['data'], $arc_nov2020_records['data']);
    $this->data['production_details'] = $this->get_grouped_records($records);
    $this->get_production_group_total();
  }

  private function get_refresh_details() {
    $select = 'date(created_at) as created_at, item_name, sum(weight) as weight, sum(weight * purity) / sum(weight) as purity, sum(weight * factory_purity) / sum(weight) as factory_purity';
    $refresh_details = $this->refresh_detail_model->get($select, array(), array(), array('group_by' => 'date(created_at), item_name'));
    $this->data['refresh_details'] = $this->get_grouped_records($refresh_details);
    $this->get_refresh_group_total();
  }

  private function get_grouped_records($records) {
    $date_wise_data = array();
    if ($this->data['group_by'] == 'Date') {
      foreach ($records as $record) {      
        if (!isset($date_wise_data[$record['created_at']])) 
          $date_wise_data[$record['created_at']] = array('records' => array(), 'issue_gpc_out' => 0);
        $date_wise_data[$record['created_at']]['records'][] = $record;
      }
    } elseif ($this->data['group_by'] == 'Month') {
      foreach ($records as $record) {      
        if (!isset($date_wise_data[substr($record['created_at'], 0, 7)])) 
          $date_wise_data[substr($record['created_at'], 0, 7)] = array('records' => array(), 'issue_gpc_out' => 0);
        $date_wise_data[substr($record['created_at'], 0, 7)]['records'][] = $record;
      }
    } else {
      foreach ($records as $record) { 
        $date_wise_data['All']['records'][] = $record;
      }
    }
    ksort($date_wise_data);
    return $date_wise_data;
  }

  private function get_production_group_total() {
    $this->data['production_total'] = array();
    foreach ($this->data['production_details'] as $group => $production_detail) {
      $this->data['production_total'][$group] = array('weight' => 0, 'vadotar' => 0);
      foreach ($production_detail['records'] as $record) {
        $this->data['production_total'][$group]['weight'] += $record['issue_gpc_out'];
        $this->data['production_total'][$group]['vadotar'] += $record['issue_gpc_out'] * ($record['out_purity'] - $record['in_purity']) / 100;
      }
    }
  }

  private function get_refresh_group_total() {
    $this->data['refresh_total'] = array();
    foreach ($this->data['refresh_details'] as $group => $refresh_detail) {
      $this->data['refresh_total'][$group] = array('weight' => 0, 'vadotar' => 0);
      foreach ($refresh_detail['records'] as $record) {
        $this->data['refresh_total'][$group]['weight'] += $record['weight'];
        $this->data['refresh_total'][$group]['vadotar'] += $record['weight'] * ($record['purity'] - $record['factory_purity']) / 100;
      }
    }
  }

  private function get_groups() {
    $production_detail_groups = array_keys($this->data['production_details']);
    $refresh_detail_groups = array_keys($this->data['refresh_details']);
    $this->data['groups'] = array_unique(array_merge($production_detail_groups, $refresh_detail_groups));
    sort($this->data['groups']);
  }
}
