<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Production_same_purity_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model', 'argold/refresh_detail_model', 'ac_vouchers/voucher_model'));
  }

  public function index() {
    $this->_get_form_data();
    $this->get_production_summary();
    $this->get_groups();
    $this->load->render($this->router->class."/index", $this->data);
  }

  public function _get_form_data() {
    if(!isset($this->data['record'])) $this->data['record'] = array();
    $_GET['account_name'] ='SWARN SHILP CHAINS AND JEWELLERS PVT. LTD.';
    $this->data['site_name']    = (!empty($_GET['site_name']))    ? $_GET['site_name'] : '';
    $this->data['product_name'] = (!empty($_GET['product_name'])) ? $_GET['product_name'] : '';
    $this->data['in_purity']    = (!empty($_GET['in_purity']))    ? $_GET['in_purity'] : '';
    $this->data['account_name'] = (!empty($_GET['account_name'])) ? $_GET['account_name'] : 'SWARN SHILP CHAINS AND JEWELLERS PVT. LTD.';
    $this->data['category_one'] = (!empty($_GET['category_one'])) ? $_GET['category_one'] : '';
    $this->data['group_by']     = (!empty($_GET['group_by']))     ? $_GET['group_by'] : '';
    $this->data['machine_size'] = (!empty($_GET['machine_size'])) ? $_GET['machine_size'] : '';
    $this->data['design_code']  = (!empty($_GET['design_code']))  ? $_GET['design_code'] : '';
    $this->data['site_names']   = array('AR Gold', 'ARC', 'ARF');
    
    $url = '';
    //if ($this->data['site_name'] == 'AR Gold')     $url = API_APR2024_ARG_PATH."issue_departments/api_issue_departments/create";
    if ($this->data['site_name'] == 'ARF (Apr 2024)')     $url = API_APR2024_ARF_PATH."issue_departments/api_issue_departments/create";
    elseif ($this->data['site_name'] == 'ARC (Apr 2024)')     $url = API_APR2024_ARC_PATH."issue_departments/api_issue_departments/create";
      
    if (!empty($url)) {
      $records = json_decode(curl_post_request($url, $this->data));
      $this->data = array_merge($this->data, json_decode(json_encode($records), true));
      if (!isset($this->data['product_names'])) $this->data['product_names'] = array();
      if (!isset($this->data['in_purities']))   $this->data['in_purities']   = array();
      if (!isset($this->data['account_names'])) $this->data['account_names'] = array();
      if (!isset($this->data['category_ones'])) $this->data['category_ones'] = array(); 
      if (!isset($this->data['machine_sizes'])) $this->data['machine_sizes'] = array(); 
      if (!isset($this->data['design_codes']))  $this->data['design_codes']  = array(); 
    }}

  private function get_production_summary() {
    if (!isset($_GET)) {
      $_GET['production_summary']= array();
      $this->data['production_details'] = array();
      return;
    }
    $this->data['production_summary'] = $_GET;
    $_GET['start_date'] = '2021-11-04';
    /*if ($this->data['site_name'] == '' || $this->data['site_name'] == 'AR Gold') {
      $url = API_APR2024_ARG_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $argold_records = json_decode(json_encode($records), true);    
    }*/
    if (empty($argold_records['data'])) $argold_records['data'] = array();
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF (Apr 2024)') {
      $url = API_APR2024_ARF_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_records = json_decode(json_encode($records), true);
    }
    if (empty($arf_records['data'])) $arf_records['data'] = array();
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC (Apr 2024)') {
      $url = API_APR2024_ARC_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }
    if (empty($arc_records['data'])) $arc_records['data'] = array();
    if ($this->data['site_name'] == '' || ($this->data['site_name']=="AR Gold ERP" || $this->data['site_name']=="ARG ERP Software" || $this->data['site_name']=="ARF ERP Software"|| $this->data['site_name']=="Arf Erp Software" || $this->data['site_name']=="Rnd Erp Software" || $this->data['site_name']=="ARC ERP Software"|| $this->data['site_name']=="Arc Erp Software"|| $this->data['site_name']=="ARNA BANGLE" || $this->data['site_name']=="ARF ERP" || $this->data['site_name']=="ARC ERP" || $this->data['site_name']=="Domestic Internal ERP" || $this->data['site_name']=="Domestic Internal ERP Software" || $this->data['site_name']=="ARNA BANGLE ERP")) {
      $url = "https://erp.ar-gold.in/api/method/custom_app.api.material_issue.materialissue_details?month=".$this->data['filter_month']."&year=".$this->data['filter_year'];
      $records = json_decode(curl_get_erp_request($url, $_GET));
      $erp_records = json_decode(json_encode($records), true);
     if(!empty($erp_records)){
      $this->data['product_names']=array_unique(array_column($erp_records['message'],'product'));
      $this->data['wastage_percentage']=array_unique(array_column($erp_records['message'],'wastage_percentage'));
      $this->data['in_purities']=array_unique(array_column($erp_records['message'],'melting'));
      $this->data['account_names']=array_unique(array_column($erp_records['message'],'customer'));
      $this->data['category_ones']=array_unique(array_column($erp_records['message'],'product_category'));
      $this->data['machine_sizes']=array_unique(array_column($erp_records['message'],'machine_size'));
      $this->data['design_codes']=array_unique(array_column($erp_records['message'],'design'));
     } if (!isset($this->data['product_names'])) $this->data['product_names'] = array();
      if (!isset($this->data['wastage_percentage']))   $this->data['wastage_percentage']   = array();
      if (!isset($this->data['in_purities']))   $this->data['in_purities']   = array();
      if (!isset($this->data['account_names'])) $this->data['account_names'] = array();
      if (!isset($this->data['category_ones'])) $this->data['category_ones'] = array(); 
      if (!isset($this->data['machine_sizes'])) $this->data['machine_sizes'] = array(); 
      if (!isset($this->data['design_codes']))  $this->data['design_codes']  = array(); 
//pd( $this->data['product_names']);   
      $conditions=array();
      if(!empty($this->data['product_name'])){
        $conditions['product']=$this->data['product_name'];
      }if(!empty($this->data['category_one'])){
        $conditions['product_category']=$this->data['category_one'];
      }if(!empty($this->data['in_purity'])){
        $conditions['gpc_melting']=$this->data['in_purity'];
      }
      if(!empty($this->data['design_code'])){
        $conditions['design']=$this->data['design_code'];
      }
      if(!empty($this->data['machine_size'])){
        $conditions['machine_size']=$this->data['machine_size'];
      }
     
      if(!empty($this->data['account_name'])){
        $conditions['customer']=$this->data['account_name'];
      }
      if(!empty($this->data['site_name'])){
  if($this->data['site_name']=="AR Gold ERP"){
  $this->data['site_name']="ARG ERP Software";
  }
  if($this->data['site_name']=="ARF ERP"){
        $this->data['site_name']="ARF ERP Software";
        }
  if($this->data['site_name']=="RND ERP"){
        $this->data['site_name']="Rnd Erp Software";
        }
  if($this->data['site_name']=="ARC ERP"){
        $this->data['site_name']="Arc Erp Software";
        }
  if($this->data['site_name']=="Domestic Internal ERP"){
        $this->data['site_name']="Domestic Internal ERP Software";
        }
  if($this->data['site_name']=="ARNA BANGLE ERP"){
        $this->data['site_name']="ARNA BANGLE";
        }
        $conditions['factory']=$this->data['site_name'];
      }
      $erp_records['message']=$this->production_summary_model->multi_array_search_with_condition($erp_records,$conditions);
    // pd($erp_records);
      foreach ($erp_records['message'] as $index => $erp_record) {
        if(!empty($erp_record['items'])&&$erp_record['items']=="GPC" || $erp_record['items']=="Finished Goods"){
          $arg_erp_records[$index]['created_at']=date('Y-m-d',strtotime($erp_record['creation']));
            $arg_erp_records[$index]['str_created_date']=$erp_record['creation'];
            $arg_erp_records[$index]['product_name']=!empty($erp_record['product'])?$erp_record['product']:"";
            $arg_erp_records[$index]['category_one']=!empty($erp_record['product_category'])?$erp_record['product_category']:"";
            $arg_erp_records[$index]['machine_size']=!empty($erp_record['machine_size'])?$erp_record['machine_size']:"";
            $arg_erp_records[$index]['design_code']=!empty($erp_record['design'])?$erp_record['design']:"";
            $arg_erp_records[$index]['account_name']=$erp_record['customer'];
            $arg_erp_records[$index]['issue_gpc_out']=$erp_record['balance_weight'];
            $arg_erp_records[$index]['out_purity']=$erp_record['gpc_melting'];
            $arg_erp_records[$index]['in_purity']=$erp_record['melting'];
            $arg_erp_records[$index]['wastage_percentage']=$erp_record['wastage_percentage'];
      }
      }    
      }
    $records = array_merge(/*$argold_records['data'],*/ 
                           $arf_records['data'],
                           $arc_records['data'],
                           $arg_erp_records);

      $this->data['production_details'] = $this->get_grouped_records($records);
    $this->get_production_group_total();
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
        if($record['out_purity']==$record['in_purity']){
          $this->data['production_total'][$group]['weight'] += $record['issue_gpc_out'];
          $this->data['production_total'][$group]['vadotar'] += $record['issue_gpc_out'] * ($record['out_purity'] - $record['in_purity']) / 100;
        }
      }
    }
  }
  private function get_groups() {
    $production_detail_groups = array_keys($this->data['production_details']);
    $this->data['groups'] = array_unique($production_detail_groups);
    sort($this->data['groups']);
  }
}
