<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loss_summaries extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/quator_model','masters/company_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model', 
                             'ac_vouchers/voucher_model','transactions/ledger_model', 'argold/chitti_model'));
  }

  public function index() { 
    $this->data['quator_name'] = (!empty($_GET['quator'])) ? $_GET['quator'] : '';
    $this->data['quators'] = $this->quator_model->get('name');
    $this->data['quator'] = $this->quator_model->find('*',array('name'=>$this->data['quator_name']));
    if(!empty($this->data['quator'])){
    $arg_loss_records=$this->loss_details('ARG',$this->data['quator']['from_date'],$this->data['quator']['to_date']);
    $arf_loss_records=$this->loss_details('ARF',$this->data['quator']['from_date'],$this->data['quator']['to_date']);
    $arc_loss_records=$this->loss_details('ARC',$this->data['quator']['from_date'],$this->data['quator']['to_date']);
    $accounts_balance_select = 'sum(debit_weight)-sum(credit_weight) as balance,date_format(voucher_date,"%Y-%m") as voucher_date';

    $argold_vodator = $this->ledger_model->get($accounts_balance_select, array('site_name = "AR Gold Jan 2021"' => NULL,'purity != factory_purity'=>NULL,'account_name != "VADOTAR"'=> NULL,'date(voucher_date)>='=>$this->data['quator']['from_date'],'date(voucher_date)<='=>$this->data['quator']['to_date']),array(),array('group_by'=>'date_format(voucher_date,"%Y-%m")'));

    $arf_vodator = $this->ledger_model->get($accounts_balance_select, array('site_name` = "ARF Jan 2021"' => NULL,'purity != factory_purity'=>NULL,'account_name != "VADOTAR"'=> NULL,'date(voucher_date)>='=>$this->data['quator']['from_date'],'date(voucher_date)<='=>$this->data['quator']['to_date']),array(),array('group_by'=>'date_format(voucher_date,"%Y-%m")'));

    $arc_vodator = $this->ledger_model->get($accounts_balance_select, array('site_name = "ARC Jan 2021"' => NULL,'purity != factory_purity'=>NULL,'account_name != "VADOTAR"'=> NULL,'date(voucher_date)>='=>$this->data['quator']['from_date'],'date(voucher_date)<='=>$this->data['quator']['to_date']),array(),array('group_by'=>'date_format(voucher_date,"%Y-%m")'));
    $argold_date=array_column($argold_vodator,'voucher_date');
    $arf_date=array_column($arf_vodator,'voucher_date');
    $arc_date=array_column($arc_vodator,'voucher_date');
    $moth_record=array_unique(array_merge($argold_date,$arf_date,$arc_date));

    $argold_total_production=end($argold_vodator);
    $arf_total_production=end($arf_vodator);
    $arc_total_production=end($arc_vodator);

    $this->data['argold_production_report']=$argold_vodator;
    $this->data['arf_production_report']=$arf_vodator;
    $this->data['arc_production_report']=$arc_vodator;
    $this->data['moth_record']=$moth_record;

    $this->data['arg_gpc_powder'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"GPC Powder",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arg_total_production'] =!empty($argold_total_production)?$argold_total_production['balance']:0;
    $this->data['arg_gpc_vodator'] = $this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"AR Gold Jan 2021 GPC Vodator",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arg_unrecoverable_loss'] =!empty($arg_loss_records['unrecovery_loss'])?$arg_loss_records['unrecovery_loss']:0;
    $this->data['arg_final_loss'] = 0;
    $this->data['arg_per_kg_loss'] = 0;
    $this->data['arg_total_loss'] =!empty($arg_loss_records['fine_loss'])?$arg_loss_records['fine_loss']:0;;
    $this->data['arg_without_recovery_per_kg_loss'] = 0;

    $this->data['arf_gpc_powder'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"GPC Powder ARF",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arf_total_production'] =!empty($arf_total_production)?$arf_total_production['balance']:0;
    $this->data['arf_gpc_vodator'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"ARF Jan 2021 GPC Vodator",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arf_unrecoverable_loss'] =!empty($arf_loss_records['unrecovery_loss'])?$arf_loss_records['unrecovery_loss']:0;;
    $this->data['arf_final_loss'] = 0;
    $this->data['arf_per_kg_loss'] = 0;
    $this->data['arf_total_loss'] =!empty($arf_loss_records['fine_loss'])?$arf_loss_records['fine_loss']:0;
    $this->data['arf_without_recovery_per_kg_loss'] = 0;

    $this->data['arc_gpc_powder'] = $this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"GPC POWDER LOSS ARC",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arc_total_production'] =!empty($arc_total_production)?$arc_total_production['balance']:0;
    $this->data['arc_gpc_vodator'] =$this->voucher_model->find('
                                                sum(debit_weight-credit_weight) as amount',
                                              array('account_name'=>"ARC Jan 2021 GPC Vodator",
                                              'date(voucher_date)>='=>$this->data['quator']['from_date'],
                                              'date(voucher_date)<='=>$this->data['quator']['to_date']))['amount'];
    $this->data['arc_unrecoverable_loss'] =!empty($arc_loss_records['unrecovery_loss'])?$arc_loss_records['unrecovery_loss']:0;;
    $this->data['arc_final_loss'] = 0;
    $this->data['arc_per_kg_loss'] = 0;
    $this->data['arc_total_loss']=!empty($arc_loss_records['fine_loss'])?$arc_loss_records['fine_loss']:0;
    $this->data['arc_without_recovery_per_kg_loss'] = 0;
  }
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function loss_details($site_name,$from_date,$to_date){
    $categories= $this->voucher_model->get('description', array('account_name'=>'Loss Account','date(created_at)>='=>'2021-03-13'),array(),array('group_by'=>'description'));
      $category_names=array_column($categories,'description');
      $data['department_names']=$category_names;
      $data['type']='category';
      $data['quator']='';
      if($site_name=='ARC'){
        $path=API_ARC_JAN2021_PATH;
        $factory_name='ARC Jan 2021';
      }elseif($site_name=='ARF'){
        $path=API_ARF_JAN2021_PATH;
        $factory_name='AR Gold Jan 2021';
      }else{
        $path=API_ARG_JAN2021_PATH;
        $factory_name='ARF Jan 2021';
      }
      if(!empty($data['department_names'])){
          $url=$path."issue_and_receipts/loss_report_for_accounts/index";
          $factory_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($factory_records)?$factory_records['data']['loss_details']['loss_detail']:$factory_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>$factory_name,'receipt_type'=>'Ghiss Melting Loss'),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
            $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
            $url=$path."issue_and_receipts/loss_report_for_accounts/index";
            $ghiss_details=json_decode(curl_post_request($url,$data),true);
            $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
            $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $records=array_merge($records,$ghiss_melting_loss);
      }
      $total_unrecovery_loss=$total_fine=0;
      foreach ($category_names as $index => $category_name) {
        $fine_loss=$unrecovery_loss=0;
        foreach ($records as $key => $value) {
          if(strtolower($value['description'])==strtolower($category_name)){
            $fine_loss=($value['in_weight']*$value['in_lot_purity']/100);
            $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$value['parent_id'],'account_name'=>'Unrecovarable','date(voucher_date)>='=>$from_date,'date(voucher_date)<='=>$to_date));
            $unrecovery_loss=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
            $total_unrecovery_loss+=$unrecovery_loss;
            $total_fine+=four_decimal($fine_loss);
          }  
        }
      }
      $data['fine_loss']=$total_fine;
      $data['unrecovery_loss']=$total_unrecovery_loss;
      return $data;
  }
}

