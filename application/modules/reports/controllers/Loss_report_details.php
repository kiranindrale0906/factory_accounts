<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Loss_report_details extends Ledgers {

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
    $url=API_ARG_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arg_jan2021_records=json_decode(curl_post_request($url,$data));
    pd($result = array_values($arg_jan2021_records);

    $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arf_jan2021_records=json_decode(curl_post_request($url,$data));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arc_jan2021_records=json_decode(curl_post_request($url,$data));

    $arg_records=$this->factory_wise_record_array($arg_jan2021_records);
    $arf_records=$this->factory_wise_record_array($arf_jan2021_records);
    $arc_records=$this->factory_wise_record_array($arc_jan2021_records);

     $this->data['loss_details']=array();
     if($this->data['factory_name']=='AR Gold'){
      $this->data['loss_details']=!empty($arg_records->data->loss_details->loss_detail)? $arg_records->data->loss_details->loss_detail:array();
     }
     if($this->data['factory_name']=='ARF'){
      $this->data['loss_details']=!empty($arf_records->data->loss_details->loss_detail)? $arf_records->data->loss_details->loss_detail:array();
     }
     if($this->data['factory_name']=='ARC'){
      $this->data['loss_details']=!empty($arc_records->data->loss_details->loss_detail)? $arc_records->data->loss_details->loss_detail:array();
     }
  }

  private function factory_wise_record_array($records){

    if(!empty($records)){
       foreach ($records->data->loss_details->loss_detail as $index => $loss_detail) {
         $where['purity != factory_purity'] = NULL;
         $where['account_name != '] = 'VADOTAR';
         $records->data->loss_details->loss_detail->$index->production=0;
         if(!empty($loss_detail->first_date)){
            $where['date(voucher_date) >='] = date('Y-m-d',strtotime($loss_detail->first_date));
         }
         if(!empty($loss_detail->last_date)){
            $where['date(voucher_date) <='] = date('Y-m-d',strtotime($loss_detail->last_date));
          }
          $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
          $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$loss_detail->parent_id,'account_name!='=>'Unrecovarable'));
          $unrecovery_details= $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$loss_detail->parent_id,'account_name'=>'Unrecovarable'));
          $records->data->loss_details->loss_detail->$index->production=$product_production['weight'];
          $records->data->loss_details->loss_detail->$index->after_recovery=!empty($loss_account_details)?$loss_account_details['weight']:0;
          $records->data->loss_details->loss_detail->$index->unrecovery=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
          $records->data->loss_details->loss_detail->$index->purity=!empty($loss_account_details)?$loss_account_details['factory_purity']:0;
          $records->data->loss_details->loss_detail->$index->fine=!empty($loss_account_details)?$loss_account_details['fine']:0;

      }
    }

    return $records;

  }      
}
