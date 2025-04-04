<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "modules/reports/controllers/Ledgers.php";
class Account_ledgers extends Ledgers {

  public function __construct() {
    parent::__construct();
    ini_set("memory_limit","500M");
    $this->load->model(array('masters/account_model', 'transactions/ledger_model'));
  }

  public function index() {
    $this->data['report_type'] = 'Account Ledger';
    $this->_get_form_data();
    $this->load->render($this->router->class."/index",$this->data);
  }

  public function create() {
    ini_set('max_execution_time', '0');
    if(!empty($_GET['limit_date'])){
      $limit_date=$_GET['limit_date'];
    }
    $this->ledger_model->regenerate_ledger_records($limit_date);
  }

  public function _get_form_data() {
    $this->data['voucher_dates']=array();
    $this->data['account_names'] = $this->account_model->get('distinct(ac_account.name) as name, ac_account.id as id',
                                                              array('where' => array('ac_account.name!=""' => '')),
                                                              array(),
                                                              array('order_by' => 'ac_account.name asc'));
    $account_id = (!empty($_GET['account_ledgers']['account_id'])) ? $_GET['account_ledgers']['account_id'] : 0;
if(!empty($_GET['account_ledgers']['account_id'])){
$account_id =$_GET['account_ledgers']['account_id'];
}elseif(!empty($_GET['account_id'])){
$account_id =$_GET['account_id'];
}else{
$account_id =0;
}
   $accounts=$this->account_model->find('name',array('id'=>$account_id));
    $this->data['account_id'] = $account_id;  
   $this->data['sales_types'] = $this->voucher_model->get('distinct(ac_vouchers.sale_type) as name, ac_vouchers.sale_type as id',
                                                              array('where' => array('ac_vouchers.sale_type!=""' => '')),
                                                              array(),
                                                              array('order_by' => 'ac_vouchers.sale_type asc'));
   $this->data['sales_types']=array_unique(array_column($this->data['sales_types'],'name'));
      
    $sale_type = (!empty($_GET['account_ledgers']['sale_type'])) ? $_GET['account_ledgers']['sale_type'] :'';
   $this->data['sale_type'] = $sale_type;  
    if ($this->data['account_id'] != 0)
      $this->get_datewise_ledger_records();
    $this->data['account_name'] = !empty($accounts['name'])?$accounts['name']:"";  
}
}
