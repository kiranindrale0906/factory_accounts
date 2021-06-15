<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_wise_loss_reports extends BaseController {
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

    $this->data['factory_name']=!empty($_GET['site_name'])?$_GET['site_name']:'AR Gold';
    $this->data['site_name']            = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'All';
    $this->data['account_id']           = (!empty($_GET['account_id'])) ? $_GET['account_id'] : 0;
    
    $this->data['loss_categories']=array();
    $categories= $this->voucher_model->get('description', array('account_name'=>'Loss Account','date(created_at)>='=>'2021-03-13'),array(),array('group_by'=>'description'));

    $loss_details= $this->voucher_model->get('description,fine,id', array('account_name'=>'Loss Account','parent_id'=>0),array());
    $category_names=array_column($categories,'description');
    $category_names=array('Bengali Loss','Buffing Loss','Hammering Loss','Machine Room Loss','Melting Loss','Office Loss','Outside Ball Making Loss','Pasta Loss','Shampoo And Steel Loss','Sisma Machine Room',
      'Solder','Tarpatta And Flatting Loss','Walnut Loss','Walnut Shampoo Loss','Ghiss Melting Loss-Sisma Machine','Castic Loss','Stamping Loss');
      $data['department_names']=$category_names;
      $data['type']='category';
      $data['quator']='';
      if(!empty($data['department_names'])){
        if(isset($_GET['site_name'])&&$_GET['site_name']=='ARC'){
          $ghiss_melting_loss=array();
          $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);

          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARC Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
          $ghiss_melting_loss_ids=array_column($ghiss_melting_loss,'parent_id');
          $url=API_ARC_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$ghiss_melting_loss_ids),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          $arg_jan2021_records=array_merge($records,$ghiss_melting_loss);

        }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='ARF'){
          $ghiss_melting_loss=array();
          $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();

          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARF Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $url=API_ARF_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $arg_jan2021_records=array_merge($records,$ghiss_melting_loss);

        }else{
          $ghiss_melting_loss=array();
          $url=API_ARG_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'AR Gold Jan 2021','receipt_type'=>'Ghiss Melting Loss'),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $url=API_ARG_JAN2021_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $arg_jan2021_records=array_merge($records,$ghiss_melting_loss);
          // pd($arg_jan2021_records);
       // pd($arg_jan2021_records);
        }
      if(!empty($arg_jan2021_records)){
        $category_names = array_map( 'strtolower', $category_names );
        foreach ($category_names as $category_name_index => $category_name) {
        $total_production=$total_loss_fine=$recoverd_loss_fine=$all_loss_before_recovery=$unrecovery_loss=$fine_loss=$total_out_weight=$per_kg_loss=$total_per_kg_loss=$before_recovery_loss=$total_before_recovery_loss=$recovered_loss=$total_recovery_loss=$after_recovery_loss=$total_after_recovery_loss=$total_unrecovery_loss=$after_recovered_loss=$total_after_recovered_loss=$total_balance=$balance=0;
          foreach ($arg_jan2021_records as $index => $arg_loss_detail) {
              if(strtolower($arg_loss_detail['description'])==$category_name){
                $factory_wise_record[$index]['production']=0;
                $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name!='=>'Unrecovarable'));
                
                $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name'=>'Unrecovarable'));

                $fine_loss=($arg_loss_detail['in_weight']*$arg_loss_detail['in_lot_purity']/100);
                $recovered_loss=($loss_account_details['fine']);
                $after_recovered_loss=($loss_account_details['weight']);
                $unrecovery_loss=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
                $balance=$fine_loss-$recovered_loss-$unrecovery_loss;
             
                $total_out_weight+=$arg_loss_detail['out_weight'];
                $total_loss_fine+=$fine_loss;
                $total_recovery_loss+=$recovered_loss;
                $total_after_recovered_loss+=$after_recovered_loss;
                $total_unrecovery_loss+=$unrecovery_loss;
                $total_balance+=$balance;

                $this->data['loss_categories'][$arg_loss_detail['description']]['loss_fine']=$total_loss_fine;
                $this->data['loss_categories'][$arg_loss_detail['description']]['out_weight']=$total_out_weight;
                $this->data['loss_categories'][$arg_loss_detail['description']]['recoverd_loss_fine']=$total_recovery_loss;
                $this->data['loss_categories'][$arg_loss_detail['description']]['after_recovered_loss']=$total_after_recovered_loss;
                $this->data['loss_categories'][$arg_loss_detail['description']]['unrecoverable_loss']=$total_unrecovery_loss;
                $this->data['loss_categories'][$arg_loss_detail['description']]['balance']=$total_balance;
              }
          }
        }
      }
    }
  }  
}

