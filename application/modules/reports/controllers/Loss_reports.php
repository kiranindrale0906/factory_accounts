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
    $categories= $this->voucher_model->get('description', array('account_name'=>'Loss Account','parent_id'=>0,'date(created_at)>='=>'2021-03-13'),array(),array('group_by'=>'description'));
    $loss_details= $this->voucher_model->get('description,fine,id', array('account_name'=>'Loss Account','parent_id'=>0),array());
    $category_names=array_column($categories,'description');
     foreach ($category_names as $category_name_index => $category_name_value) {
      $data['department_name']=$category_name_value;
      if(isset($_GET['site_name'])&&$_GET['site_name']=='ARC'){
        $ghiss_melting_loss=array();
        $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
        $jan2021_records=json_decode(curl_post_request($url,$data),true);

        $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
        $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARC Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
        $arg_jan2021_records=array_merge($records,$ghiss_melting_loss);

      }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='ARF'){
        $ghiss_melting_loss=array();
        $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
        $jan2021_records=json_decode(curl_post_request($url,$data),true);
        $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
        
        $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARF Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
        $arg_jan2021_records=array_merge($records,$ghiss_melting_loss);

      }else{
        $ghiss_melting_loss=array();
        $url=API_ARG_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
        $jan2021_records=json_decode(curl_post_request($url,$data),true);
        $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
         $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'AR Gold Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
        
        $arg_jan2021_records=array_merge($records,$ghiss_melting_loss);
      }
      if(!empty($arg_jan2021_records)){
        $total_production=$total_loss_fine=$recoverd_loss_fine=$all_loss_before_recovery=$unrecovery_loss=$total_product_production=0;
        foreach ($arg_jan2021_records as $index => $arg_loss_detail) {
          if($category_name_value==$arg_loss_detail['description']){
            $factory_wise_record[$index]['production']=0;
            $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name!='=>'Unrecovarable'));
            
            $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name'=>'Unrecovarable'));
         
            $total_production+=$arg_loss_detail['out_weight'];
            $unrecovery_loss+=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
            $total_loss_fine+=($arg_loss_detail['in_weight']*$arg_loss_detail['in_lot_purity']/100);
            $all_loss_before_recovery+=!empty($arg_loss_detail['out_weight'])?(($arg_loss_detail['in_weight']*$arg_loss_detail['in_lot_purity']/100)/$arg_loss_detail['out_weight']*1000):0;
            $recoverd_loss_fine+=($arg_loss_detail['in_weight']*$arg_loss_detail['in_lot_purity']/100)-$loss_account_details['fine']-$unrecovery_details['weight'];
            // $total_product_production+=$product_production['weight'];
            // $where['purity != factory_purity'] = NULL;
            // $where['account_name != '] = 'VADOTAR';
            // $where['(year(voucher_date)- month(voucher_date)) <']=date("Y-m");

          // $product_production= $this->ledger_model->find('-1*sum(credit_weight-debit_weight) as weight',$where);
          $this->data['loss_categories'][$category_name_value]['out_weight']=$total_production;
          $this->data['loss_categories'][$category_name_value]['overall_loss_fine']=$total_loss_fine;
          $this->data['loss_categories'][$category_name_value]['recoverd_loss_fine']=$recoverd_loss_fine;
          $this->data['loss_categories'][$category_name_value]['all_loss_before_recovery']=($all_loss_before_recovery);
          $this->data['loss_categories'][$category_name_value]['unrecovery_loss']=($unrecovery_loss);
          $this->data['loss_categories'][$category_name_value]['all_loss_after_recovery']=!empty($total_production)?($total_loss_fine/$total_production*1000):0;
          }
        }
      }
    }
  }
      
}

