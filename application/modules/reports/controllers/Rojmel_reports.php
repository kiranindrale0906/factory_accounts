<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Rojmel_reports extends Ledgers {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->data['layout']='application';
    $this->get_account_ledger_records();
    $this->load->render($this->router->class."/index",$this->data);
  }

  private function get_account_ledger_records() {
    $issue_data=array();
    $receipt_data=array();
    $this->data['voucher_dates']=array();

    $company_id='';
    if(!empty($_SESSION['company_id'])) $company_id = $_SESSION['company_id'];
    //if(empty($this->data['account_names'])) return true;

    $where = array('voucher_type' => 'metal receipt voucher');
    $select = 'date_format(voucher_date,"%d-%m-%Y") as voucher_date';
    $issues = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));
      
    $where = array('voucher_type' => 'metal receipt voucher');
    $receipts = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));

    $issue_created_dates = array_column($issues, 'voucher_date');
    $issue_created_dates[] = '01-01-2020';
    $receipt_created_dates = array_column($receipts, 'voucher_date');
    $this->data['voucher_dates'] = array_values(array_unique(array_merge($issue_created_dates, $receipt_created_dates)));
    asort($this->data['voucher_dates']);
    $where['voucher_type'] = 'metal issue voucher';
    //$where['account_name'] = $account_name;

    $select = 'date_format(voucher_date,"%d-%m-%Y") as voucher_date,
               account_name, voucher_type, voucher_number, credit_amount, debit_amount, 
               credit_weight, debit_weight, purity_margin, purity, factory_purity, narration';
    $issues = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));
    
    $where['voucher_type']='metal receipt voucher';
    $receipts = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));
    
    $issue_data = parent::get_records_by_created_date($issues);
    $receipt_data = parent::get_records_by_created_date($receipts);
    $total = parent::get_total_by_created_date($issue_data, 'issue', array());
    $total = parent::get_total_by_created_date($receipt_data, 'receipt', $total);
    $total = parent::set_index_for_dates($total);

    $this->data['issues'] = $issue_data;
    $this->data['receipts'] = $receipt_data;
    $total['01-01-2020'] = array('issue' => array('weight' => 0, 'weight_difference' => 74180.79, 'fine' => 0, 'factory_fine' => 0),
                                 'receipt' => array('weight' => 0, 'weight_difference' => 0, 'fine' => 0, 'factory_fine' => 0));
    $this->data['total'][ACCOUNT_NAME_REPORT] = $total;  
    parent::get_balance_by_created_date();
		

  }
}
