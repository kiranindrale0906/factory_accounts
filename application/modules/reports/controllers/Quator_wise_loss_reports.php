<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quator_wise_loss_reports extends BaseController {
  public function __construct() {
    parent::__construct();
     $this->load->model(array('masters/quator_model','masters/company_model','masters/account_model', 'transactions/ledger_model',
                             'transactions/metal_receipt_voucher_model', 'transactions/metal_issue_voucher_model','transactions/ledger_model','argold/refresh_detail_model', 
                             'ac_vouchers/voucher_model', 'argold/chitti_model','argold/opening_loss_voucher_model'));
  }

  public function index() {
    // $this->data['report_type'] = 'Rojmel Report';
    $this->_get_form_data();
    $this->loss_account_details();
    $this->get_production_summary();
    $this->get_refresh_details();
    if(!empty($this->data['quator_name'])&&$this->data['site_name']=='ARC'){
    $quator_details= $this->quator_model->find('name,from_date,to_date,MONTH(from_date) as from_month,MONTH(to_date) as to_month,YEAR(from_date) as from_year,YEAR(to_date) as to_year',array('name'=>$this->data['quator_name']));
	if(!empty($this->data['production_total'][$quator_details['from_year'].'-'.$quator_details['from_month']]) || !empty($this->data['production_total'][$quator_details['from_year'].'-'.$quator_details['from_month']])){
    $this->data['work_arc']=four_decimal($this->data['production_total'][$quator_details['from_year'].'-'.$quator_details['from_month']]['weight']-$this->data['refresh_total'][$quator_details['from_year'].'-'.$quator_details['from_month']]['weight']);
    }}
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

    // $loss_account = array('account_name' => 'Loss Account',
    //                       'fine' => 0, 'vadotar' => 0, 'amount' => 0);
    // $this->data['loss_account_records'] = array();
    // $loss_account_names=array();
    // $loss_account_where=array('group_id'=>3);
    // if($this->data['site_name']=='ARF (May 2022)'){
    //   $loss_account_where['unrecoverable_account_name']='Unrecovarable ARF (May 2022)';
    // }elseif($this->data['site_name']=='ARC (May 2022)'){
    //   $loss_account_where['unrecoverable_account_name']='Unrecovarable ARC (May 2022)';
    // }elseif($this->data['site_name']=='AR Gold (May 2022)'){
    //   $loss_account_where['unrecoverable_account_name']='Unrecovarable AR Gold (May 2022)';
    // }elseif($this->data['site_name']=='ARF (Aug 2022)'){
    //   $loss_account_where['unrecoverable_account_name']='Unrecovarable ARF (Aug 2022)';
    // }elseif($this->data['site_name']=='ARC (Aug 2022)'){
    //   $loss_account_where['unrecoverable_account_name']='Unrecovarable ARC (Aug 2022)';
    // }elseif($this->data['site_name']=='AR Gold (Aug 2022)'){
    //   $loss_account_where['unrecoverable_account_name']='Unrecovarable AR Gold (Aug 2022)';
    // }
    // $loss_account_names =  $this->account_model->get('name',$loss_account_where);

    // $loss_account_names = array_column($loss_account_names, 'name');
    // if(!empty($this->data['trial_balance'])){
    //   $item_name='';
    //   $item_name_with_factory='';
    //   foreach($this->data['trial_balance'] as $index => $trail_balance_record) {
    //     if (in_array($trail_balance_record['account_name'], $loss_account_names)) {
    //       $unrecoverable_loss_account=$this->account_model->find('unrecoverable_account_name',array('name'=>$trail_balance_record['account_name']));
    //       $item_name=$trail_balance_record['account_name'].' Unrecovarable';
    //       $item_name_with_factory=$trail_balance_record['account_name'].' '.$unrecoverable_loss_account['unrecoverable_account_name'];
    //       if($trail_balance_record['item_name']==$item_name || $trail_balance_record['item_name']==$item_name_with_factory){
    //         $loss_account['fine'] += $trail_balance_record['fine'];
    //         $this->data['loss_account_records'][] = $trail_balance_record;
    //         unset($this->data['trial_balance'][$index]);
    //       }
    //     }
    //   }
    // }
    $loss_account = array('account_name' => 'Loss Account Details',
                          'fine' => 0, 'vadotar' => 0, 'amount' => 0);
    $this->data['loss_account_records'] = array();
    $loss_account_names =  $this->account_model->get('name', array('group_id' => 3));
    $loss_account_names = array_column($loss_account_names, 'name');
    if(!empty($this->data['trial_balance'])){
    foreach($this->data['trial_balance'] as $index => $trail_balance_record) {
        $account_data=$this->account_model->find('unrecoverable_account_name',array('name'=>$trail_balance_record['account_name']));
       $this->data['trial_balance'][$index]['unrecoverable_account_name']= !empty($account_data)?$account_data['unrecoverable_account_name']:'';
      if (in_array($trail_balance_record['account_name'], $loss_account_names)) {
        $loss_account['fine'] += $trail_balance_record['fine'];
        $account_data=$this->account_model->find('unrecoverable_account_name',array('name'=>$trail_balance_record['account_name']));
        $trail_balance_record['unrecoverable_account_name'] =$account_data['unrecoverable_account_name'] ;
        $this->data['loss_account_records'][] = $trail_balance_record;
        unset($this->data['trial_balance'][$index]);
      }
    }}
    $this->data['trial_balance'][] = $loss_account;

   }
  public function _get_form_data() {
    $this->data['quators'] = $this->quator_model->get('name,from_date,to_date');
    $this->data['quator_name']          = (!empty($_GET['quator'])) ? $_GET['quator'] : '';
    
    $this->data['factory_name']=!empty($_GET['site_name'])?$_GET['site_name']:'AR Gold';
    $this->data['site_name']            = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'All';
    $this->data['account_id']           = (!empty($_GET['account_id'])) ? $_GET['account_id'] : 0;
    
    $this->data['loss_categories']=array();

    $categories= $this->voucher_model->get('trim(description) as description', array('account_name'=>'Loss Account','date(created_at)>='=>'2021-03-13'),array(),array('group_by'=>'description'));
    $opening_category_names = $this->opening_loss_voucher_model->get('distinct(type_of_loss) as description',array('type_of_loss!=' => ''));
    $categories=array_merge($categories,$opening_category_names);

    $loss_details= $this->voucher_model->get('description,fine,id', array('account_name'=>'Loss Account','parent_id'=>0),array());
    $category_names=array_column($categories,'description');
     $data['department_names']=array_unique($category_names);
      $data['type']='category';
      $data['completed_at']='2021-11-05';
      $data['quator']=$this->data['quator_name'];
      if(!empty($data['department_names']) && !empty($this->data['quator_name'])){
        if(isset($_GET['site_name'])&&$_GET['site_name']=='ARC (May 2022)'){
          $ghiss_melting_loss=array();
          $url=API_MAY2022_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);

          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARC (May 2022)','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          $opening_loss=$this->get_opening_loss();
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_MAY2022_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $arg_records=array_merge($records,$ghiss_melting_loss,$opening_loss);

        }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='ARF (May 2022)'){
          $ghiss_melting_loss=array();
          $url=API_MAY2022_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)&&(!empty($jan2021_records['data']['loss_details']))?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();

          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARF (May 2022)','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_MAY2022_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $opening_loss=$this->get_opening_loss();
          $arg_records=array_merge($records,$ghiss_melting_loss,$opening_loss);

        }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='AR Gold (May 2022)'){
          $ghiss_melting_loss=array();
          $url=API_MAY2022_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
          
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'AR Gold (May 2022)','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_MAY2022_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $opening_loss=$this->get_opening_loss();
          $arg_records=array_merge($records,$ghiss_melting_loss,$opening_loss);
          
        }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='ARC (Aug 2022)'){
          $ghiss_melting_loss=array();
          $url=API_AUG2022_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);

          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARC (Aug 2022)','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          $opening_loss=$this->get_opening_loss();
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_AUG2022_ARC_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $arg_records=array_merge($records,$ghiss_melting_loss,$opening_loss);

        }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='ARF (Aug 2022)'){
          $ghiss_melting_loss=array();
          $url=API_AUG2022_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)&&(!empty($jan2021_records['data']['loss_details']))?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();

          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'ARF (Aug 2022)','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_AUG2022_ARF_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $opening_loss=$this->get_opening_loss();
          $arg_records=array_merge($records,$ghiss_melting_loss,$opening_loss);

        }elseif(isset($_GET['site_name'])&&$_GET['site_name']=='AR Gold (Aug 2022)'){
          $ghiss_melting_loss=array();
          $url=API_AUG2022_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
          
          $jan2021_records=json_decode(curl_post_request($url,$data),true);
          $records=!empty($jan2021_records)?$jan2021_records['data']['loss_details']['loss_detail']:$jan2021_records['data']['loss_details']['loss_detail']=array();
          $ghiss_melting_loss=$this->voucher_model->get('description,site_name,credit_weight as in_weight,purity as in_lot_purity,argold_id as parent_id,0 as out_weight', array('account_name'=>'Loss Account','site_name'=>'AR Gold (Aug 2022)','receipt_type'=>'Ghiss Melting Loss','quator'=>$data['quator']),array());
          foreach ($ghiss_melting_loss as $ghiss_melting_loss_index => $ghiss_melting_loss_value) {
          $data['issue_department_id']=$ghiss_melting_loss_value['parent_id'];
          $data['quator']=$this->data['quator_name'];
          $url=API_AUG2022_ARG_PATH."issue_and_receipts/loss_report_for_accounts/index";
          $ghiss_details=json_decode(curl_post_request($url,$data),true);
          $out_weight=!empty($ghiss_details)&&(!empty($ghiss_details['data']['ghiss_melting_out_weights']))?$ghiss_details['data']['ghiss_melting_out_weights']:0;
          $ghiss_melting_loss[$ghiss_melting_loss_index]['out_weight']=$out_weight;
          }
          $opening_loss=$this->get_opening_loss();
          $arg_records=array_merge($records,$ghiss_melting_loss,$opening_loss);
          
        }

      if(!empty($arg_records)){
        $category_names = array_map( 'strtolower', $category_names );
        foreach ($category_names as $category_name_index => $category_name) {
        $total_production=$total_loss_fine=$recoverd_loss_fine=$all_loss_before_recovery=$unrecovery_loss=$fine_loss=$total_out_weight=$per_kg_loss=$total_per_kg_loss=$before_recovery_loss=$total_before_recovery_loss=$recovered_loss=$total_recovery_loss=$after_recovery_loss=$total_after_recovery_loss=$total_unrecovery_loss=$after_recovered_loss=$total_after_recovered_loss=$total_balance=$balance=0;
          foreach ($arg_records as $index => $arg_loss_detail) {
              if(trim(strtolower($arg_loss_detail['description']))==trim(strtolower($category_name))){
                $factory_wise_record[$index]['production']=0;
                $loss_account_details= $this->voucher_model->find('sum(debit_weight) as weight,factory_purity,sum(fine) as fine',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name!='=>'Unrecovarable'.' '.$this->data['site_name']));
                
                $unrecovery_details = $this->voucher_model->find('sum(credit_weight) as weight',array('parent_id'=>$arg_loss_detail['parent_id'],'account_name'=>'Unrecovarable'.' '.$this->data['site_name']));

                $opening_recovered_loss=!empty($arg_loss_detail['opening_recovered_loss'])?$arg_loss_detail['opening_recovered_loss']:0;
                $opening_after_recovery=!empty($arg_loss_detail['opening_after_recovery'])?$arg_loss_detail['opening_after_recovery']:0;
                $opening_unrecoverable=!empty($arg_loss_detail['opening_unrecoverable'])?$arg_loss_detail['opening_unrecoverable']:0;
                

                $fine_loss=($arg_loss_detail['in_weight']*$arg_loss_detail['in_lot_purity']/100);
                $recovered_loss=($loss_account_details['fine']+$opening_recovered_loss);
                $after_recovered_loss=($loss_account_details['weight']+$opening_after_recovery);
                $unrecovery_loss=!empty($unrecovery_details)?$unrecovery_details['weight']:0;
                $unrecoverable_loss=$unrecovery_loss+$opening_unrecoverable;
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
  private function get_opening_loss() {
    $opening_loss = $this->opening_loss_voucher_model->get('', 
                                                     array('factory_name' => $this->data['site_name'],
                                                           'quator' => $this->data['quator_name']));
    $opening_loss_details=array();
    foreach ($opening_loss as $opening_loss_index => $opening_loss_value) {
      $data['issue_department_id'] = $opening_loss_value['id'];
      $data['quator'] = '';
      $opening_loss_details[$opening_loss_index]['in_weight'] = $opening_loss_value['loss'];
      $opening_loss_details[$opening_loss_index]['in_lot_purity'] = $opening_loss_value['purity'];
      $opening_loss_details[$opening_loss_index]['out_weight'] = $opening_loss_value['out_weight'];
      $opening_loss_details[$opening_loss_index]['description'] = $opening_loss_value['type_of_loss'];
      $opening_loss_details[$opening_loss_index]['opening_after_recovery'] = $opening_loss_value['after_recovered'];
      $opening_loss_details[$opening_loss_index]['opening_recovered_loss'] = $opening_loss_value['recovered_loss'];
      $opening_loss_details[$opening_loss_index]['opening_unrecoverable'] = $opening_loss_value['unrecovered_loss'];
      $opening_loss_details[$opening_loss_index]['parent_id'] = $opening_loss_value['id'];

    }
    return $opening_loss_details;
  }
  private function get_production_summary() {
    $_GET['start_date'] = '2021-11-04';
   if ($this->data['site_name'] == '' || $this->data['site_name'] == 'ARC') {
      $url = API_MAY2022_ARC_PATH."issue_departments/api_issue_departments/index";
      $records = json_decode(curl_post_request($url, $_GET));
      $arc_records = json_decode(json_encode($records), true);
    }
    if (empty($arc_records['data'])) $arc_records['data'] = array();

    $records = array_merge($arc_records['data']);
    $this->data['production_details'] = $this->get_grouped_records($records);
    $this->get_production_group_total();
  }

  private function get_refresh_details() {
    $select = 'date(created_at) as created_at, item_name, sum(weight) as weight, sum(weight * purity) / sum(weight) as purity, sum(weight * factory_purity) / sum(weight) as factory_purity';
    $where=array();
    $group_by=array('group_by' => 'date(created_at), item_name');
    if(!empty($this->data['site_name'])){
       $where['site_name']    =$this->data['site_name'];
    }
    if(!empty($this->data['product_name'])){
       $where['item_name']    =$this->data['product_name'];
       $group_by=array('group_by' => 'date(created_at)');
    }

    if(!empty($this->data['in_purity'])){
       $where['factory_purity']    =$this->data['in_purity'];
    }
   
    $refresh_details = $this->refresh_detail_model->get($select, $where, array(),$group_by);
    $this->data['refresh_details'] = $this->get_grouped_records($refresh_details);
    $this->get_refresh_group_total();
  }

  private function get_grouped_records($records) {
    $date_wise_data = array();
      foreach ($records as $record) {      
        if (!isset($date_wise_data[substr($record['created_at'], 0, 7)])) 
          $date_wise_data[substr($record['created_at'], 0, 7)] = array('records' => array(), 'issue_gpc_out' => 0);
        $date_wise_data[substr($record['created_at'], 0, 7)]['records'][] = $record;
      }
    ksort($date_wise_data);
    return $date_wise_data;
  }

  private function get_production_group_total() {
    $this->data['production_total'] = array();
    foreach ($this->data['production_details'] as $group => $production_detail) {
      $this->data['production_total'][$group] = array('weight' => 0, 'vadotar' => 0);
      foreach ($production_detail['records'] as $record) {
        $this->data['production_total'][$group]['weight'] += $record['issue_gpc_out'];
        $this->data['production_total'][$group]['vadotar'] += $record['issue_gpc_out'] * ($record['out_purity'] - $record['in_purity']) / 100;
      }
    }
  }

  private function get_refresh_group_total() {
    $this->data['refresh_total'] = array();
    foreach ($this->data['refresh_details'] as $group => $refresh_detail) {
      $this->data['refresh_total'][$group] = array('weight' => 0, 'vadotar' => 0);
      foreach ($refresh_detail['records'] as $record) {
        $this->data['refresh_total'][$group]['weight'] += $record['weight'];
        $this->data['refresh_total'][$group]['vadotar'] += $record['weight'] * ($record['purity'] - $record['factory_purity']) / 100;
      }
    }
  }
}

