<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Account_ledger_reports extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['layout']='application';
    $this->get_form_data();
    $this->get_account_ledger_records();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function get_form_data() {
    $this->data['account_names'] = $this->account_model->get('distinct(ac_account.name) as name,
                                                              ac_account.id as id',
                                                              array('where'=>array('ac_account.name!=""'=>'')),
                                                              array(),
                                                              array('order_by'=>'ac_account.name asc'));
  }

  private function get_account_ledger_records() {
    $issue_data=array();
    $receipt_data=array();
    $this->data['voucher_dates']=array();

    $company_id='';
    if(!empty($_SESSION['company_id'])) $company_id = $_SESSION['company_id'];
    $account_id=(!empty($_GET['account_ledger_reports']['account_id']))?$_GET['account_ledger_reports']['account_id']:'0';

    // $date_from=(!empty($_GET['account_ledger_reports']['date_from']))?date('Y-m-d',strtotime($_GET['account_ledger_reports']['date_from'])):date('Y-m-d');

    // $date_to=(!empty($_GET['account_ledger_reports']['date_to']))?date('Y-m-d',strtotime($_GET['account_ledger_reports']['date_to'])):date('Y-m-d');

    $this->data['account_ledger']=array();
    $this->data['record']['account_id'] = $account_id;
    // $this->data['record']['date_from'] = (!empty($_GET['account_ledger_reports']['date_from']))?$_GET['account_ledger_reports']['date_from']:'';
    // $this->data['record']['date_to'] = (!empty($_GET['account_ledger_reports']['date_to']))?$_GET['account_ledger_reports']['date_to']:'';

    if(!empty($account_id)) {

      $where_issue = array('voucher_type' => 'metal issue voucher', 'account_id'=>$account_id);

      $select = 'date_format(voucher_date,"%d-%m-%Y") as voucher_date';
      $issues = $this->model->get($select, $where_issue ,array(), array('order_by'=>'voucher_date asc'));
      
      $where_receipt = array('voucher_type' => 'metal receipt voucher', 'account_id'=>$account_id);
      $receipts = $this->model->get($select, $where_receipt ,array(), array('order_by'=>'voucher_date asc'));

      $issue_created_dates = array_column($issues, 'voucher_date');
      $receipt_created_dates = array_column($receipts, 'voucher_date');
      $this->data['voucher_dates'] = array_values(array_unique(array_merge($issue_created_dates, $receipt_created_dates)));
      asort($this->data['voucher_dates']);

      $select = 'date_format(voucher_date,"%d-%m-%Y") as voucher_date,
                 account_name, voucher_type, voucher_number, credit_amount, debit_amount, 
                 credit_weight, debit_weight, purity_margin, purity, factory_purity, narration';
      $issues = $this->model->get($select, $where_issue ,array(), array('order_by'=>'voucher_date asc'));
      
      $receipts = $this->model->get($select, $where_receipt ,array(), array('order_by'=>'voucher_date asc'));
      
    
      $issue_data = parent::get_records_by_created_date($issues);
      $receipt_data = parent::get_records_by_created_date($receipts);
      $total = parent::get_total_by_created_date($issue_data, 'issue', array());
      $total = parent::get_total_by_created_date($receipt_data, 'receipt', $total);
      
      $total = parent::set_index_for_dates($total);

      $this->data['issues'] = $issue_data;
      $this->data['receipts'] = $receipt_data;
      $this->data['total'][ACCOUNT_NAME_REPORT] = $total;  
      parent::get_balance_by_created_date();
    }
  }
}
