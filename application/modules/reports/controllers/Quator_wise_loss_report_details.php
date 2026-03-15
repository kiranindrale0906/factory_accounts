<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Quator_wise_loss_report_details extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model', 'argold/opening_loss_voucher_model'));
  }

  public function index() {
    $this->get_loss_details();
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_loss_details() {
    ini_set('max_input_vars', '3000');
    ini_set('max_execution_time',0);
    $this->data['factory_name']=!empty($_GET['factory_name'])?$_GET['factory_name']:'';
    $data['department_name']=$_GET['category'];
    $this->data['department_name']=$_GET['category'];
    $data['quator']=$_GET['quator'];
    $this->data['quator']=$_GET['quator'];
    $data['completed_at']='2021-11-05';
     $url=API_APR2024_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
        $arc_apr2024_records=json_decode(curl_post_request($url,$data),true);
        $arc_apr2024_records=!empty($arc_apr2024_records)?$arc_apr2024_records['data']['loss_details']['loss_detail']:$arc_apr2024_records['data']['loss_details']['loss_detail']=array();
        $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'ARC Loss Account (Apr 2024)','site_name'=>'ARC (Apr 2024)','date(created_at)>='=>'2021-03-13','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
        /*foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
              $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
              // $data['quator']=$this->data['quator_name'];
              $url=API_APR2024_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
              $ghiss_details=json_decode(curl_post_request($url,$data),true);
               $out_weight=!empty($ghiss_details)&&!empty($ghiss_details['data']['ghiss_melting_out_weights'])?$ghiss_details['data']['ghiss_melting_out_weights']:0;
              $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
        }*/
         $department_ids = array_column($ghiss_melting_loss, 'parent_id');
          $url = API_APR2024_ARC_PATH . "issue_and_receipts/loss_report_for_accounts/index";
          $data['issue_department_ids'] = $department_ids;
          $data['quator'] = $this->data['quator'];
          $details = json_decode(curl_post_request($url, $data), true);
          $weights = !empty($details['data']['ghiss_melting_out_weights']) ? $details['data']['ghiss_melting_out_weights'] : [];

          // Map out_weights to ghiss_melting_loss
          foreach ($ghiss_melting_loss as $index => $value) {
              $department_id = $value['parent_id'];
              $ghiss_melting_loss[$index]['out_weight'] = isset($weights[$department_id]) ? $weights[$department_id] : 0;
          } 

        $fire_tounch_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'ARC Loss Account (Apr 2024)','site_name'=>'ARC (Apr 2024)','date(created_at)>='=>'2021-03-13','receipt_type'=>'Fire Tounch Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
        /*foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
              $data['issue_department_id']=$fire_tounch_loss_value['parent_id'];
              // $data['quator']=$this->data['quator_name'];
              $url=API_APR2024_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
              $fire_tounch_details=json_decode(curl_post_request($url,$data),true);
               $out_weight=!empty($fire_tounch_details)&&!empty($fire_tounch_details['data']['fire_tounch_out_weights'])?$fire_tounch_details['data']['fire_tounch_out_weights']:0;
              $fire_tounch_loss[$fire_tounch_loss_index]['out_weight']=$out_weight;
        }*/

        $fire_tounch_loss_department_ids = array_column($fire_tounch_loss, 'parent_id');

          $url = API_APR2024_ARC_PATH . "issue_and_receipts/loss_report_for_accounts/index";
          $data['issue_department_id'] = $fire_tounch_loss_department_ids;
          $data['quator'] = $this->data['quator'];
          $details = json_decode(curl_post_request($url, $data), true);
          $fire_tounch_loss_weights = !empty($details['data']['fire_tounch_out_weights']) ? $details['data']['fire_tounch_out_weights'] : [];

          // Map out_weights to ghiss_melting_loss
          foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
              $department_id = $fire_tounch_loss_value['parent_id'];
              $fire_tounch_loss[$fire_tounch_loss_index]['out_weight'] = isset($fire_tounch_loss_weights[$department_id]) ? $fire_tounch_loss_weights[$department_id] : 0;
          }
        
        $opening_loss_records = $this->get_opening_loss();
        $arc_apr2024_records=array_merge($arc_apr2024_records,$ghiss_melting_loss,$opening_loss_records,$fire_tounch_loss);

        $url=API_APR2024_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $arf_apr2024_records=json_decode(curl_post_request($url,$data),true);
          $arf_apr2024_records=!empty($arf_apr2024_records)?$arf_apr2024_records['data']['loss_details']['loss_detail']:$arf_apr2024_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=array();
          $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'ARF Loss Account (Apr 2024)','site_name'=>'ARF (Apr 2024)','date(created_at)>='=>'2021-03-13','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
          $department_ids = array_column($ghiss_melting_loss, 'parent_id');
          $url = API_APR2024_ARF_PATH . "issue_and_receipts/loss_report_for_accounts/index";
          $data['issue_department_id'] = $department_ids;
          $data['quator'] = $this->data['quator'];
          $details = json_decode(curl_post_request($url, $data), true);
          $weights = !empty($details['data']['ghiss_melting_out_weights']) ? $details['data']['ghiss_melting_out_weights'] : [];

          // Map out_weights to ghiss_melting_loss
          foreach ($ghiss_melting_loss as $index => $value) {
              $department_id = $value['parent_id'];
              $ghiss_melting_loss[$index]['out_weight'] = isset($weights[$department_id]) ? $weights[$department_id] : 0;
          }
          /*foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
                $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
                // $data['quator']=$this->data['quator_name'];
                $url=API_APR2024_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
                $ghiss_details=json_decode(curl_post_request($url,$data),true);
                 $out_weight=!empty($ghiss_details)&&!empty($ghiss_details['data']['ghiss_melting_out_weights'])?$ghiss_details['data']['ghiss_melting_out_weights']:0;
                $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }*/
          $fire_tounch_loss=array();
          $fire_tounch_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'ARF Loss Account (Apr 2024)','site_name'=>'ARF (Apr 2024)','date(created_at)>='=>'2021-03-13','receipt_type'=>'Fire Tounch Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
          /*foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
                $data['issue_department_id']=$fire_tounch_loss_value['parent_id'];
                // $data['quator']=$this->data['quator_name'];
                $url=API_APR2024_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
                $fire_tounch_details=json_decode(curl_post_request($url,$data),true);
                 $out_weight=!empty($fire_tounch_details)&&!empty($fire_tounch_details['data']['fire_tounch_out_weights'])?$fire_tounch_details['data']['fire_tounch_out_weights']:0;
                $fire_tounch_loss[$fire_tounch_loss_index]['out_weight']=$out_weight;
          }*/
          $fire_tounch_loss_department_ids = array_column($fire_tounch_loss, 'parent_id');
          $url = API_APR2024_ARF_PATH . "issue_and_receipts/loss_report_for_accounts/index";
          $data['issue_department_id'] = $fire_tounch_loss_department_ids;
          $data['quator'] = $this->data['quator'];
          $details = json_decode(curl_post_request($url, $data), true);
          $fire_tounch_loss_weights = !empty($details['data']['fire_tounch_out_weights']) ? $details['data']['fire_tounch_out_weights'] : [];

          // Map out_weights to ghiss_melting_loss
          foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
              $department_id = $fire_tounch_loss_value['parent_id'];
              $fire_tounch_loss[$fire_tounch_loss_index]['out_weight'] = isset($fire_tounch_loss_weights[$department_id]) ? $fire_tounch_loss_weights[$department_id] : 0;
          }
          
          $opening_loss_records = $this->get_opening_loss();
          $arf_apr2024_records=array_merge($arf_apr2024_records,$ghiss_melting_loss,$opening_loss_records,$fire_tounch_loss);

    $url=API_AUG2024_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $arf_aug2024_records=json_decode(curl_post_request($url,$data),true);
          $arf_aug2024_records=!empty($arf_aug2024_records)?$arf_aug2024_records['data']['loss_details']['loss_detail']:$arf_aug2024_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=array();
          $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'ARF Loss Account (Aug 2024)','site_name'=>'ARF (Aug 2024)','date(created_at)>='=>'2021-03-13','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
          $department_ids = array_column($ghiss_melting_loss, 'parent_id');
          $url = API_AUG2024_ARF_PATH . "issue_and_receipts/loss_report_for_accounts/index";
          $data['issue_department_id'] = $department_ids;
          $data['quator'] = $this->data['quator'];
          $details = json_decode(curl_post_request($url, $data), true);
          $weights = !empty($details['data']['ghiss_melting_out_weights']) ? $details['data']['ghiss_melting_out_weights'] : [];

          // Map out_weights to ghiss_melting_loss
          foreach ($ghiss_melting_loss as $index => $value) {
              $department_id = $value['parent_id'];
              $ghiss_melting_loss[$index]['out_weight'] = isset($weights[$department_id]) ? $weights[$department_id] : 0;
          }
          /*foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
                $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
                // $data['quator']=$this->data['quator_name'];
                $url=API_APR2024_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
                $ghiss_details=json_decode(curl_post_request($url,$data),true);
                 $out_weight=!empty($ghiss_details)&&!empty($ghiss_details['data']['ghiss_melting_out_weights'])?$ghiss_details['data']['ghiss_melting_out_weights']:0;
                $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }*/
          $fire_tounch_loss=array();
          $fire_tounch_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'ARF Loss Account (Aug 2024)','site_name'=>'ARF (Aug 2024)','date(created_at)>='=>'2021-03-13','receipt_type'=>'Fire Tounch Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
          /*foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
                $data['issue_department_id']=$fire_tounch_loss_value['parent_id'];
                // $data['quator']=$this->data['quator_name'];
                $url=API_APR2024_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
                $fire_tounch_details=json_decode(curl_post_request($url,$data),true);
                 $out_weight=!empty($fire_tounch_details)&&!empty($fire_tounch_details['data']['fire_tounch_out_weights'])?$fire_tounch_details['data']['fire_tounch_out_weights']:0;
                $fire_tounch_loss[$fire_tounch_loss_index]['out_weight']=$out_weight;
          }*/
          $fire_tounch_loss_department_ids = array_column($fire_tounch_loss, 'parent_id');
          $url = API_AUG2024_ARF_PATH . "issue_and_receipts/loss_report_for_accounts/index";
          $data['issue_department_id'] = $fire_tounch_loss_department_ids;
          $data['quator'] = $this->data['quator'];
          $details = json_decode(curl_post_request($url, $data), true);
          $fire_tounch_loss_weights = !empty($details['data']['fire_tounch_out_weights']) ? $details['data']['fire_tounch_out_weights'] : [];

          // Map out_weights to ghiss_melting_loss
          foreach ($fire_tounch_loss as $fire_tounch_loss_index => $fire_tounch_loss_value) {
              $department_id = $fire_tounch_loss_value['parent_id'];
              $fire_tounch_loss[$fire_tounch_loss_index]['out_weight'] = isset($fire_tounch_loss_weights[$department_id]) ? $fire_tounch_loss_weights[$department_id] : 0;
          }
          
          $opening_loss_records = $this->get_opening_loss();
          $arf_aug2024_records=array_merge($arf_aug2024_records,$ghiss_melting_loss,$opening_loss_records,$fire_tounch_loss);
    $arc_apr2024_records=$this->factory_wise_record_array($arc_apr2024_records);
    $arf_apr2024_records=$this->factory_wise_record_array($arf_apr2024_records);
    $arf_aug2024_records=$this->factory_wise_record_array($arf_aug2024_records);
    $this->data['loss_details']=array();
     if($this->data['factory_name']=='AR Gold (Apr 2024)'){
       $this->data['loss_details']=!empty($arg_apr2024_records)? $arg_apr2024_records:array();
       $this->data['factory_url']=API_APR2024_ARG_PATH;
      }
     if($this->data['factory_name']=='ARF (Apr 2024)'){
      $this->data['loss_details']=!empty($arf_apr2024_records)? $arf_apr2024_records:array();
      $this->data['factory_url']=API_APR2024_ARF_PATH;
     }if($this->data['factory_name']=='ARF (Aug 2024)'){
      $this->data['loss_details']=!empty($arf_aug2024_records)? $arf_aug2024_records:array();
      $this->data['factory_url']=API_AUG2024_ARF_PATH;
     }if($this->data['factory_name']=='ARC (Apr 2024)'){
      $this->data['loss_details']=!empty($arc_apr2024_records)? $arc_apr2024_records:array();
      $this->data['factory_url']=API_APR2024_ARC_PATH;
     }
  }

  private function factory_wise_record_array($loss_details){
    $factory_wise_record=array();
      if(!empty($loss_details)){
        $total_production=$total_loss_fine=$recoverd_loss_fine=$all_loss_before_recovery=$unrecovery_loss=$fine_loss=$total_out_weight=$per_kg_loss=$total_per_kg_loss=$before_recovery_loss=$total_before_recovery_loss=$recovered_loss=$total_recovery_loss=$after_recovery_loss=$total_after_recovery_loss=$total_unrecovery_loss=$total_balance=$balance=0;
        foreach ($loss_details as $index => $loss_detail) {
            $factory_wise_record[$index]['production']=0;
            $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$loss_detail['parent_id'],'site_name'=>$this->data['factory_name'],'account_name!='=>'Unrecovarable'.' '.$this->data['factory_name']));
            
            $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$loss_detail['parent_id'],'site_name'=>$this->data['factory_name'],'account_name'=>'Unrecovarable'.' '.$this->data['factory_name']));
            $opening_after_recovery=!empty($loss_detail['opening_after_recovery'])?$loss_detail['opening_after_recovery']:0;
            $opening_recovery_fine=!empty($loss_detail['opening_recovery_fine'])?$loss_detail['opening_recovery_fine']:0;
            $opening_unrecoverable=!empty($loss_detail['opening_unrecoverable'])?$loss_detail['opening_unrecoverable']:0;
      
            $fine_loss=($loss_detail['in_weight']*$loss_detail['in_lot_purity']/100);
            $after_recovered_loss=($loss_account_details['weight']+$opening_after_recovery);
//            pd($loss_account_details['weight']);
	    $recovered_loss=($loss_account_details['fine']+$opening_recovery_fine);
            $unrecovery_loss=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
            $unrecoverable_loss=$unrecovery_loss+$opening_unrecoverable;
            $balance=$fine_loss-$recovered_loss-$unrecoverable_loss;
            $factory_wise_record[$index]=$loss_detail;
            $factory_wise_record[$index]['loss_fine']=$fine_loss;
            $factory_wise_record[$index]['after_recovery']=$after_recovered_loss;
            $factory_wise_record[$index]['recoverd_loss_fine']=$recovered_loss;
            $factory_wise_record[$index]['unrecoverable_loss']=$unrecovery_loss;
            $factory_wise_record[$index]['balance']=$balance;
        }
      }

    return $factory_wise_record;

  }      
  private function get_opening_loss() {
    $opening_loss = $this->opening_loss_voucher_model->get('', 
                                                     array('factory_name' => $this->data['factory_name'],
                                                           'quator' => $this->data['quator'],
                                                           'type_of_loss' => $this->data['department_name']));
    $opening_loss_details=array();
    foreach ($opening_loss as $opening_loss_index => $opening_loss_value) {
      $data['issue_department_id'] = $opening_loss_value['id'];
      $data['quator'] = $this->data['quator'];
      $opening_loss_details[$opening_loss_index]['in_weight'] = $opening_loss_value['loss'];
      $opening_loss_details[$opening_loss_index]['in_lot_purity'] = $opening_loss_value['purity'];
      $opening_loss_details[$opening_loss_index]['out_weight'] = $opening_loss_value['out_weight'];
      $opening_loss_details[$opening_loss_index]['description'] = $opening_loss_value['type_of_loss'];
      $opening_loss_details[$opening_loss_index]['parent_id'] = $opening_loss_value['id'];
      $opening_loss_details[$opening_loss_index]['id'] = $opening_loss_value['id'];
      $opening_loss_details[$opening_loss_index]['created_at'] = $opening_loss_value['created_at'];
      $opening_loss_details[$opening_loss_index]['first_date'] = $opening_loss_value['created_at'];
      $opening_loss_details[$opening_loss_index]['last_date'] = $opening_loss_value['created_at'];
      $opening_loss_details[$opening_loss_index]['receipt_type'] = "Opening Loss";
      $opening_loss_details[$opening_loss_index]['opening_after_recovery'] = $opening_loss_value['after_recovered'];
      $opening_loss_details[$opening_loss_index]['opening_unrecoverable'] = $opening_loss_value['unrecovered_loss'];
      $opening_loss_details[$opening_loss_index]['opening_recovery_fine'] = $opening_loss_value['recovered_loss'];
      
      $opening_loss_details[$opening_loss_index]['quator'] = $opening_loss_value['quator'];

    }
    return $opening_loss_details;
  }
}
