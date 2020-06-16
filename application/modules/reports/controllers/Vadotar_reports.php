<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Client_ledgers.php";
class Vadotar_reports extends Client_ledgers {

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
    $this->data['account_names'] = $this->model->get('distinct(account_name) as name',
                          array('where_in' => array('voucher_type' => array("'metal issue voucher'", 
                                                                            "'metal receipt voucher'"))),
                          array(), array('order_by'=>'account_name asc'));
  }

  private function get_account_ledger_records() {
    $issue_data=array();
    $receipt_data=array();
    $this->data['voucher_dates']=array();

    $company_id='';
    if(!empty($_SESSION['company_id'])) $company_id = $_SESSION['company_id'];
    if(empty($this->data['account_names'])) return true;

    $where = array('voucher_type' => 'metal receipt voucher');
    $select = 'date_format(voucher_date,"%d-%m-%Y") as voucher_date';
    $issues = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));
      
    $where = array('voucher_type' => 'metal receipt voucher');
    $receipts = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));

    $issue_created_dates = array_column($issues, 'voucher_date');
    $receipt_created_dates = array_column($receipts, 'voucher_date');
    $this->data['voucher_dates'] = array(''); //array_values(array_unique(array_merge($issue_created_dates, $receipt_created_dates)));
    asort($this->data['voucher_dates']);

    //foreach ($this->data['account_names'] as $account_detail) {
      //$account_name = $account_detail['name'];  
      $account_name = '';  

      $where['voucher_type'] = 'metal issue voucher';
      $where['purity!=factory_purity']=NULL;
      //$where['account_name'] = $account_name;


      $select = 'date_format(voucher_date,"%d-%m-%Y") as voucher_date,
                 account_name, voucher_type, voucher_number, credit_amount, debit_amount, 
                 credit_weight, debit_weight, purity_margin, purity, factory_purity, narration';
      $issues = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));
      
      $where['voucher_type']='metal receipt voucher';
      $where['purity!=factory_purity']=NULL;
      $receipts = $this->model->get($select, $where ,array(), array('order_by'=>'voucher_date asc'));
      $issues = array_merge(array(array('voucher_date' => '01-01-2020',
                                        'account_name' => 'Opening',
                                        'voucher_type' => 'metal issue voucher',
                                        'voucher_number' => '',
                                        'credit_amount' => 0,
                                        'debit_amount' => 0,
                                        'credit_weight' => 0,
                                        'debit_weight' => 0,
                                        'purity_margin' => 0,
                                        'purity' => 0,
                                        'factory_purity' => 0,
                                        'narration' => '')), $issues);
      $issue_data[$account_name][''] = $issues; //parent::get_records_by_created_date($issues);
      $receipt_data[$account_name][''] = $receipts; //parent::get_records_by_created_date($receipts);

      $total[''][''] = array('issue' => array('weight' => 0, 'weight_difference' => 0, 'fine' => 0, 'factory_fine' => 0),
                             'receipt' => array('weight' => 0, 'weight_difference' => 0, 'fine' => 0, 'factory_fine' => 0));
      
      $total[$account_name] = parent::get_total_by_created_date($issue_data[$account_name], 'issue', $total['']);
      $total[$account_name] = parent::get_total_by_created_date($receipt_data[$account_name], 'receipt', $total[$account_name]);
      
      $total[$account_name] = parent::set_index_for_dates($total[$account_name]);
    //}
    $this->data['issues'] = $issue_data;
    $this->data['receipts'] = $receipt_data;
    $this->data['total'] = $total;  
    parent::get_balance_by_created_date();
  }      
}
