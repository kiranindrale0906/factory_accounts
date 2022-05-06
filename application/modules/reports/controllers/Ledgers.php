<?php
  
class Ledgers extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('transactions/ledger_model', 'masters/account_model', 'argold/chitti_model'));
  }

  protected function get_datewise_ledger_records() {
    $this->data['site_name']            = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'All';
    $this->data['period']               = (!empty($_GET['period'])) ? $_GET['period'] : 'date';
    $this->data['detail']               = (!empty($_GET['detail'])) ? $_GET['detail'] : 'yes';
    $this->data['group']                = (!empty($_GET['group'])) ? $_GET['group'] : '';
    $this->data['domestic_export']      = (!empty($_GET['domestic_export'])) ? $_GET['domestic_export'] : 'All';
    $this->data['account_id']           = (!empty($_GET['account_id'])) ? $_GET['account_id'] : 0;
    $this->data['account_name']           = (!empty($_GET['account_name'])) ? $_GET['account_name'] : 0;
    $this->data['record']['account_id'] = (!empty($_GET[$this->router->class]['account_id'])) ? $_GET[$this->router->class]['account_id'] : $this->data['account_id'];
    if (empty($this->data['account_id'])) $this->data['account_id'] = $this->data['record']['account_id'];

    if ($this->data['period'] == 'date' && ($this->data['report_type'] == 'Account Ledger' || $this->data['report_type'] == 'Domestic Labour Ledger'))
      $this->data['group'] = 'date';
    elseif ($this->data['period'] == 'date' && ($this->data['report_type'] == 'Metal Receipt Type Report'))
      $this->data['group'] = 'date';
    elseif ($this->data['report_type'] == 'Rojmel Report')
      $this->data['group'] = 'id';
    
    if     ($this->data['period'] == 'date')  $period_select = 'date_format(voucher_date,"%Y-%m-%d")';
    elseif ($this->data['period'] == 'month') $period_select = 'date_format(voucher_date,"%Y-%m")';
    elseif ($this->data['period'] == 'year') $period_select = 'date_format(voucher_date,"%Y")';
    elseif ($this->data['period'] == 'week') {
      $period_from_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK)
                                ) -1 DAY)';
      $period_to_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK)
                                ) -7 DAY)';
      $period_select = 'CONCAT('.$period_from_date.' , " - ", '.$period_to_date.')';
    };

    $where = array();
    if(!empty($this->data['record']['account_id']))        $where['account_id'] = $this->data['record']['account_id'];
    if (   !empty($this->data['site_name']) 
        && $this->data['site_name'] != 'All')              $where['site_name'] = $this->data['site_name'];

    if ($this->data['report_type'] == 'Vadotar Report' || $this->data['report_type'] == 'Production Report') {
      $export_accounts = $this->account_model->get('name', array('group_code' => 'Export'));
      $export_account_names = array_column($export_accounts, 'name');
      //$export_account_names[] = 'Tanishq';
      $export_account_names = implode('", "',$export_account_names);
      if ($this->data['domestic_export'] == 'All') {
        $where['(   purity != factory_purity 
                 or (    account_name in ("'.$export_account_names.'") 
                     and voucher_type = "metal issue voucher")
                )'] = NULL;
      } elseif ($this->data['domestic_export'] == 'Domestic') {
        $where['purity != factory_purity'] = NULL;
      } elseif ($this->data['domestic_export'] == 'Tanishq') {
        $where['account_name'] = 'Tanishq';
        $where['voucher_type'] = 'metal issue voucher';
      } elseif ($this->data['domestic_export'] == 'Export') {
        $where['(    account_name in ("'.$export_account_names.'") 
                 and voucher_type = "metal issue voucher")'] = NULL;
      }

    }

    if ($this->data['report_type'] == 'Production Report') $where['account_name != '] = 'VADOTAR';
    
    if (($this->data['report_type'] == 'Account Ledger'|| $this->data['report_type'] == 'Domestic Labour Ledger') && $this->data['group'] == 'date')
      $this->data['group'] = 'voucher_type, voucher_date, chitti_no, receipt_type, account_name';
    if ($this->data['report_type'] == 'Metal Receipt Type Report' && $this->data['group'] == 'date')
      $this->data['group'] = 'voucher_type, voucher_date, receipt_type';      
      
    if (   $this->data['report_type'] == 'Account Ledger' 
        || $this->data['report_type'] == 'Rojmel Report'
        || $this->data['report_type'] == 'Metal Receipt Type Report') {
      $receipt_issue_select = 'receipt_type, '.$period_select.' as voucher_date, 
                               date_format(voucher_date,"%Y-%m-%d") as str_voucher_date,
                               account_name, voucher_type, 
                               GROUP_CONCAT(DISTINCT(voucher_id)) as voucher_id, 
                               
                               site_name, voucher_type, 
                               concat(voucher_number, ", ") as voucher_number, 
                               sum(credit_amount) as credit_amount, 
                               sum(usd_credit_amount) as usd_credit_amount, 
                               sum(debit_amount) as debit_amount, 
                               sum(usd_debit_amount) as usd_debit_amount, 
                               sum(credit_weight) as credit_weight, 
                               sum(debit_weight) as debit_weight,
                               sum(fine) as fine,
                               sum(factory_fine) as factory_fine,
                               0 as purity_margin, 
                               sum((credit_weight+debit_weight) * purity) / sum(credit_weight+debit_weight) as purity, 
                               sum((credit_weight+debit_weight) * factory_purity) / sum(credit_weight+debit_weight) as factory_purity, 
                               concat(narration, " ,") as narration, concat(description, " ,") as description, 
                               chitti_id as chitti_no,parent_id as parent_id,id as id';
    } else {
      //$this->data['group'] = 'voucher_date';
      $receipt_issue_select = '"" as receipt_type, '.$period_select.' as voucher_date, 
                              date_format(voucher_date,"%Y-%m-%d") as str_voucher_date,
                              account_name as account_name, "" as voucher_type,site_name , "" as voucher_number, 
                              sum(credit_amount) as credit_amount,
                              GROUP_CONCAT(DISTINCT(voucher_id)) as voucher_id, 
                                
                              sum(usd_credit_amount) as usd_credit_amount, 
                              sum(debit_amount) as debit_amount, 
                              sum(usd_debit_amount) as usd_debit_amount, 
                              sum(credit_weight) as credit_weight, 
                              sum(debit_weight) as debit_weight, 
                              sum(fine) as fine,
                              sum(factory_fine) as factory_fine,
                              0 as purity_margin, 
                              sum((credit_weight+debit_weight) * purity) /  sum(credit_weight+debit_weight)  as purity, 
                              sum((credit_weight+debit_weight) * factory_purity) /  sum(credit_weight+debit_weight)  as factory_purity,
                              ""  as narration, "" as description, 
                              "" as chitti_no,parent_id as parent_id,id as id';       
    }
    if ($this->data['report_type'] == 'Metal Receipt Type Report')
      $where['receipt_type']='Metal';
    $account_issue_where=array();
    $account_receipt_where=array();
    if ($this->data['report_type'] == 'Account Receipt Report'){

    $account_receipt_where['purity>='] = 98;
    $account_receipt_where['purity<='] = 100;
    
    $account_issue_where['purity>='] = 98;
    $account_issue_where['purity<='] = 100;
    $receipt_issue_select = 'receipt_type, '.$period_select.' as voucher_date, 
                               date_format(voucher_date,"%Y-%m-%d") as str_voucher_date,
                               account_name, voucher_type, 
                               site_name, voucher_type, 
                               concat(voucher_number, ", ") as voucher_number, 
                               (credit_amount) as credit_amount, 
                               (usd_credit_amount) as usd_credit_amount, 
                               (debit_amount) as debit_amount, 
                               (usd_debit_amount) as usd_debit_amount, 
                               (credit_weight) as credit_weight, 
                               (debit_weight) as debit_weight,
                               (fine) as fine,
                               (factory_fine) as factory_fine,
                               0 as purity_margin, 
                               ((credit_weight+debit_weight) * purity) / (credit_weight+debit_weight) as purity, 
                               ((credit_weight+debit_weight) * factory_purity) / (credit_weight+debit_weight) as factory_purity, 
                               concat(narration, " ,") as narration, concat(description, " ,") as description, 
                               chitti_id as chitti_no,parent_id as parent_id,id as id';
                               // pd($this->data['site_name'] );
       $account_receipt_where['site_name'] = '';                        
       $account_issue_where['site_name'] = '';                        
      if ($this->data['site_name'] == 'ARF'){
        $account_issue_where['account_name'] = 'ARF Software';
      }elseif ($this->data['site_name'] == 'ARC'){
        $account_issue_where['account_name'] = 'ARC Software';
      }elseif ($this->data['site_name'] == 'AR Gold'){
        $account_issue_where['account_name'] = 'AR Gold Software';
      }
      else{
        $account_issue_where['account_name in ("ARF Software","ARC Software","AR Gold Software") '] = NULL;
      }   
      !empty($this->data['account_name'])?$account_receipt_where['account_name']=$this->data['account_name']:$account_receipt_where['account_name not in ("MAIN VADOTAR","PURCHASE ACCOUNT","ARF Software","ARC Software","AR Gold Software") '] = NULL;                    
    }   
    
    $where_issue   = array_merge($where, array('(credit_weight != 0 or credit_amount != 0)' => NULL),$account_issue_where);
    $where_receipt = array_merge($where, array('(debit_weight != 0 or debit_amount != 0)'   => NULL),$account_receipt_where);
    $issues   = $this->ledger_model->get($receipt_issue_select, $where_issue,   array(), array('order_by'=>'chitti_id, voucher_type, str_voucher_date asc', 'group_by' => $this->data['group']));
    foreach ($issues as $issue_index => $issue_value) {
      $voucher_id=explode(',', $issue_value['voucher_id']);
      $ac_voucher_issue_detail=$this->voucher_model->get('metal_receipt_voucher_reference_id,id',array('where_in'=>array('id'=>$voucher_id),'where'=>array('metal_receipt_voucher_reference_id is not NULL'=>NULL)));
      $metal_receipt_voucher_reference_id=array_column($ac_voucher_issue_detail,'metal_receipt_voucher_reference_id');
      $issues[$issue_index]['reference_account_name']="";
      if(!empty($metal_receipt_voucher_reference_id)){
      $reference_ac_voucher_issue_detail=$this->voucher_model->find('GROUP_CONCAT(DISTINCT(account_name)) as account_name',array('where_in'=>array('id'=>$metal_receipt_voucher_reference_id)));
      $issues[$issue_index]['reference_account_name']=$reference_ac_voucher_issue_detail['account_name'];
      }
    }
    $receipts = $this->ledger_model->get($receipt_issue_select, $where_receipt, array(), array('order_by'=>'parent_id, voucher_type, str_voucher_date asc', 'group_by' => $this->data['group']));
      foreach ($receipts as $receipt_index => $receipt_value) {
        $voucher_id=explode(',', $receipt_value['voucher_id']);
        $ac_voucher_receipt_detail=$this->voucher_model->get('metal_receipt_voucher_reference_id',array('where_in'=>array('id'=>$voucher_id),'where'=>array('metal_receipt_voucher_reference_id is not NULL'=>NULL)));
        $metal_receipt_voucher_reference_id=array_column($ac_voucher_receipt_detail,'metal_receipt_voucher_reference_id');
        $receipts[$receipt_index]['reference_account_name']="";
        if(!empty($metal_receipt_voucher_reference_id)){
        $reference_ac_voucher_receipt_detail=$this->voucher_model->find('GROUP_CONCAT(DISTINCT(account_name)) as account_name',array('where_in'=>array('id'=>$metal_receipt_voucher_reference_id)));
        $receipts[$receipt_index]['reference_account_name']=$reference_ac_voucher_receipt_detail['account_name'];
      }
    }

     $domestic_export_receipt_issue_select='account_name,voucher_date,date_format(voucher_date,"%Y-%m-%d") as str_voucher_date,((debit_weight*purity)/100)- 
    ((credit_weight*factory_purity)/100) as fine, ((purity-factory_purity)*debit_weight/100) - 
    ((factory_purity-purity)*credit_weight/100) as vadotar, (debit_amount - credit_amount) as credit_weight, 0 as `id`,0 as debit_amount,account_id,0 as debit_weight,0 as usd_credit_amount,0 as usd_debit_amount,0 as credit_amount,description,narration,chitti_id as chitti_no,purity,factory_purity,factory_fine';

    if($this->data['report_type']=='Domestic Sale Ledger'){
    $receipts = $this->voucher_model->get($domestic_export_receipt_issue_select,array('account_name' =>'SALES ACCOUNT','is_export'=> 0), array(), array('order_by'=>'parent_id, voucher_type asc', 'group_by' => $this->data['group']));
    // pd($receipts);
    $issues=array();
    $issue_voucher_dates=array();

    }

    if($this->data['report_type']=='Domestic Purchase Ledger'){
    $receipts = $this->voucher_model->get($domestic_export_receipt_issue_select,array('account_name' =>'PURCHASE ACCOUNT','is_export'=> 0), array(), array('order_by'=>'parent_id, voucher_type asc', 'group_by' => $this->data['group']));

    $issues=array();
    $issue_voucher_dates=array();
    }

    if($this->data['report_type']=='Export Sale Ledger'){
    $receipts = $this->voucher_model->get($domestic_export_receipt_issue_select,array('account_name' => 'SALES ACCOUNT','is_export'=> 1), array(), array('order_by'=>'parent_id, voucher_type asc', 'group_by' => $this->data['group']));
    
    $issues=array();
    $issue_voucher_dates=array();
    }

    if($this->data['report_type']=='Export Purchase Ledger'){
     $receipts = $this->voucher_model->get($domestic_export_receipt_issue_select,array('account_name' => 'PURCHASE ACCOUNT','is_export'=> 1), array(), array('order_by'=>'parent_id, voucher_type asc', 'group_by' => $this->data['group']));

    $issues=array();
    $issue_voucher_dates=array();
    }
    if($this->data['report_type']=='Domestic Labour Ledger'){
      $where_receipt['account_name']="Domestic Labour Amount";
     $receipts = $this->ledger_model->get('receipt_type, date_format(voucher_date,"%Y-%m-%d") as voucher_date, 
                               date_format(voucher_date,"%Y-%m-%d") as str_voucher_date,
                               account_name, voucher_type, 
                               site_name, voucher_type, 
                               concat(voucher_number, ", ") as voucher_number, 
                               sum(credit_amount) as credit_amount, 
                               sum(usd_credit_amount) as usd_credit_amount, 
                               sum(debit_amount) as debit_amount, 
                               sum(usd_debit_amount) as usd_debit_amount, 
                               sum(credit_weight) as credit_weight, 
                               sum(debit_weight) as debit_weight,
                               sum(fine) as fine,
                               sum(factory_fine) as factory_fine,
                               0 as purity_margin, 
                               sum((credit_weight+debit_weight) * purity) / sum(credit_weight+debit_weight) as purity, 
                               sum((credit_weight+debit_weight) * factory_purity) / sum(credit_weight+debit_weight) as factory_purity, 
                               concat(narration, " ,") as narration, concat(description, " ,") as description, 
                               chitti_id as chitti_no,parent_id as parent_id,id as id', $where_receipt,array(), array('order_by'=>'parent_id, voucher_type asc', 'group_by' => $this->data['group']));

    $issues=array();
    $issue_voucher_dates=array();
    }
    if($this->data['report_type']=='Export Labour Ledger'){
    $where['chitties.usd_rate != 0'] = NULL;
    $where['chitties.ounce_rate != 0 or chitties.usd_rate != 0'] = NULL;
      $domestic_export_receipt_issue_select='ac_vouchers.account_name,date as voucher_date,date_format(chitties.date,"%Y-%m-%d") as str_voucher_date,0 as fine, 0 as vadotar, (chitties.labour_usd_amount * chitties.usd_rate) + (chitties.freight_usd_amount * chitties.usd_rate) as credit_weight, 0 as `id`,0 as debit_amount,0 as usd_credit_amount,0 as account_id,0 as debit_weight,0 as credit_amount,0 as usd_credit_amount,0 as usd_debit_amount,"" as description,"" as narration,chitties.id as chitti_no,ac_vouchers.purity,ac_vouchers.factory_purity,ac_vouchers.factory_fine';

     $receipts = $this->chitti_model->get($domestic_export_receipt_issue_select,$where,array(array('ac_vouchers',  'ac_vouchers.chitti_id=chitties.id','right')), array('order_by'=>'ac_vouchers.parent_id, ac_vouchers.voucher_type asc'));

    $issues=array();
    $issue_voucher_dates=array();
    }

    $issue_voucher_dates = array_column($issues, 'voucher_date');
    $receipt_voucher_dates = array_column($receipts, 'voucher_date');
    $this->data['voucher_dates'] = array_values(array_unique(array_merge($issue_voucher_dates, $receipt_voucher_dates)));
    asort($this->data['voucher_dates']);
    $this->data['issues']   = $this->get_records_by_created_date($issues);
    $this->data['receipts'] = $this->get_records_by_created_date($receipts);

    $this->data['day_total'] = $this->set_index_for_dates();
    $this->get_day_total($this->data['issues']);
    $this->get_day_total($this->data['receipts']);      
    
    $this->data['day_balance'] = $this->set_index_for_dates();
    $this->get_day_balance();   

    $this->data['opening']   = $this->set_index_for_dates();
    $this->data['balance']   = $this->set_index_for_dates();
    
    if (isset($this->data['report_type']) && $this->data['report_type'] == 'Production Report') {
      //do not compute opening / balance
    }
    else {
      $this->get_balance();
      $this->get_closing();
    }
  }

  private function get_records_by_created_date($records) {
    $records_by_created_date = array();
    foreach($records as $record) {
      if (!isset($records_by_created_date[$record['voucher_date']])) $records_by_created_date[$record['voucher_date']] = array();
      $records_by_created_date[$record['voucher_date']][] = $record;
    }
    return $records_by_created_date;
  }

  private function set_index_for_dates() {
    $empty_record = array();
    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($empty_record[$created_date])) {
        $empty_record[$created_date] = array();
        $empty_record[$created_date]['issue'] = array();
        $empty_record[$created_date]['issue']['credit_weight'] = 0;
        $empty_record[$created_date]['issue']['fine'] = 0;
        $empty_record[$created_date]['issue']['factory_fine'] = 0;
        $empty_record[$created_date]['issue']['credit_amount'] = 0;
        $empty_record[$created_date]['issue']['usd_credit_amount'] = 0;
        $empty_record[$created_date]['receipt'] = array();
        $empty_record[$created_date]['receipt']['debit_weight'] = 0;
        $empty_record[$created_date]['receipt']['fine'] = 0;
        $empty_record[$created_date]['receipt']['factory_fine'] = 0;
        $empty_record[$created_date]['receipt']['debit_amount'] = 0;
        $empty_record[$created_date]['receipt']['usd_debit_amount'] = 0;
      }
    }
    return $empty_record;
  }

  private function get_day_total($records) {
    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($records[$created_date])) continue;

      foreach($records[$created_date] as $account_name => $record) {
        if ($record['credit_weight'] !=0 or $record['credit_amount'] != 0 or $record['usd_credit_amount'] != 0){
          $this->data['day_total'][$record['voucher_date']]['issue']['credit_weight'] += $record['credit_weight'];
          $this->data['day_total'][$record['voucher_date']]['issue']['fine'] += $record['fine'];
          $this->data['day_total'][$record['voucher_date']]['issue']['factory_fine'] += $record['factory_fine'];
          $this->data['day_total'][$record['voucher_date']]['issue']['credit_amount'] += $record['credit_amount'];
          $this->data['day_total'][$record['voucher_date']]['issue']['usd_credit_amount'] += $record['usd_credit_amount'];
        } else {
          $this->data['day_total'][$record['voucher_date']]['receipt']['debit_weight'] += $record['debit_weight'];
          $this->data['day_total'][$record['voucher_date']]['receipt']['fine'] += $record['fine'];
          $this->data['day_total'][$record['voucher_date']]['receipt']['factory_fine'] += $record['factory_fine'];
          $this->data['day_total'][$record['voucher_date']]['receipt']['debit_amount'] += $record['debit_amount'];
          $this->data['day_total'][$record['voucher_date']]['receipt']['usd_debit_amount'] += $record['usd_debit_amount'];
        }
      }
    }
  }

  private function get_day_balance() {
    foreach($this->data['voucher_dates'] as $voucher_date) {    
      $credit_weight       = $this->data['day_total'][$voucher_date]['issue']['credit_weight'];
      $credit_factory_fine = $this->data['day_total'][$voucher_date]['issue']['factory_fine'];
      $credit_fine         = $this->data['day_total'][$voucher_date]['issue']['fine'];
      $credit_amount       = $this->data['day_total'][$voucher_date]['issue']['credit_amount'];
      $usd_credit_amount       = $this->data['day_total'][$voucher_date]['issue']['usd_credit_amount'];

      $debit_weight       = $this->data['day_total'][$voucher_date]['receipt']['debit_weight'];
      $debit_factory_fine = $this->data['day_total'][$voucher_date]['receipt']['factory_fine'];
      $debit_fine         = $this->data['day_total'][$voucher_date]['receipt']['fine'];
      $debit_amount       = $this->data['day_total'][$voucher_date]['receipt']['debit_amount'];
      $usd_debit_amount       = $this->data['day_total'][$voucher_date]['receipt']['usd_debit_amount'];

      if ( ($credit_weight >= $debit_weight)  && (($credit_factory_fine > $debit_factory_fine) > 0 || ($credit_amount > $debit_amount) || ($usd_credit_amount > $usd_debit_amount))) {
        $this->data['day_balance'][$voucher_date]['issue']['credit_weight'] = $credit_weight - $debit_weight;
        $this->data['day_balance'][$voucher_date]['issue']['factory_fine']  = $credit_factory_fine - $debit_fine;
        $this->data['day_balance'][$voucher_date]['issue']['fine']          = $credit_fine - $debit_factory_fine;
        $this->data['day_balance'][$voucher_date]['issue']['credit_amount'] = $credit_amount - $debit_amount;
        $this->data['day_balance'][$voucher_date]['issue']['usd_credit_amount'] = $usd_credit_amount - $usd_debit_amount;
      } else {
        $this->data['day_balance'][$voucher_date]['receipt']['debit_weight'] = $debit_weight - $credit_weight;
        $this->data['day_balance'][$voucher_date]['receipt']['factory_fine'] = $debit_factory_fine - $credit_fine;
        $this->data['day_balance'][$voucher_date]['receipt']['fine']         = $debit_fine - $credit_factory_fine;
        $this->data['day_balance'][$voucher_date]['receipt']['debit_amount'] = $debit_amount - $credit_amount;
        $this->data['day_balance'][$voucher_date]['receipt']['usd_debit_amount'] = $usd_debit_amount - $usd_credit_amount;
      }
    }
  } 

  private function get_balance() {
    $previous_date = '';
    
    foreach($this->data['voucher_dates'] as $voucher_date) {
      if ($previous_date != '') {
        $this->data['opening'][$voucher_date]['issue']['credit_weight']  = $this->data['balance'][$previous_date]['issue']['credit_weight'];
        $this->data['opening'][$voucher_date]['issue']['factory_fine']   = $this->data['balance'][$previous_date]['issue']['factory_fine'];
        $this->data['opening'][$voucher_date]['issue']['fine']           = $this->data['balance'][$previous_date]['issue']['fine'];
        $this->data['opening'][$voucher_date]['issue']['credit_amount']  = $this->data['balance'][$previous_date]['issue']['credit_amount'];
        $this->data['opening'][$voucher_date]['issue']['usd_credit_amount']  = $this->data['balance'][$previous_date]['issue']['usd_credit_amount'];
        $this->data['opening'][$voucher_date]['receipt']['debit_weight'] = $this->data['balance'][$previous_date]['receipt']['debit_weight'];
        $this->data['opening'][$voucher_date]['receipt']['factory_fine'] = $this->data['balance'][$previous_date]['receipt']['factory_fine'];
        $this->data['opening'][$voucher_date]['receipt']['fine']         = $this->data['balance'][$previous_date]['receipt']['fine'];
        $this->data['opening'][$voucher_date]['receipt']['debit_amount'] = $this->data['balance'][$previous_date]['receipt']['debit_amount'];
        $this->data['opening'][$voucher_date]['receipt']['usd_debit_amount'] = $this->data['balance'][$previous_date]['receipt']['usd_debit_amount'];

        $current_date_credit_weight       = $this->data['day_balance'][$voucher_date]['issue']['credit_weight'];
        $current_date_credit_factory_fine = $this->data['day_balance'][$voucher_date]['issue']['factory_fine' ];
        $current_date_credit_fine         = $this->data['day_balance'][$voucher_date]['issue']['fine'];
        $current_date_credit_amount       = $this->data['day_balance'][$voucher_date]['issue']['credit_amount'];
        $current_date_usd_credit_amount       = $this->data['day_balance'][$voucher_date]['issue']['usd_credit_amount'];
        $current_date_debit_weight        = $this->data['day_balance'][$voucher_date]['receipt']['debit_weight'];
        $current_date_debit_factory_fine  = $this->data['day_balance'][$voucher_date]['receipt']['factory_fine'];
        $current_date_debit_fine          = $this->data['day_balance'][$voucher_date]['receipt']['fine'];
        $current_date_debit_amount        = $this->data['day_balance'][$voucher_date]['receipt']['debit_amount'];
        $current_date_usd_debit_amount        = $this->data['day_balance'][$voucher_date]['receipt']['usd_debit_amount'];

        $credit_weight        = $this->data['opening'][$voucher_date]['issue']['credit_weight']  + $current_date_credit_weight;
        $credit_factory_fine  = $this->data['opening'][$voucher_date]['issue']['factory_fine']   + $current_date_credit_factory_fine;
        $credit_fine          = $this->data['opening'][$voucher_date]['issue']['fine']           + $current_date_credit_fine;
        $credit_amount        = $this->data['opening'][$voucher_date]['issue']['credit_amount']  + $current_date_credit_amount;
        $usd_credit_amount        = $this->data['opening'][$voucher_date]['issue']['usd_credit_amount']  + $current_date_usd_credit_amount;
        $debit_weight         = $this->data['opening'][$voucher_date]['receipt']['debit_weight'] + $current_date_debit_weight;
        $debit_factory_fine   = $this->data['opening'][$voucher_date]['receipt']['factory_fine'] + $current_date_debit_factory_fine;
        $debit_fine           = $this->data['opening'][$voucher_date]['receipt']['fine']         + $current_date_debit_fine;
        $debit_amount         = $this->data['opening'][$voucher_date]['receipt']['debit_amount'] + $current_date_debit_amount;
        $usd_debit_amount         = $this->data['opening'][$voucher_date]['receipt']['usd_debit_amount'] + $current_date_usd_debit_amount;

        if (    ($credit_weight >= $debit_weight) 
             && ($credit_factory_fine > $debit_fine || $credit_amount > $debit_amount || $usd_credit_amount > $usd_debit_amount)) {
          $this->data['balance'][$voucher_date]['issue']['credit_weight'] = $credit_weight - $debit_weight;
          $this->data['balance'][$voucher_date]['issue']['factory_fine']  = $credit_factory_fine - $debit_fine;
          $this->data['balance'][$voucher_date]['issue']['fine']  = $credit_fine - $debit_factory_fine;
          $this->data['balance'][$voucher_date]['issue']['credit_amount'] = $credit_amount - $debit_amount;
          $this->data['balance'][$voucher_date]['issue']['usd_credit_amount'] = $usd_credit_amount - $usd_debit_amount;
        } else {
          $this->data['balance'][$voucher_date]['receipt']['debit_weight'] = $debit_weight - $credit_weight;
          $this->data['balance'][$voucher_date]['receipt']['fine']         = $debit_fine - $credit_factory_fine;
          $this->data['balance'][$voucher_date]['receipt']['factory_fine'] = $debit_factory_fine - $credit_fine;
          $this->data['balance'][$voucher_date]['receipt']['debit_amount'] = $debit_amount - $credit_amount;
          $this->data['balance'][$voucher_date]['receipt']['usd_debit_amount'] = $usd_debit_amount - $usd_credit_amount;
        }
      } else
        $this->data['balance'][$voucher_date] = $this->data['day_balance'][$voucher_date]; 

      if ($this->data['report_type'] == 'Vadotar Report') {
        //$this->data['balance'][$voucher_date]['issue']['credit_weight'] = 0; 
        //$this->data['balance'][$voucher_date]['issue']['credit_amount'] = 0;
        //$this->data['balance'][$voucher_date]['issue']['usd_credit_amount'] = 0;
        //$this->data['balance'][$voucher_date]['receipt']['debit_weight'] = 0;
        //$this->data['balance'][$voucher_date]['receipt']['debit_amount'] = 0;
        //$this->data['balance'][$voucher_date]['receipt']['usd_debit_amount'] = 0;
      }
      $previous_date = $voucher_date;
    } 
  }

  private function get_closing() {
    $last_voucher_date = end($this->data['voucher_dates']);
    $this->data['closing'] = array($last_voucher_date => array());
    $this->data['closing'][$last_voucher_date]['receipt']['debit_weight'] = 0;
    $this->data['closing'][$last_voucher_date]['receipt']['fine'] = 0;
    $this->data['closing'][$last_voucher_date]['receipt']['factory_fine'] =!empty($this->data['balance'][$last_voucher_date]['issue']['fine']) ?$this->data['balance'][$last_voucher_date]['issue']['fine']:0;
    $this->data['closing'][$last_voucher_date]['receipt']['debit_amount'] =!empty($this->data['balance'][$last_voucher_date]['issue']['credit_amount']) ? $this->data['balance'][$last_voucher_date]['issue']['credit_amount']:0;
    $this->data['closing'][$last_voucher_date]['receipt']['usd_debit_amount'] =!empty($this->data['balance'][$last_voucher_date]['issue']['usd_credit_amount']) ? $this->data['balance'][$last_voucher_date]['issue']['usd_credit_amount']:0;

    $this->data['closing'][$last_voucher_date]['issue']['credit_weight'] = 0;
    $this->data['closing'][$last_voucher_date]['issue']['fine'] = 0;
    $this->data['closing'][$last_voucher_date]['issue']['factory_fine'] =!empty($this->data['balance'][$last_voucher_date]['receipt']['fine']) ? $this->data['balance'][$last_voucher_date]['receipt']['fine']:0;
    $this->data['closing'][$last_voucher_date]['issue']['credit_amount'] = 
    !empty($this->data['balance'][$last_voucher_date]['receipt']['debit_amount']) ? $this->data['balance'][$last_voucher_date]['receipt']['debit_amount']:0;
    $this->data['closing'][$last_voucher_date]['issue']['usd_credit_amount'] = 
    !empty($this->data['balance'][$last_voucher_date]['receipt']['usd_debit_amount']) ? $this->data['balance'][$last_voucher_date]['receipt']['usd_debit_amount']:0;

    if ($this->data['report_type'] == 'Vadotar Report') {
      $this->data['closing'][$last_voucher_date]['receipt']['fine'] = !empty($this->data['balance'][$last_voucher_date]['issue']['factory_fine'])?$this->data['balance'][$last_voucher_date]['issue']['factory_fine']:0;
    }
  }  
}
?>
