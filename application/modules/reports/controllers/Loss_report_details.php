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
    $arg_jan2021_records=json_decode(curl_post_request($url,$data),true);
    $ghiss_melting_loss=array();
    $arg_jan2021_records=!empty($arg_jan2021_records)?$arg_jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
    $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'AR Gold Jan 2021','receipt_type'=>'Ghiss Melting Loss','description'=>$_GET['category']),array());
    $arg_jan2021_records=array_merge($arg_jan2021_records,$ghiss_melting_loss);


    $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arf_jan2021_records=json_decode(curl_post_request($url,$data),true);
    $arf_jan2021_records=!empty($arf_jan2021_records)?$arf_jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
    $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARF Stagin','receipt_type'=>'Ghiss Melting Loss','description'=>$_GET['category']),array());
    $arf_jan2021_records=array_merge($arf_jan2021_records,$ghiss_melting_loss);
    pd($arf_jan2021_records);

    
    $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
    $arc_jan2021_records=json_decode(curl_post_request($url,$data),true);
    $arc_jan2021_records=!empty($arc_jan2021_records)?$arc_jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
    $ghiss_melting_loss=$this->voucher_model->get('receipt_type,description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARC Jan 2021','receipt_type'=>'Ghiss Melting Loss','description'=>$_GET['category']),array());
    $arc_jan2021_records=array_merge($arc_jan2021_records,$ghiss_melting_loss);


    $arg_records=$this->factory_wise_record_array($arg_jan2021_records);
    $arf_records=$this->factory_wise_record_array($arf_jan2021_records);
    $arc_records=$this->factory_wise_record_array($arc_jan2021_records);
    

     $this->data['loss_details']=array();
     if($this->data['factory_name']=='AR Gold'){
      $this->data['loss_details']=!empty($arg_records)? $arg_records:array();
     }
     if($this->data['factory_name']=='ARF'){
      $this->data['loss_details']=!empty($arf_records)? $arf_records:array();
     }
     if($this->data['factory_name']=='ARC'){
      $this->data['loss_details']=!empty($arc_records)? $arc_records:array();
     }
  }

  private function factory_wise_record_array($loss_details){
    $factory_wise_record=array();
    if(!empty($loss_details)){
       foreach ($loss_details as $index => $loss_data) {
        $factory_wise_record[$index]=$loss_data;
         $where['purity != factory_purity'] = NULL;
         $where['account_name != '] = 'VADOTAR';
         $factory_wise_record[$index]['production']=0;
         if(!empty($loss_data['first_date'])){
            $where['date(voucher_date) >='] = date('Y-m-d',strtotime($loss_data['first_date']));
         }
         if(!empty($loss_data['last_date'])){
            $where['date(voucher_date) <='] = date('Y-m-d',strtotime($loss_data['last_date']));
          }
          $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
          $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$loss_data['parent_id'],'account_name!='=>'Unrecovarable'));

          $unrecovery_details= $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$loss_data['parent_id'],'account_name'=>'Unrecovarable'));

          $factory_wise_record[$index]['production']=$product_production['weight'];
          $factory_wise_record[$index]['after_recovery']=!empty($loss_account_details)?$loss_account_details['weight']:0;
          $factory_wise_record[$index]['unrecovery']=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
          $factory_wise_record[$index]['purity']=!empty($loss_account_details)?$loss_account_details['factory_purity']:0;
          $factory_wise_record[$index]['fine']=!empty($loss_account_details)?$loss_account_details['fine']:0;

      }
    }

    return $factory_wise_record;

  }      
}
