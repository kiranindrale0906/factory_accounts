<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_reports extends BaseController {
  public function __construct() {
    parent::__construct();
     $this->load->model(array('masters/account_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model'));
  }

  public function index() {
    $this->data['report_type'] = 'Rojmel Report';
    $this->_get_form_data();
    // $this->get_loss_details();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function _get_form_data() {
     $this->data['factory_name']=!empty($_GET['site_name'])?$_GET['site_name']:'';
    $this->data['site_name']            = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'All';
    $this->data['account_id']           = (!empty($_GET['account_id'])) ? $_GET['account_id'] : 0;
    
    $this->data['loss_categories']=array();
    $categories= $this->voucher_model->get('description', array('account_name'=>'Loss Account','parent_id'=>0),array(),array('group_by'=>'description'));
    $loss_details= $this->voucher_model->get('description,fine,id', array('account_name'=>'Loss Account','parent_id'=>0),array());
    $category_names=array_column($categories,'description');

    foreach ($category_names as $category_name_index => $category_name_value) {
      $data['department_name']=$category_name_value;
      if(isset($_GET['site_name'])&&$_GET['site_name']=='ARC'){
        $ghiss_melting_loss=array();
        $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
        $jan2021_records=json_decode(curl_post_request($url,$data),true);
        $jan2021_records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
        $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARC Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
        $arg_jan2021_records=array_merge($jan2021_records,$ghiss_melting_loss);

      }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='ARF'){
        $ghiss_melting_loss=array();
        $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
        $jan2021_records=json_decode(curl_post_request($url,$data),true);
        $jan2021_records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
        
        $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARF Stagin','receipt_type'=>'Ghiss Melting Loss'),array());
        // pd($jan2021_records);
        $arg_jan2021_records=array_merge($jan2021_records,$ghiss_melting_loss);

      }else{
        $ghiss_melting_loss=array();
        $url=API_ARG_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
        $jan2021_records=json_decode(curl_post_request($url,$data),true);
        $jan2021_records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
         $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'AR Gold Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
        $arg_jan2021_records=array_merge($jan2021_records,$ghiss_melting_loss);
      }
      if(!empty($arg_jan2021_records)){
      $total_production=$total_loss_fine=$total_product_production=0;
        foreach ($arg_jan2021_records as $index => $arg_loss_detail) {
          if($category_name_value==$arg_loss_detail['description']){

           $where['purity != factory_purity'] = NULL;
           $where['account_name != '] = 'VADOTAR';
           $factory_wise_record[$index]['production']=0;
           $where['(year(voucher_date)- month(voucher_date)) <']=date("Y-m");
          $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
          $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name!='=>'Unrecovarable'));
          $unrecovery_details= $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name'=>'Unrecovarable'));
          $total_production+=$arg_loss_detail['out_weight'];
          $total_product_production+=$product_production['weight'];
          $total_loss_fine+=($arg_loss_detail['in_weight']*$arg_loss_detail['in_lot_purity']/100);//-$loss_account_details['weight']-$unrecovery_details['weight'];
          $this->data['loss_categories'][$category_name_value]['melting_production']=$total_production;
          $this->data['loss_categories'][$category_name_value]['overall_loss_fine']=$total_loss_fine;
          $this->data['loss_categories'][$category_name_value]['product_production']=$total_product_production;
          $this->data['loss_categories'][$category_name_value]['all_loss_after_recovery']=!empty($total_production)?($total_loss_fine/$total_production*1000):0;
          }
        }
      }
    }
    // if(!empty($loss_details)){
    //   foreach ($categories as $category_index => $category) {
    //     $total_fine=0;
    //     foreach ($loss_details as $index => $loss_detail) {
    //       if($loss_detail['description']==$category['description']){
    //       $receipt_data= $this->voucher_model->find('sum(fine) as fine', array('parent_id'=>$loss_detail['id']));
    //       $total_fine+=$loss_detail['fine']-$receipt_data['fine'];

    //       }
    //       $this->data['loss_categories'][$category['description']]['fine']=$total_fine;
    //     }
    //   }
    // }
    // parent::create();
  }
  // private function get_loss_details() {
  //   // $this->data['factory_name']=!empty($_GET['factory_name'])?$_GET['factory_name']:'';
  //   // $data['department_name']=$_GET['category'];
  //   // $url=API_ARG_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
  //   // $arg_jan2021_records=json_decode(curl_post_request($url,$data));

  //   // $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
  //   // $arf_jan2021_records=json_decode(curl_post_request($url,$data));
    
  //   // $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
  //   // $arc_jan2021_records=json_decode(curl_post_request($url,$data));

  //    foreach ($arg_jan2021_records->data->loss_details->loss_detail as $index => $arg_loss_detail) {
  //      $where['purity != factory_purity'] = NULL;
  //      $where['account_name != '] = 'VADOTAR';
  //      $arg_jan2021_records->data->loss_details->loss_detail->$index->production=0;
  //      if(!empty($arg_loss_detail->first_date)){
  //         $where['date(voucher_date) >='] = date('Y-m-d',strtotime($arg_loss_detail->first_date));
  //      }
  //      if(!empty($arg_loss_detail->last_date)){
  //         $where['date(voucher_date) <='] = date('Y-m-d',strtotime($arg_loss_detail->last_date));
  //       }
  //       $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
  //       $arg_jan2021_records->data->loss_details->loss_detail->$index->production=$product_production['weight'];
  //    }
  //    // if(!empty($arf_jan2021_records)){
  //    // foreach ($arf_jan2021_records->data->loss_details->loss_detail as $index => $arf_loss_detail) {
  //    //   $where['purity != factory_purity'] = NULL;
  //    //   $where['account_name != '] = 'VADOTAR';
  //    //   $arf_jan2021_records->data->loss_details->loss_detail->$index->production=0;
  //    //   if(!empty($arf_loss_detail->first_date)){
  //    //      $where['date(voucher_date) >='] = date('Y-m-d',strtotime($arf_loss_detail->first_date));
  //    //   }
  //    //   if(!empty($arf_loss_detail->last_date)){
  //    //      $where['date(voucher_date) <='] = date('Y-m-d',strtotime($arf_loss_detail->last_date));
  //    //    }
  //    //    $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
  //    //    $arf_jan2021_records->data->loss_details->loss_detail->$index->production=$product_production['weight'];
  //    // }}
  //    // if(!empty($arc_jan2021_records)){
  //    // foreach ($arc_jan2021_records->data->loss_details->loss_detail as $index => $arc_loss_detail) {
  //    //   $where['purity != factory_purity'] = NULL;
  //    //   $where['account_name != '] = 'VADOTAR';
  //    //   $arc_jan2021_records->data->loss_details->loss_detail->$index->production=0;
  //    //   if(!empty($arc_loss_detail->first_date)){
  //    //      $where['date(voucher_date) >='] = date('Y-m-d',strtotime($arc_loss_detail->first_date));
  //    //   }
  //    //   if(!empty($arc_loss_detail->last_date)){
  //    //      $where['date(voucher_date) <='] = date('Y-m-d',strtotime($arc_loss_detail->last_date));
  //    //    }
  //    //    $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
  //    //    $arc_jan2021_records->data->loss_details->loss_detail->$index->production=$product_production['weight'];
  //    // }}
  //    $this->data['loss_details']=array();
  //    // if( $this->data['factory_name']=='AR Gold Nov 2020'){
  //    //  $this->data['loss_details']=!empty($arg_jan2021_records->data->loss_details->loss_detail)? $arg_jan2021_records->data->loss_details->loss_detail:array();
  //    // }
  //    if($this->data['factory_name']=='AR Gold'){
  //     $this->data['loss_details']=!empty($arg_jan2021_records->data->loss_details->loss_detail)? $arg_jan2021_records->data->loss_details->loss_detail:array();
  //    }
  //    if($this->data['factory_name']=='ARF'){
  //     $this->data['loss_details']=!empty($arf_jan2021_records->data->loss_details->loss_detail)? $arf_jan2021_records->data->loss_details->loss_detail:array();
  //    }
  //    // if( $this->data['factory_name']=='ARF Nov 2020'){
  //    //  $this->data['loss_details']=!empty($arf_jan2021_records->data->loss_details->loss_detail)? $arf_jan2021_records->data->loss_details->loss_detail:array();
  //    // }
  //    if($this->data['factory_name']=='ARC'){
  //     $this->data['loss_details']=!empty($arc_jan2021_records->data->loss_details->loss_detail)? $arc_jan2021_records->data->loss_details->loss_detail:array();
  //    }
  //   //  if( $this->data['factory_name']=='ARC Nov 2020'){
  //   //   $this->data['loss_details']=!empty($arc_jan2021_records->data->loss_details->loss_detail)? $arc_jan2021_records->data->loss_details->loss_detail:array();
  //   // }
  // }      
}

