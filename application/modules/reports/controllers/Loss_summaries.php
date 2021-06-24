<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_summaries extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/quator_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model'));
  }

  public function index() { 
    $this->data['quator_name'] = (!empty($_GET['quator'])) ? $_GET['quator'] : '';
    $this->data['quators'] = $this->quator_model->get('name');
    $this->data['quator'] = $this->quator_model->find('*',array('name'=>$this->data['quator_name']));
    if(!empty($this->data['quator'])){
    $arg_loss_records=$this->unrecoverable_loss('ARG');
    $arf_loss_records=$this->unrecoverable_loss('ARF');
    $arc_loss_records=$this->unrecoverable_loss('ARC');
    $this->data['arg_gpc_powder'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"GPC Powder",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arg_total_production'] =0;
    $this->data['arg_gpc_vodator'] = $this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"AR Gold Jan 2021 GPC Vodator",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arg_unrecoverable_loss'] = 0;
    $this->data['arg_final_loss'] = 0;
    $this->data['arg_per_kg_loss'] = 0;
    $this->data['arg_total_loss'] = 0;
    $this->data['arg_without_recovery_per_kg_loss'] = 0;

    $this->data['arf_gpc_powder'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"GPC Powder ARF",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arf_total_production'] =0;
    $this->data['arf_gpc_vodator'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"ARF Jan 2021 GPC Vodator",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arf_unrecoverable_loss'] = 0;
    $this->data['arf_final_loss'] = 0;
    $this->data['arf_per_kg_loss'] = 0;
    $this->data['arf_total_loss'] = 0;
    $this->data['arf_without_recovery_per_kg_loss'] = 0;

    $this->data['arc_gpc_powder'] = $this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"GPC POWDER LOSS ARC",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arc_total_production'] =0;
    $this->data['arc_gpc_vodator'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"ARC Jan 2021 GPC Vodator",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arc_unrecoverable_loss'] = 0;
    $this->data['arc_final_loss'] = 0;
    $this->data['arc_per_kg_loss'] = 0;
    $this->data['arc_total_loss'] = 0;
    $this->data['arc_without_recovery_per_kg_loss'] = 0;
  }
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function unrecoverable_loss($site_name){
    $categories= $this->voucher_model->get('description', array('account_name'=>'Loss Account','date(created_at)>='=>'2021-03-13'),array(),array('group_by'=>'description'));
      $category_names=array_column($categories,'description');
      $data['department_names']=$category_names;
      $data['type']='category';
      $data['quator']='';
      if($site_name=='ARC'){
        $path=API_ARC_JAN2021_PATH;
      }elseif($site_name=='ARF'){
        $path=API_ARF_JAN2021_PATH;
      }else{
        $path=API_ARG_JAN2021_PATH;
      }
      if(!empty($data['department_names'])){
          $url=$path."issue_and_receipts/loss_report_for_accounts/index";
          $factory_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($factory_records)?$factory_records['data']['loss_details']['loss_detail']:$factory_records['data']['loss_details']['loss_detail']=array();
          
      }
      $total_unrecovery_loss=0;
      foreach ($category_names as $index => $category_name) {
        foreach ($records as $key => $value) {
          if(strtolower($value['description'])==$category_name){
            $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$value['parent_id'],'account_name'=>'Unrecovarable'));
            $unrecovery_loss=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
            $total_unrecovery_loss+=$unrecovery_loss;

          }  
        }
      }
      pd($total_unrecovery_loss);
  }
}

