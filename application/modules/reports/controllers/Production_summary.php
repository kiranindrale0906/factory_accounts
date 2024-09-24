<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model', 'argold/refresh_detail_model', 'ac_vouchers/voucher_model'));
  }

  public function index() {
    ini_set('max_input_vars', '3000');
    ini_set('max_execution_time',0);

    $this->_get_form_data();
    $this->get_production_summary();
    // if ($this->data['site_name'] == '')
      $this->get_refresh_details();
    // else 
    //   $this->data['refresh_details'] = array();
    $this->get_groups();
    //pd($this->data);
    $this->load->render($this->router->class."/index", $this->data);
  }

  public function _get_form_data() {
    if(!isset($this->data['record'])) $this->data['record'] = array();
    $this->data['site_name']    = (!empty($_GET['site_name']))    ? $_GET['site_name'] : '';
    $this->data['product_name'] = (!empty($_GET['product_name'])) ? $_GET['product_name'] : '';
    $this->data['in_purity']    = (!empty($_GET['in_purity']))    ? $_GET['in_purity'] : '';
    $this->data['account_name'] = (!empty($_GET['account_name'])) ? $_GET['account_name'] : '';
    $this->data['filter_month'] = (!empty($_GET['filter_month'])) ? $_GET['filter_month'] : date('m');
    $this->data['filter_year'] = (!empty($_GET['filter_year'])) ? $_GET['filter_year'] : date('Y');
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
     /*elseif ($this->data['site_name'] == 'AR Gold (Apr 2024)')     $url = API_APR2024_ARG_PATH."issue_departments/api_issue_departments/create";
    */if ($this->data['site_name'] == 'ARF (Apr 2024)')     $url = API_APR2024_ARF_PATH."issue_departments/api_issue_departments/create";
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
    $_GET['start_date'] = '2024-04-01';
    if(!isset($this->data['record'])) $this->data['record'] = array();
    $this->data['site_name']    = (!empty($_GET['site_name']))    ? $_GET['site_name'] : '';
    $this->data['product_name'] = (!empty($_GET['product_name'])) ? $_GET['product_name'] : '';
    $this->data['in_purity']    = (!empty($_GET['in_purity']))    ? $_GET['in_purity'] : '';
    $this->data['account_name'] = (!empty($_GET['account_name'])) ? $_GET['account_name'] : '';
    $this->data['filter_month'] = (!empty($_GET['filter_month'])) ? $_GET['filter_month'] :date('m');
    $this->data['filter_year'] = (!empty($_GET['filter_year'])) ? $_GET['filter_year'] :date('Y');
    $this->data['category_one'] = (!empty($_GET['category_one'])) ? $_GET['category_one'] : '';
    $this->data['group_by']     = (!empty($_GET['group_by']))     ? $_GET['group_by'] : '';
    $this->data['machine_size'] = (!empty($_GET['machine_size'])) ? $_GET['machine_size'] : '';
    $this->data['design_code']  = (!empty($_GET['design_code']))  ? $_GET['design_code'] : '';
    $_GET['filter_month'] = $this->data['filter_month'];
    $_GET['filter_year'] =$this->data['filter_year'];
    
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARF (Apr 2024)') {
      $url = API_APR2024_ARF_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arf_records = json_decode(json_encode($records), true);
    }
//pd();
    if(empty($arf_records['data'])) $arf_records['data'] = array();
    if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC (Apr 2024)') {
      $url = API_APR2024_ARC_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }
      $arg_erp_records=array();
//pd($this->data);


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
}    }
    if (empty($arc_records['data'])) $arc_records['data'] = array();
    $records = array_merge(/*$argold_records['data'],*/ 
                           $arf_records['data'],
                           $arc_records['data'],
                           $arg_erp_records);
    $this->data['production_details'] = $this->get_grouped_records($records);
    $this->get_production_group_total();
  }

  private function get_refresh_details() {
    $select = 'date(created_at) as created_at, item_name,"" as data, GROUP_CONCAT(refresh_id) as refresh_id, GROUP_CONCAT(weight) as refresh_weight, sum(weight) as weight, sum(weight * purity) / sum(weight) as purity, sum(weight * factory_purity) / sum(weight) as factory_purity';
    $where=array();
    $group_by=array('group_by' => 'date(created_at), item_name');
       $site_name=$this->data['site_name'];
        if($this->data['site_name']=="ARG ERP Software"){
        $site_name="AR Gold ERP";
        }
        if($this->data['site_name']=="ARF ERP Software" || $this->data['site_name']=="Arf Erp Software"){
        $site_name="ARF ERP";
        }if($this->data['site_name']=="Rnd Erp Software"){
        $site_name="RND ERP";
        }
        if($this->data['site_name']=="ARC ERP Software" || $this->data['site_name']=="Arc Erp Software"){
        $site_name="ARC ERP";
        }
        if($this->data['site_name']=="Domestic Internal ERP Software"){
        $site_name="Domestic Internal ERP";
        }
        if($this->data['site_name']=="ARNA BANGLE ERP"){
        $site_name="ARNA BANGLE";
        }
    
  
  if(!empty($this->data['site_name'])){
       $where['site_name']    =$site_name;
    }
    if(!empty($this->data['product_name'])){
       $where['item_name']    =$this->data['product_name'];
       $group_by=array('group_by' => 'date(created_at)');
    }

    if(!empty($this->data['in_purity'])){
       $where['factory_purity']    =$this->data['in_purity'];
    }

    if (isset($this->data['filter_month']))
      $where['MONTH(created_at)'] = $this->data['filter_month']; 
    
    if (isset($this->data['filter_year']))
      $where['YEAR(created_at)'] = $this->data['filter_year']; 
    
    
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
    if($this->data['site_name'] == '' || ($this->data['site_name']=="ARC (Apr 2024)" || $this->data['site_name']=="ARF (Apr 2024)" ||$this->data['site_name']=="AR Gold (Apr 2024)" )){
      $domestic_where=array('credit_weight !=' => 0,'receipt_type' => 'Domestic Internal');
        if(!empty($this->data['product_name'])){
         $domestic_where['description']    =$this->data['product_name'];
        // $group_by=array('group_by' => 'date(created_at)');
        }else{
           $domestic_where['description!=']="";
      
       }
       if (isset($this->data['filter_month'])){
        $domestic_where['MONTH(created_at)'] = $this->data['filter_month']; 
       }
      
      if (isset($this->data['filter_year'])){
        $domestic_where['YEAR(created_at)'] = $this->data['filter_year']; 
      }
      if ($this->data['site_name'] == ''){
        $domestic_where['site_name']=array("ARC (Apr 2024)","ARF (Apr 2024)","AR Gold (Apr 2024)");
      }else{
         $domestic_where['site_name']=$site_name;
      }

      $select = 'date(created_at) as created_at, description as item_name,"voucher" as  data , GROUP_CONCAT(id) as refresh_id, GROUP_CONCAT(credit_weight) as refresh_weight, sum(credit_weight) as weight, sum(credit_weight * purity) / sum(credit_weight) as purity, sum(credit_weight * factory_purity) / sum(credit_weight) as factory_purity';
      $voucher_data=$this->voucher_model->get($select, $domestic_where,array(),$group_by);
    }
    if ($this->data['site_name'] == '' || ($this->data['site_name']=="AR Gold ERP" || $this->data['site_name']=="ARG ERP Software" || $this->data['site_name']=="ARF ERP Software"|| $this->data['site_name']=="Arf Erp Software" || $this->data['site_name']=="Rnd Erp Software" || $this->data['site_name']=="ARC ERP Software"|| $this->data['site_name']=="Arc Erp Software"|| $this->data['site_name']=="ARNA BANGLE" || $this->data['site_name']=="ARF ERP" || $this->data['site_name']=="ARC ERP" || $this->data['site_name']=="Domestic Internal ERP" || $this->data['site_name']=="Domestic Internal ERP Software" || $this->data['site_name']=="ARNA BANGLE ERP")) {
      $select = 'date(created_at) as created_at, description as item_name,"voucher" as  data , GROUP_CONCAT(id) as refresh_id, GROUP_CONCAT(credit_weight) as refresh_weight, sum(credit_weight) as weight, sum(credit_weight * purity) / sum(credit_weight) as purity, sum(credit_weight * factory_purity) / sum(credit_weight) as factory_purity';
      $domestic_where=array('credit_weight !=' => 0,'site_name'=>$site_name,'receipt_type' => 'Domestic Internal');
       
      if(!empty($this->data['product_name'])){
          $domestic_where['description']    =$this->data['product_name'];
          //$group_by=array('group_by' => 'date(created_at)');
      }else{
      $domestic_where['description!=']="";
      }
      $voucher_data=$this->voucher_model->get($select,$domestic_where,array(),$group_by);
    }
//lq();pd($voucher_data);
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
