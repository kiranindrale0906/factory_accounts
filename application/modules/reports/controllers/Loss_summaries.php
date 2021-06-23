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
}

