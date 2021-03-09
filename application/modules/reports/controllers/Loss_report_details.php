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

    $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arf_jan2021_records=json_decode(curl_post_request($url,$data));
    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arc_jan2021_records=json_decode(curl_post_request($url,$data));

     foreach ($arg_jan2021_records->data->loss_details->loss_detail as $index => $arg_loss_detail) {
       $where['purity != factory_purity'] = NULL;
       $where['account_name != '] = 'VADOTAR';
       $arg_jan2021_records->data->loss_details->loss_detail->$index->production=0;
       if(!empty($arg_loss_detail->first_date)){
          $where['date(voucher_date) >='] = date('Y-m-d',strtotime($arg_loss_detail->first_date));
       }
       if(!empty($arg_loss_detail->last_date)){
          $where['date(voucher_date) <='] = date('Y-m-d',strtotime($arg_loss_detail->last_date));
        }
        $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
        $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$arg_loss_detail->parent_id));
        $arg_jan2021_records->data->loss_details->loss_detail->$index->production=$product_production['weight'];
        $arg_jan2021_records->data->loss_details->loss_detail->$index->after_recovery=!empty($loss_account_details)?$loss_account_details['weight']:0;
        $arg_jan2021_records->data->loss_details->loss_detail->$index->purity=!empty($loss_account_details)?$loss_account_details['factory_purity']:0;
        $arg_jan2021_records->data->loss_details->loss_detail->$index->fine=!empty($loss_account_details)?$loss_account_details['fine']:0;

     }
     if(!empty($arf_jan2021_records)){
     foreach ($arf_jan2021_records->data->loss_details->loss_detail as $index => $arf_loss_detail) {
       $where['purity != factory_purity'] = NULL;
       $where['account_name != '] = 'VADOTAR';
       $arf_jan2021_records->data->loss_details->loss_detail->$index->production=0;
       if(!empty($arf_loss_detail->first_date)){
          $where['date(voucher_date) >='] = date('Y-m-d',strtotime($arf_loss_detail->first_date));
       }
       if(!empty($arf_loss_detail->last_date)){
          $where['date(voucher_date) <='] = date('Y-m-d',strtotime($arf_loss_detail->last_date));
        }
        $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
        $arf_jan2021_records->data->loss_details->loss_detail->$index->production=$product_production['weight'];
     }}
     if(!empty($arc_jan2021_records)){
     foreach ($arc_jan2021_records->data->loss_details->loss_detail as $index => $arc_loss_detail) {
       $where['purity != factory_purity'] = NULL;
       $where['account_name != '] = 'VADOTAR';
       $arc_jan2021_records->data->loss_details->loss_detail->$index->production=0;
       if(!empty($arc_loss_detail->first_date)){
          $where['date(voucher_date) >='] = date('Y-m-d',strtotime($arc_loss_detail->first_date));
       }
       if(!empty($arc_loss_detail->last_date)){
          $where['date(voucher_date) <='] = date('Y-m-d',strtotime($arc_loss_detail->last_date));
        }
        $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
        $arc_jan2021_records->data->loss_details->loss_detail->$index->production=$product_production['weight'];
     }}
     $this->data['loss_details']=array();
     // if( $this->data['factory_name']=='AR Gold Nov 2020'){
     //  $this->data['loss_details']=!empty($arg_jan2021_records->data->loss_details->loss_detail)? $arg_jan2021_records->data->loss_details->loss_detail:array();
     // }
     if($this->data['factory_name']=='AR Gold'){
      $this->data['loss_details']=!empty($arg_jan2021_records->data->loss_details->loss_detail)? $arg_jan2021_records->data->loss_details->loss_detail:array();
     }
     if($this->data['factory_name']=='ARF'){
      $this->data['loss_details']=!empty($arf_jan2021_records->data->loss_details->loss_detail)? $arf_jan2021_records->data->loss_details->loss_detail:array();
     }
     // if( $this->data['factory_name']=='ARF Nov 2020'){
     //  $this->data['loss_details']=!empty($arf_jan2021_records->data->loss_details->loss_detail)? $arf_jan2021_records->data->loss_details->loss_detail:array();
     // }
     if($this->data['factory_name']=='ARC'){
      $this->data['loss_details']=!empty($arc_jan2021_records->data->loss_details->loss_detail)? $arc_jan2021_records->data->loss_details->loss_detail:array();
     }
    //  if( $this->data['factory_name']=='ARC Nov 2020'){
    //   $this->data['loss_details']=!empty($arc_jan2021_records->data->loss_details->loss_detail)? $arc_jan2021_records->data->loss_details->loss_detail:array();
    // }
  }      
}
