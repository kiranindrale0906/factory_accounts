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
    $this->load->model(array('argold/chitti_domestic_model','transactions/cash_receipt_voucher_model'));
  }
  public function create_cash_vouchers_for_chitti($chitti_id, $amount) {
    $chitti = $this->chitti_domestic_model->find('', array('id' => $chitti_id));

    $this->cash_issue_voucher_model->delete('', array('description' => 'Domestic Chitti '.$chitti['id'], 'voucher_type' => 'cash issue voucher'));
    $this->cash_receipt_voucher_model->delete('', array('description' => 'Domestic Chitti '.$chitti['id'],'voucher_type' => 'cash receipt voucher'));

    $cash_receipt = array('company_id' => 1,
                          'account_name' => 'Domestic Labour Amount', //$chitti['account_name'],
                          'voucher_date' => $chitti['created_at'],
                          'debit_amount' => $amount * 1.05,
                          'credit_amount' => 0,
                          //'debit_weight' => $chitti['credit_weight'],
                          'credit_weight' => 0,
                          'purity' => 100,
                          'taxable_amount' => $amount,
                          'cgst_amount' => $amount * 0.05,
                          'sgst_amount' => $amount * 0.05,
                          'gold_rate_purity' => 100,
                          'description' => 'Domestic Chitti '.$chitti['id'],
                          'receipt_type' => 'Domestic Chitti',
                          'chitti_id' => $chitti_id);

    $cash_receipt_voucher_obj = new cash_receipt_voucher_model($cash_receipt);
    $cash_receipt_voucher_obj->before_validate();
    $cash_receipt_voucher_obj->store();

    $cash_issue = $cash_receipt;
    $cash_issue['account_name'] = $chitti['account_name'];
    $cash_issue['credit_amount'] = $amount * 1.05;
    $cash_issue['debit_amount'] = 0;
    $cash_issue['credit_weight'] = 0;
    $cash_issue['debit_weight'] = 0;
    $cash_issue['taxable_amount'] =  $amount;
    $cash_issue['cgst_amount'] = $amount * 0.05;
    $cash_issue['sgst_amount'] = $amount * 0.05;
    //$cash_issue['gold_rate'] =  $chitti['rate'];
    $cash_issue['gold_rate_purity'] = 100;
    $cash_issue['description'] = 'Domestic Chitti '.$chitti['id'];
    $cash_issue_voucher_obj = new cash_issue_voucher_model($cash_issue);
    $cash_issue_voucher_obj->before_validate();
    $cash_issue_voucher_obj->store();
  }

}