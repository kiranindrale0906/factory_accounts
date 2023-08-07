<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model', 'argold/refresh_detail_model', 'ac_vouchers/voucher_model'));
  }

  public function index() {
    $this->_get_form_data();
    $this->get_production_summary();
    // if ($this->data['site_name'] == '')
      $this->get_refresh_details();
    // else 
    //   $this->data['refresh_details'] = array();
    $this->get_groups();
    // pd($this->data);
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

   /* $this->data['site_names']   = array('AR Gold (May 2022)', 'ARC (May 2022)', 'ARF (May 2022)',
                                        'AR Gold (Aug 2022)', 'ARC (Aug 2022)', 'ARF (Aug 2022)',
                                        'AR Gold (Feb 2023)', 'ARC (Feb 2023)', 'ARF (Feb 2023)');
    */
    $this->data['site_names']   = array('AR Gold', 'ARC', 'ARF');
    
    $url = '';
    if     ($this->data['site_name'] == 'AR Gold (May 2022)') $url = API_MAY2022_ARG_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARF (May 2022)')     $url = API_MAY2022_ARF_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC (May 2022)')     $url = API_MAY2022_ARC_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'AR Gold (Aug 2022)')     $url = API_AUG2022_ARG_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARF (Aug 2022)')     $url = API_AUG2022_ARF_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC (Aug 2022)')     $url = API_AUG2022_ARC_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'AR Gold (Feb 2023)')     $url = API_FEB2023_ARG_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARF (Feb 2023)')     $url = API_FEB2023_ARF_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC (Feb 2023)')     $url = API_FEB2023_ARC_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'AR Gold')     $url = API_APR2023_ARG_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARF')     $url = API_APR2023_ARF_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC')     $url = API_APR2023_ARC_PATH."issue_departments/api_issue_departments/create";
      
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
    $_GET['start_date'] = '2021-11-04';

/*    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold (May 2022)') {
      $url = API_MAY2022_ARG_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_records = json_decode(json_encode($records), true);    
    }
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold (Aug 2022)') {
      $url = API_AUG2022_ARG_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_records = json_decode(json_encode($records), true);    
    }
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold (Feb 2023)') {
      $url = API_FEB2023_ARG_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_records = json_decode(json_encode($records), true);    
    }*/
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold') {
      $url = API_APR2023_ARG_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_records = json_decode(json_encode($records), true);    
    }
    if (empty($argold_records['data'])) $argold_records['data'] = array();

/*    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF (May 2022)') {
      $url = API_MAY2022_ARF_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_records = json_decode(json_encode($records), true);
    }
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF (Aug 2022)') {
      $url = API_AUG2022_ARF_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_records = json_decode(json_encode($records), true);
    }
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF (Feb 2023)') {
      $url = API_FEB2023_ARF_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_records = json_decode(json_encode($records), true);
    }*/if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF') {
      $url = API_APR2023_ARF_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_records = json_decode(json_encode($records), true);
    }
    if (empty($arf_records['data'])) $arf_records['data'] = array();

    /*if($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC (May 2022)') {
      $url = API_MAY2022_ARC_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC (Aug 2022)') {
      $url = API_AUG2022_ARC_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC (Feb 2023)') {
      $url = API_AUG2022_ARC_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }*/
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC') {
      $url = API_APR2023_ARC_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }
    if (empty($arc_records['data'])) $arc_records['data'] = array();

    $records = array_merge($argold_records['data'], 
                           $arf_records['data'],
                           $arc_records['data']);
    $this->data['production_details'] = $this->get_grouped_records($records);
    $this->get_production_group_total();
  }

  private function get_refresh_details() {
    $select = 'date(created_at) as created_at, item_name, GROUP_CONCAT(refresh_id) as refresh_id, GROUP_CONCAT(weight) as refresh_weight, sum(weight) as weight, sum(weight * purity) / sum(weight) as purity, sum(weight * factory_purity) / sum(weight) as factory_purity';
    $where=array();
    $group_by=array('group_by' => 'date(created_at), item_name');
    if(!empty($this->data['site_name'])){
       $where['site_name']    =$this->data['site_name'];
    }
    if(!empty($this->data['product_name'])){
       $where['item_name']    =$this->data['product_name'];
       $group_by=array('group_by' => 'date(created_at)');
    }

    if(!empty($this->data['in_purity'])){
       $where['factory_purity']    =$this->data['in_purity'];
    }
    
    if ($this->data['group_by'] == 'Week') {
      $period_from_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(date_format(created_at,"%Y"), 1), INTERVAL week(created_at) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(date_format(created_at,"%Y"), 1), INTERVAL week(created_at) WEEK)
                                ) -1 DAY)';
      $period_to_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(date_format(created_at,"%Y"), 1), INTERVAL week(created_at) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(date_format(created_at,"%Y"), 1), INTERVAL week(created_at) WEEK)
                                ) -7 DAY)';
      $period_select = 'CONCAT('.$period_from_date.' , " - ", '.$period_to_date.')';
      $select .= ' , '.$period_select.' as str_created_date';
    };
   
    $refresh_details = $this->refresh_detail_model->get($select, $where, array(),$group_by);
    $voucher_data=array();
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC') {
      $select = 'date(created_at) as created_at, description as item_name, GROUP_CONCAT(id) as refresh_id, GROUP_CONCAT(credit_weight) as refresh_weight, sum(credit_weight) as weight, sum(credit_weight * purity) / sum(credit_weight) as purity, sum(credit_weight * factory_purity) / sum(credit_weight) as factory_purity';
   
      $voucher_data=$this->voucher_model->get($select, array('credit_weight !=' => 0,'site_name'=>"ARC (Apr 2023)",'receipt_type' => 'Domestic Internal'));
    }if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF') {
      $select = 'date(created_at) as created_at, description as item_name, GROUP_CONCAT(id) as refresh_id, GROUP_CONCAT(credit_weight) as refresh_weight, sum(credit_weight) as weight, sum(credit_weight * purity) / sum(credit_weight) as purity, sum(credit_weight * factory_purity) / sum(credit_weight) as factory_purity';
   
      $voucher_data=$this->voucher_model->get($select, array('credit_weight !=' => 0,'site_name'=>"ARC (Apr 2023)",'receipt_type' => 'Domestic Internal'));
    }if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold') {
      $select = 'date(created_at) as created_at, description as item_name, GROUP_CONCAT(id) as refresh_id, GROUP_CONCAT(credit_weight) as refresh_weight, sum(credit_weight) as weight, sum(credit_weight * purity) / sum(credit_weight) as purity, sum(credit_weight * factory_purity) / sum(credit_weight) as factory_purity';
   
      $voucher_data=$this->voucher_model->get($select, array('credit_weight !=' => 0,'site_name'=>"AR Gold (Apr 2023)",'receipt_type' => 'Domestic Internal'));
    }

    $records = array_merge($refresh_details,$voucher_data);
    

    $this->data['refresh_details'] = $this->get_grouped_records($records);
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
    }elseif ($this->data['group_by'] == 'Year') {
      foreach ($records as $record) {     
        if (!isset($date_wise_data[substr($record['created_at'], 0, 4)])) 
          $date_wise_data[substr($record['created_at'], 0, 4)] = array('records' => array(), 'issue_gpc_out' => 0);
        $date_wise_data[substr($record['created_at'], 0, 4)]['records'][] = $record;
      }
    }elseif ($this->data['group_by'] == 'Week') {
      foreach ($records as $record) {
      if (!isset($date_wise_data[$record['str_created_date']])) 
        $date_wise_data[$record['str_created_date']] = array('records' => array(), 'issue_gpc_out' => 0);
          $date_wise_data[$record['str_created_date']]['records'][] = $record;
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
