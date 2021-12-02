<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quator_wise_loss_reports extends BaseController {
  public function __construct() {
    parent::__construct();
     $this->load->model(array('masters/quator_model','masters/company_model','masters/account_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model','transactions/ledger_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model'));
  }

  public function index() {
    // $this->data['report_type'] = 'Rojmel Report';
    $this->_get_form_data();
    $this->loss_account_details();
    // $this->get_loss_details();
    $this->load->render($this->router->class."/index",$this->data);
  }
  public function loss_account_details(){
    $where=array();
    $quator_details= $this->quator_model->find('name,from_date,to_date,MONTH(from_date) as from_month,MONTH(to_date) as to_month,YEAR(from_date) as from_year,YEAR(to_date) as to_year',array('name'=>$this->data['quator_name']));


    
    $this->data['trial_balance']=array();
    if(!empty($this->data['quator_name'])){
      $export_accounts = $this->account_model->get('name', array('group_code' => 'Export'));
      $export_account_names = array_column($export_accounts, 'name');
      $export_account_names = implode('", "',$export_account_names);
      
      $this->data['work_details']=$this->ledger_model->find('IFNULL(sum(debit_weight),0)
                                                           - IFNULL(sum(credit_weight),0) as amount',
                                                        array('site_name'=>$this->data['site_name'],
                                                          '(purity != factory_purity or (account_name in ("'.$export_account_names.'") and voucher_type = "metal issue voucher"))'=>NULL,
                                                          'account_name != "Vodator"'=>NULL,
                                                          'date(voucher_date) >='=>$quator_details['from_date'],'date(voucher_date) <='=>$quator_details['to_date']));


      $where['where']=array('date(voucher_date) >='=>$quator_details['from_date'],'date(voucher_date) <='=>$quator_details['to_date'],'account_name!='=>'Loss Account');

      $select = "account_name, narration as item_name,
               IFNULL((sum(debit_weight*purity)/100),0) - IFNULL((sum(credit_weight*factory_purity)/100),0) as fine,
               IFNULL(sum((purity-factory_purity)*debit_weight/100),0) - IFNULL(sum((factory_purity-purity)*credit_weight/100),0) as vadotar,
               IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount,
               IFNULL(sum(usd_debit_amount),0) - IFNULL(sum(usd_credit_amount),0) as usd_amount,0 as id";
      $this->data['trial_balance'] = $this->model->get($select,$where, array() , 
                                                      array('group_by'=>'account_name,narration',
                                                            'order_by'=>'receipt_type asc'));
    }
    $loss_account = array('account_name' => 'Loss Account',
                          'fine' => 0, 'vadotar' => 0, 'amount' => 0);
    $this->data['loss_account_records'] = array();
    $loss_account_names=array();
    if($this->data['site_name']=='ARF'){
      $loss_account_names = array('ARF Alloy Vodator','ARF GPC Vodator','ARF Stone Vatav','ARF Copper Vatav','ARF Rhodium Vatav','STONE VATAV ARF', 'TOUNCH LOSS FINE ARF','MEENA LOSS ARF','Gpc Powder ARF','ARF GHISS LOSS','TOUNCH LOSS FINE ARF');
    

    }elseif($this->data['site_name']=='ARC'){
      $loss_account_names = array('ARC Alloy Vodator','ARC GPC Vodator',
                                   'ARC Stone Vatav','ARC Copper Vatav','ARC Rhodium Vatav','Loss Account', 'Tounch & Castic Dep.Loss','Gpc Powder ARC','Tounch Loss Fine ARC','GPC POWDER LOSS ARC');
    

    }elseif($this->data['site_name']=='AR Gold'){
      $loss_account_names = array('AR Gold Alloy Vodator','AR Gold GPC Vodator','AR Gold Stone Vatav','AR Gold Copper Vatav','AR Gold Rhodium Vatav','HCL LOSS','Tounch Loss Fine','GPC Powder','Gpc Powder AR Gold', 'SISMA GHISS LOSS','ARG Stone Loss','SHAMPOO AND STEEL VIBRATOR LOSS/WALNUT SHAMPO', 'ARG GHISS LOSS');
    }

    $loss_account_names =  $this->account_model->get('name', array('group_id' => 3));
    $loss_account_names = array_column($loss_account_names, 'name');
    
    if(!empty($this->data['trial_balance'])){
      $item_name='';
      foreach($this->data['trial_balance'] as $index => $trail_balance_record) {
        if (in_array($trail_balance_record['account_name'], $loss_account_names)) {
          $item_name=$trail_balance_record['account_name'].' Unrecovarable';
          if($trail_balance_record['item_name']==$item_name){
            $loss_account['fine'] += $trail_balance_record['fine'];
            $this->data['loss_account_records'][] = $trail_balance_record;
            unset($this->data['trial_balance'][$index]);
          }
        }
      }
    }
   }
  public function _get_form_data() {
    $this->data['quators'] = $this->quator_model->get('name,from_date,to_date');
    $this->data['quator_name']            = (!empty($_GET['quator'])) ? $_GET['quator'] : '';
    
    $this->data['factory_name']=!empty($_GET['site_name'])?$_GET['site_name']:'AR Gold';
    $this->data['site_name']            = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'All';
    $this->data['account_id']           = (!empty($_GET['account_id'])) ? $_GET['account_id'] : 0;
    
    $this->data['loss_categories']=array();

    $categories= $this->voucher_model->get('trim(description) as description', array('account_name'=>'Loss Account','date(created_at)>='=>'2021-03-13'),array(),array('group_by'=>'description'));

    $loss_details= $this->voucher_model->get('description,fine,id', array('account_name'=>'Loss Account','parent_id'=>0),array());
    $category_names=array_column($categories,'description');
      $data['department_names']=array_unique($category_names);
      $data['type']='category';
      $data['quator']=$this->data['quator_name'];
      if(!empty($data['department_names']) && !empty($this->data['quator_name'])){
        if(isset($_GET['site_name'])&&$_GET['site_name']=='ARC'){
          $ghiss_melting_loss=array();
          $url=API_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);

          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARC','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $arg_records=array_merge($records,$ghiss_melting_loss);

        }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='ARF'){
          $ghiss_melting_loss=array();
          $url=API_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)&&(!empty($jan2021_records['data']['loss_details']))?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();

          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARF','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $arg_records=array_merge($records,$ghiss_melting_loss);

        }else{
          $ghiss_melting_loss=array();
          $url=API_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'AR Gold','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $arg_records=array_merge($records,$ghiss_melting_loss);
          // pd($arg_records);
       // pd($arg_records);
        }

      if(!empty($arg_records)){
        $category_names = array_map( 'strtolower', $category_names );
        foreach ($category_names as $category_name_index => $category_name) {
        $total_production=$total_loss_fine=$recoverd_loss_fine=$all_loss_before_recovery=$unrecovery_loss=$fine_loss=$total_out_weight=$per_kg_loss=$total_per_kg_loss=$before_recovery_loss=$total_before_recovery_loss=$recovered_loss=$total_recovery_loss=$after_recovery_loss=$total_after_recovery_loss=$total_unrecovery_loss=$after_recovered_loss=$total_after_recovered_loss=$total_balance=$balance=0;
          foreach ($arg_records as $index => $arg_loss_detail) {
              if(trim(strtolower($arg_loss_detail['description']))==trim(strtolower($category_name))){
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

