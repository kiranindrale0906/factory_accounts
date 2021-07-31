<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_cash_issue_voucher_model extends Voucher_model {

  protected $prefix = 'CI';
  protected $voucher_type = 'cash issue voucher';
  protected $account_type = 'account';
  protected $insert_to_ledger = true; 

  public $router_class = "cash_issue_vouchers";

  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('argold/domestic_labour_chitty_model','transactions/cash_receipt_voucher_model'));
  }
  public function create_cash_vouchers_for_chitti($chitti_id) {
    $chitti = $this->domestic_labour_chitty_model->find('', array('id' => $chitti_id));
    $this->cash_issue_voucher_model->delete('', array('description' => 'Domestic Labour Chitti '.$chitti['id'], 'voucher_type' => 'cash issue voucher'));

    $this->cash_receipt_voucher_model->delete('', array('description' => 'Domestic Labour Chitti '.$chitti['id'],'voucher_type' => 'cash receipt voucher'));
    $cash_receipt = array('company_id' => 1,
                          'account_name' => $chitti['account_name'],
                          'voucher_date' => $chitti['created_at'],
                          'credit_amount' => $chitti['debit_amount'],
                          'debit_amount' => 0,
                          'debit_weight' => $chitti['credit_weight'],
                          'credit_weight' => 0,
                          'purity' => 100,
                          'taxable_amount' => $chitti['taxable_amount'],
                          'cgst_amount'=>$chitti['cgst_amount'],
                          'sgst_amount'=>$chitti['sgst_amount'],
                          'gold_rate_purity' => 100,
                          'description' => 'Domestic Labour Chitti '.$chitti['id'],
                          'receipt_type' => 'Domestic Labour Chitti',
                          'chitti_id' => $chitti_id);

    $cash_receipt_voucher_obj = new cash_receipt_voucher_model($cash_receipt);
    $cash_receipt_voucher_obj->before_validate();
    $cash_receipt_voucher_obj->store();

    $cash_issue = $cash_receipt;
    $cash_issue['account_name'] = 'DOMESTIC LABOUR ACCOUNT';
    $cash_issue['debit_amount'] = $chitti['debit_amount'];
    $cash_issue['credit_amount'] = 0;
    $cash_issue['credit_weight'] = $chitti['credit_weight'];
    $cash_issue['debit_weight'] = 0;
    $cash_issue['taxable_amount'] =  $chitti['taxable_amount'];
    $cash_issue['cgst_amount'] = $chitti['cgst_amount'];
    $cash_issue['sgst_amount'] = $chitti['sgst_amount'];
    $cash_issue['gold_rate'] =  $chitti['rate'];
    $cash_issue['gold_rate_purity'] = 100;
    $cash_issue['description'] = 'Domestic Labour Chitti '.$chitti['id'];
    $cash_issue_voucher_obj = new cash_issue_voucher_model($cash_issue);
    $cash_issue_voucher_obj->before_validate();
    $cash_issue_voucher_obj->store();
  }

}