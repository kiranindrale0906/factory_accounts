<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Income_expenses extends Ledgers {

  public function __construct() {
    parent::__construct();
    ini_set("memory_limit","500M");
  }
  public function index() {
    $this->data['report_type'] = 'Income Expenses';
    $this->data['filter_month']= (!empty($_GET['filter_month'])) ? $_GET['filter_month'] : date('m');
    $this->data['filter_year']= (!empty($_GET['filter_year'])) ? $_GET['filter_year'] : date('Y');
    
    $url = "https://apr2024-expenses.ar-gold.in/api/api_income_expenses?api=1&period=date&filter_month="+$this->data['filter_month']+"&filter_year="+$this->data['filter_year'];
    $records = json_decode(get_curl_expenses());
    $this->data = json_decode(json_encode($records), true);    
    $this->load->render($this->router->class."/index",$this->data['data']);
  }
  public function view($id) {
    $hod=$_GET['hod'];
    $period=$_GET['period'];
    $account_id=$_GET['account_id'];
    $account_name=$_GET['account_name'];
    $voucher_date=$_GET['voucher_date'];
    $expenses_account=$_GET['expenses_account'];
//    pd($_GET);
    $this->data['income_expense_account_details']=$this->receipt_according_to_account_id_details($account_id,$account_name,$voucher_date,$expenses_account,$hod,$period);
    $this->load->render('reports/income_expenses/view', $this->data);
  }

  public function get_form_data() {
    $this->data['account_names'] = 
      $this->model->get('distinct(account_name) as name', array(), array(), 
                        array('order_by'=>'account_name asc'));
  }

  private function get_account_ledger_records() {
    if(empty($this->data['account_names'])) return true;

    $where = array();
    $this->data['voucher_dates']=array();
    $period_select = 'voucher_date';

    $this->data['period'] = (!empty($_GET['period'])) ? $_GET['period'] : 'all';
    $this->data['group'] = (!empty($_GET['group'])) ? $_GET['group'] : 'account_name,currency, formatted_voucher_date';

    if     ($this->data['period'] == 'all')  $period_select = 'voucher_date'; 
    elseif ($this->data['period'] == 'date')  $period_select = 'DATE_FORMAT(voucher_date,"%Y-%m-%d")'; 
    elseif ($this->data['period'] == 'month') $period_select = 'DATE_FORMAT(voucher_date,"%Y-%m")';
    elseif ($this->data['period'] == 'week') {
      $period_from_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(DATE_FORMAT(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(DATE_FORMAT(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK)
                                ) -0 DAY)';
      $period_to_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(DATE_FORMAT(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(DATE_FORMAT(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK)
                                ) -7 DAY)';
      $period_select = 'CONCAT('.$period_from_date.' , " - ", '.$period_to_date.')';
    };
    
    $expenses_group_by= "ac_account.expense_account,currency";
    if($this->data['period'] != 'all'){
    	$expenses_group_by= "ac_account.expense_account,currency,formatted_voucher_date";
    }
    $income_accounts = array('Other Income');
    $expense_accounts = array('Alloy', 'Chains & Link Making Dep.','CAD CASTING','Casting Melting', 'Copper & Iron', 'Diamond Cutting', 'Duties & Tax',
                              'Electric & Hardware', 'Electricity Charge', 'Finance Exp.', 'Gas Department', 'GPC,Wolnut & Steel Vibrator',
                              'Import Gold Exp.', 'Kitchen Exp', 'Machinery & Machinery Exp.', 'Nitric & Castic Dep.', 'Office Dep.',
                              'Salary', 'Tarpatta Dep.', 'Telephone & Mobile Dep.', 'Hallmarking Charges',
                              'Stamping Dep.','WATER EXP','New Setup','Consulting Charges', 'Professional Fees', 'Interest', 'Staff Room Rent', 'Stones', 'CASTING AND WAX DEPARTMENT', 'CASTING DEPARTMENT', 'EXCHANGE GAINS LOSS','Rodium Dept','Other Occasion','Laser Room','Factory Expenses','Dull Room','Courier Charges','Repair & Maintenance','Travelling Expense','Tools & Dai','Exhibition exp','Silver','Alloy & Silver','Chatka Polish','Hallmarking','Nitric & Caustic','Staff Room Rent','Electrical and Hardware','Electricity Charges','GPC','Tarpatta ARF','Air Compressor','Exhibition','Office Dept.','Other Occasion','Kitchen Exp.','Salary','Travelling Exp.','Factory Maintenance','Shampoo & Pasta','Copper and Iron','Stamping Dept.','Tarpatta ARG','Ammonia and Argon','Chiller','Buffing Dept.','Lobster Making','Chimney','AMC','Marketing Team','Machine Dept.','Diamond Cutting','Rhodium and Platinum','Camera and Internet','Gas','Melting Dept.(ARF&ARG)','CNC Bangle','Duty and Tax','Finance Exp','Import Gold Exp','Interest','Professional Fees','Solder and Powder','Tools','Solder and Vishnu','Stone','Meena','CAM','ARC Melting','I-T Software','ARC Dies','ARC Tools and Consumables','Tarpatta ARF','Computer & Printer Exp.','Other Occasion','Solar Expense','Donation','CIVIL-PLUMBING-FURNITURE MAINTENANCE','Commission','FIRE AND SAFETY','H. R MAINTENANCE','EXPENSE HOOK DEPT','KITCHEN MAINTENANCE','MACHINE MAINTENANCE- MECHANICAL','MACHINE MAINTENANCE- ELECTRONICS','OIL AND CHEMICAL','KAILASH SALARY','LALIT SALARY','DILKHUSH SALARY','JAVED SALARY','TUSHAR SALARY','RIZWAN SALARY','RAGHAV SALARY','ZAKI SALARY','DINESH SALARY','YASH SALARY','RAHUL SALARY','BHERU SALARY','SUMEET SALARY','VIKAS SALARY','JAINAM SALARY');

    $income_where = array_merge($where, array('ac_account.expense_account' => $income_accounts));
    $expense_where = array_merge($where, array('ac_account.expense_account' => $expense_accounts));

    $select = "account_id,account_name, ac_account.expense_account,ac_account.hod as hod, ".$period_select." as formatted_voucher_date,IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount, ac_ledger.currency";
    $select_expenses = "group_concat(distinct(account_id)) account_id,group_concat(distinct(account_name)) account_name, ac_account.expense_account,ac_account.hod,ac_account.hod as hod, ".$period_select." as formatted_voucher_date,IFNULL(sum(distinct(ac_account.budget)),0) as budget,IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) as amount, ac_ledger.currency";

    $income_data = $this->ledger_model->get($select, $income_where, 
                                            array(array('ac_account', 'ac_ledger.account_id=ac_account.id')), 
                                            array('group_by'=> $this->data['group'], 'order_by'=>'account_name asc'));

    $expense_data = $this->ledger_model->get($select_expenses, $expense_where, 
                                            array(array('ac_account', 'ac_ledger.account_id=ac_account.id')), 
                                            array('group_by'=> $expenses_group_by, 'order_by'=>'ac_account.expense_account asc'));
//lq();
//pd($expense_data);
    $this->data['income'] = $this->get_ledger_data($income_data, ($this->data['period'] != 'all') ? true : false);

    $this->data['expense'] = $this->get_ledger_expenses_data($expense_data, ($this->data['period'] != 'all') ? true : false);
//pd($this->data['expense']);

    $income_dates = array_keys($this->data['income']);
    $expense_dates = array_keys($this->data['expense']);
    $dates = array_unique(array_merge($income_dates, $expense_dates));
    asort($dates);
    $this->data['dates'] = array_values($dates);   
  }

  private function get_ledger_data($data, $date_wise = false) {
    $report = array();
    foreach ($data as $record) {
      $voucher_date = ($date_wise == true) ? $record['formatted_voucher_date'] : 0; 
      $expense_account = $record['expense_account'];
      $account_name    = $record['account_name'];
      if(!isset($report[$voucher_date][$expense_account][$account_name]['inr']))
        $report[$voucher_date][$expense_account][$account_name]['inr'] = 0;

      if(!isset($report[$voucher_date][$expense_account][$account_name]['usd']))
        $report[$voucher_date][$expense_account][$account_name]['usd'] = 0;

      if(!isset($report[$voucher_date][$expense_account][$account_name]['euro']))
        $report[$voucher_date][$expense_account][$account_name]['euro'] = 0;

      if($record['currency'] == 'INR')
        $report[$voucher_date][$expense_account][$account_name]['inr'] += $record['amount'];
        $report[$voucher_date][$expense_account][$account_name]['account_id'] = $record['account_id'];
        $report[$voucher_date][$expense_account][$account_name]['vouchers'] = $this->receipt_according_to_account_id($record['account_id'], $record['formatted_voucher_date']);

      if($record['currency'] == 'USD')
        $report[$voucher_date][$expense_account][$account_name]['usd'] += $record['amount'];
        $report[$voucher_date][$expense_account][$account_name]['account_id'] = $record['account_id'];
        $report[$voucher_date][$expense_account][$account_name]['vouchers'] = $this->receipt_according_to_account_id($record['account_id'], $record['formatted_voucher_date']);
      if($record['currency'] == 'EURO')
        $report[$voucher_date][$expense_account][$account_name]['euro'] += $record['amount'];
      $report[$voucher_date][$expense_account][$account_name]['account_id'] = $record['account_id'];
      $report[$voucher_date][$expense_account][$account_name]['vouchers'] = $this->receipt_according_to_account_id($record['account_id'], $record['formatted_voucher_date']);
    }

    foreach ($report as $index => $voucher_dates) {
      $date = ($date_wise == true) ? $index : 0;

      foreach ($voucher_dates as $expense_account_name => $expense_accounts) {
        
        $report[$date][$expense_account_name]['total']['inr']  = 0;
        $report[$date][$expense_account_name]['total']['usd']  = 0;
        $report[$date][$expense_account_name]['total']['euro'] = 0;

        foreach ($expense_accounts as $account_name => $amount) {
          if(round($amount['inr'],2) != 0 || round($amount['usd'],2) != 0 || round($amount['euro'],2) != 0) {
            if(round($amount['inr'],2) != 0)
              $report[$date][$expense_account_name]['total']['inr'] += round($amount['inr'],2);
            if(round($amount['usd'],2) != 0)
              $report[$date][$expense_account_name]['total']['usd'] += round($amount['usd'],2);
            if(round($amount['euro'],2) != 0)
              $report[$date][$expense_account_name]['total']['euro'] += round($amount['euro'],2);
          }
        }
      }
    }
    return $report;
  }
private function get_ledger_expenses_data($data, $date_wise = false) {
    $report = array();
    foreach ($data as $record) {
      $voucher_date = ($date_wise == true) ? $record['formatted_voucher_date'] : 0; 
      $expense_account = trim($record['hod']);
      $account_name    = $record['expense_account'];
      if(!isset($report[$voucher_date][$expense_account][$account_name]['inr']))
        $report[$voucher_date][$expense_account][$account_name]['inr'] = 0;

      if(!isset($report[$voucher_date][$expense_account][$account_name]['usd']))
        $report[$voucher_date][$expense_account][$account_name]['usd'] = 0;

      if(!isset($report[$voucher_date][$expense_account][$account_name]['euro']))
        $report[$voucher_date][$expense_account][$account_name]['euro'] = 0;
      if(!isset($report[$voucher_date][$expense_account][$account_name]['budget']))
        $report[$voucher_date][$expense_account][$account_name]['budget'] = 0;
      if(!isset($report[$voucher_date][$expense_account][$account_name]['total_budget']))
        $report[$voucher_date][$expense_account][$account_name]['total_budget'] = 0;

      if($record['currency'] == 'INR')
        $report[$voucher_date][$expense_account][$account_name]['inr'] += $record['amount'];
        $report[$voucher_date][$expense_account][$account_name]['budget'] += $record['budget'];
        $report[$voucher_date][$expense_account][$account_name]['total_budget'] += ($record['budget']!=0)?($record['budget']-$record['amount']):$record['amount'];
        $report[$voucher_date][$expense_account][$account_name]['account_id'] = @$record['account_id'];
        $report[$voucher_date][$expense_account][$account_name]['vouchers'] = $this->receipt_according_to_account_id(@$record['account_id'], $record['formatted_voucher_date'],$account_name,$expense_account);
      if($record['currency'] == 'USD')
        $report[$voucher_date][$expense_account][$account_name]['usd'] += $record['amount'];
        $report[$voucher_date][$expense_account][$account_name]['account_id'] = @$record['account_id'];
        $report[$voucher_date][$expense_account][$account_name]['vouchers'] = $this->receipt_according_to_account_id(@$record['account_id'], $record['formatted_voucher_date'],$account_name,$expense_account);
      if($record['currency'] == 'EURO')
        $report[$voucher_date][$expense_account][$account_name]['euro'] += $record['amount'];
      $report[$voucher_date][$expense_account][$account_name]['account_id'] = @$record['account_id'];
      $report[$voucher_date][$expense_account][$account_name]['vouchers'] = $this->receipt_according_to_account_id(@$record['account_id'], $record['formatted_voucher_date'],$account_name,$expense_account);
    }
//pd($report);
    foreach ($report as $index => $voucher_dates) {
      $date = ($date_wise == true) ? $index : 0;

      foreach ($voucher_dates as $expense_account_name => $expense_accounts) {
        
        $report[$date][$expense_account_name]['total']['inr']  = 0;
        $report[$date][$expense_account_name]['total']['usd']  = 0;
        $report[$date][$expense_account_name]['total']['euro'] = 0;
        $report[$date][$expense_account_name]['total']['budget'] = 0;
        $report[$date][$expense_account_name]['total']['total_budget'] = 0;

        foreach ($expense_accounts as $account_name => $amount) {
          if(round($amount['inr'],2) != 0 || round($amount['usd'],2) != 0 || round($amount['euro'],2) != 0) {
            if(round($amount['inr'],2) != 0)
              $report[$date][$expense_account_name]['total']['inr'] += round($amount['inr'],2);
            if(round($amount['usd'],2) != 0)
              $report[$date][$expense_account_name]['total']['usd'] += round($amount['usd'],2);
            if(round($amount['euro'],2) != 0)
              $report[$date][$expense_account_name]['total']['euro'] += round($amount['euro'],2);
            if(round($amount['budget'],2) != 0)
                $report[$date][$expense_account_name]['total']['budget'] += round($amount['budget'],2);
            if(round($amount['total_budget'],2) != 0)
                $report[$date][$expense_account_name]['total']['total_budget'] += round($amount['total_budget'],2);
          }
        }
      }
    }
   // pd($report);
    return $report;
  }

  private function receipt_according_to_account_id($account_id,$voucher_date,$expenses_account='',$hod=''){
    if(!empty($expenses_account)){
      $where['ac_account.expense_account']=$expenses_account;
    }if(!empty($hod)){
      $where['ac_account.hod']=$hod;
    }
    if(!empty($account_id)){
      $where['account_id in ('.$account_id.')']=NULL;
    }else{
      $where['account_id = ""']=NULL;
    }

    if(!empty($account_id)){
      $where['account_id in ('.$account_id.')']=NULL;
    }else{
      $where['account_id = ""']=NULL;
    }
    if($this->data['period'] == 'all'){ 
      $where['amount !=']=0;
    }elseif($this->data['period'] == 'date'){
      $voucher_date = $voucher_date; 
      $where['voucher_date']=$voucher_date;
      $where['amount !=']=0;
    }elseif($this->data['period'] == 'week'){
      $dateArray = explode(" - ",$voucher_date);
      $where['amount !=']=0;
      $where['voucher_date>=']=isset($dateArray[0]) ? $dateArray[0] : '';
      $where['voucher_date<=']=isset($dateArray[1]) ? $dateArray[1] : '';
    }elseif ($this->data['period'] == 'month') {
      $dateArray = explode("-",$voucher_date);
      $where['amount !=']=0;
      $where['MONTH(voucher_date)']=$dateArray[1];
      $where['YEAR(voucher_date)=']=$dateArray[0];
    };

    $ledgers = $this->ledger_model->get('group_concat(distinct(voucher_date)) voucher_date,group_concat(voucher_number) voucher_number,sum(amount) totalamount,IFNULL(sum(debit_amount),0) - IFNULL(sum(credit_amount),0) amount,account_name',$where,array(array('ac_account', 'ac_ledger.account_id=ac_account.id')),array('order_by'=>'voucher_date DESC','group_by'=>"account_name"));
  //$ledgers = $this->ledger_model->get('voucher_date,voucher_number,document,amount,account_name',$where,array(array('ac_account', 'ac_ledger.account_id=ac_account.id')),array('order_by'=>'voucher_date DESC'));
    return $ledgers;
    }
  private function receipt_according_to_account_id_details($account_id,$account_name,$voucher_date,$expenses_account='',$hod='',$period=''){
    if(!empty($expenses_account)){
      $where['ac_account.expense_account']=$expenses_account;
    }if(!empty($hod)){
      $where['ac_account.hod']=$hod;
    }
    if(!empty($account_id)){
      $where['account_id in ('.$account_id.')']=NULL;
    }else{
      $where['account_id = ""']=NULL;
    }

    if(!empty($account_name)){
      $where['account_name']=$account_name;
    }else{
      $where['account_name = ""']=NULL;
    }
    if($period == 'all'){ 
      $where['amount !=']=0;
    }elseif($period == 'date'){
      $voucher_date = $voucher_date; 
     $where['voucher_date']=$voucher_date;
      $where['amount !=']=0;
    }elseif($period == 'week'){
      $dateArray = explode(" - ",$voucher_date);
      $where['amount !=']=0;
      $where['voucher_date>=']=isset($dateArray[0]) ? $dateArray[0] : '';
      $where['voucher_date<=']=isset($dateArray[1]) ? $dateArray[1] : '';
    }elseif ($period == 'month') {
      $dateArray = explode("-",$voucher_date);
      $where['amount !=']=0;
      $where['MONTH(voucher_date)']=$dateArray[1];
      $where['YEAR(voucher_date)=']=$dateArray[0];
    };
//pd($where);
    $ledgers = $this->ledger_model->get('voucher_check,voucher_date,voucher_number voucher_no,document,IFNULL((debit_amount),0) - IFNULL((credit_amount),0) amount,account_name',$where,array(array('ac_account', 'ac_ledger.account_id=ac_account.id')),array('order_by'=>'voucher_date DESC'));
    return $ledgers;
    }


}
