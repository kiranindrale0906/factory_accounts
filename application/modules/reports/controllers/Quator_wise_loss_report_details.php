<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Quator_wise_loss_report_details extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model'));
  }

  public function index() {
    $this->get_loss_details();
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_loss_details() {
    $this->data['factory_name']=!empty($_GET['factory_name'])?$_GET['factory_name']:'';
    $data['department_name']=$_GET['category'];
    $data['quator']=$_GET['quator'];
    $data['completed_at']='2021-11-05';
    $url=API_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arg_records=json_decode(curl_post_request($url,$data),true);
    $ghiss_melting_loss=array();
    $arg_records=!empty($arg_records)?$arg_records['data']['loss_details']['loss_detail']:$arg_records['data']['loss_details']['loss_detail']=array();
    $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'Loss Account','date(created_at)>='=>'2021-03-13','site_name'=>'AR Gold','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
    foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          // $data['quator']=$this->data['quator_name'];
          $url=API_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
           $out_weight=!empty($ghiss_details)&&!empty($ghiss_details['data']['ghiss_melting_out_weights'])?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
    }
    $arg_records=array_merge($arg_records,$ghiss_melting_loss);


    $url=API_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arf_records=json_decode(curl_post_request($url,$data),true);
    $arf_records=!empty($arf_records)?$arf_records['data']['loss_details']['loss_detail']:$arf_records['data']['loss_details']['loss_detail']=array();
    $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'Loss Account','site_name'=>'ARF','date(created_at)>='=>'2021-03-13','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
    foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          // $data['quator']=$this->data['quator_name'];
          $url=API_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
           $out_weight=!empty($ghiss_details)&&!empty($ghiss_details['data']['ghiss_melting_out_weights'])?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
    }
    $arf_records=array_merge($arf_records,$ghiss_melting_loss);

    
    $url=API_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arc_records=json_decode(curl_post_request($url,$data),true);
    $arc_records=!empty($arc_records)?$arc_records['data']['loss_details']['loss_detail']:$arc_records['data']['loss_details']['loss_detail']=array();
    $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight,created_at,created_at as first_date,created_at as last_date', array('account_name'=>'Loss Account','site_name'=>'ARC','date(created_at)>='=>'2021-03-13','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator'],'description'=>$_GET['category']),array());
    foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          // $data['quator']=$this->data['quator_name'];
          $url=API_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
           $out_weight=!empty($ghiss_details)&&!empty($ghiss_details['data']['ghiss_melting_out_weights'])?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
    }
    $arc_records=array_merge($arc_records,$ghiss_melting_loss);

    $arg_records=$this->factory_wise_record_array($arg_records);
    $arf_records=$this->factory_wise_record_array($arf_records);
    $arc_records=$this->factory_wise_record_array($arc_records);
    
    

     $this->data['loss_details']=array();
     if($this->data['factory_name']=='AR Gold'){
      $this->data['loss_details']=!empty($arg_records)? $arg_records:array();
      $this->data['factory_url']=API_ARG_PATH;
     }
     if($this->data['factory_name']=='ARF'){
      $this->data['loss_details']=!empty($arf_records)? $arf_records:array();
      $this->data['factory_url']=API_ARF_PATH;
     }
     if($this->data['factory_name']=='ARC'){
      $this->data['loss_details']=!empty($arc_records)? $arc_records:array();
      $this->data['factory_url']=API_ARC_PATH;
     }
  }

  private function factory_wise_record_array($loss_details){
    $factory_wise_record=array();
      if(!empty($loss_details)){
        $total_production=$total_loss_fine=$recoverd_loss_fine=$all_loss_before_recovery=$unrecovery_loss=$fine_loss=$total_out_weight=$per_kg_loss=$total_per_kg_loss=$before_recovery_loss=$total_before_recovery_loss=$recovered_loss=$total_recovery_loss=$after_recovery_loss=$total_after_recovery_loss=$total_unrecovery_loss=$total_balance=$balance=0;
        foreach ($loss_details as $index => $loss_detail) {
            $factory_wise_record[$index]['production']=0;
            $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$loss_detail['parent_id'],'account_name!='=>'Unrecovarable'.' '.$this->data['factory_name']));
            
            $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$loss_detail['parent_id'],'account_name'=>'Unrecovarable'.' '.$this->data['factory_name']));

            $fine_loss=($loss_detail['in_weight']*$loss_detail['in_lot_purity']/100);
            $after_recovered_loss=($loss_account_details['weight']);
            $recovered_loss=($loss_account_details['fine']);
            $unrecovery_loss=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
            $balance=$fine_loss-$recovered_loss-$unrecovery_loss;
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
}
