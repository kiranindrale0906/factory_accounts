<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_model extends BaseModel {
  protected $table_name = "ac_ledger";
  protected $id = "id";

  function __construct($data=array()) {
    parent::__construct($data);
  }

  public function set_data($voucher, $router_class, $prefix, $table_name) {
    $ledger_data = array();
    if (in_array($router_class, array('cash_issue_voucher', 'cash_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'cash';
    }
    if (in_array($router_class, array('bank_issue_voucher', 'bank_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'bill';
    }
    if (in_array($router_class, array('metal_issue_voucher', 'metal_receipt_voucher', 'opening_stock_voucher'))) {
      $ledger_data['cash_bill_type'] = 'metal';
    }
    $ledger_data['account_id'] =   @$voucher['account_id'];
    $ledger_data['account_name'] = $voucher['account_name'];
    $ledger_data['voucher_type'] = $voucher['voucher_type'];
    $ledger_data['suffix'] = $prefix;
    $ledger_data['voucher_date'] = $voucher['voucher_date'];
    $ledger_data['credit_amount'] = !empty($voucher['credit_amount']) ? $voucher['credit_amount'] : 0;
    $ledger_data['debit_amount'] = !empty($voucher['debit_amount']) ? $voucher['debit_amount'] : 0;
    $ledger_data['credit_weight'] = !empty($voucher['credit_weight']) ? $voucher['credit_weight'] : 0;
    $ledger_data['debit_weight'] = !empty($voucher['debit_weight']) ? $voucher['debit_weight'] : 0; 
    $ledger_data['narration'] = !empty($voucher['narration']) ? $voucher['narration'] : ''; 
    $ledger_data['table_name'] = $table_name;
    $ledger_data['table_id'] = $voucher['id'];
    $ledger_data['voucher_number'] = $voucher['voucher_number'];
    $ledger_data['company_id'] = $voucher['company_id'];
    $ledger_data['factory_purity'] = !empty($voucher['factory_purity']) ? $voucher['factory_purity'] : 0;
    $ledger_data['purity_margin'] = !empty($voucher['purity_margin']) ? $voucher['purity_margin'] : 0;
    $ledger_data['receipt_type'] = !empty($voucher['receipt_type']) ? $voucher['receipt_type'] : '';
    return $ledger_data;
  }
}