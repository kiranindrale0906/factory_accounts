<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_rate_cut_issue_voucher_model extends Voucher_model {

  protected $prefix = 'RCIV';
  protected $voucher_type = 'rate cut issue voucher';   //weight IN, amount OUT
  protected $account_type = 'account';
  
  public $router_class = "rate_cut_issue_vouchers";
  
  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('transactions/rate_cut_receipt_voucher_model'));
  }

  function validation_rules($klass='') {
    $rules = parent::validation_rules($klass);
    $rules[] = $this->get_account_validation_rules();
    $rules[] = $this->get_gold_rate_validation_rules();
    $rules[] = $this->get_gold_rate_purity_validation_rules();
    $rules[] = $this->get_credit_weight_validation_rules();
    $rules[] = $this->get_purity_validation_rules();
    $rules[] = $this->get_debit_amount_validation_rules();
    return $rules;
  }

  function before_validate() {
    $this->attributes['fine'] = $this->attributes['credit_weight'] * $this->attributes['purity'] / 100;
    $this->attributes['factory_purity'] = $this->attributes['purity'];
    $this->attributes['factory_fine'] = $this->attributes['fine'];
    //$this->set_debit_amount();
    parent::before_validate();
  }

  private function set_debit_amount() {
    if ($this->attributes['gold_rate_purity'] == 0) 
      $this->attributes['debit_amount'] = 0;
    else {
      $gold_rate = $this->attributes['gold_rate'] / $this->attributes['gold_rate_purity'] * 100;
      $this->attributes['debit_amount'] = $this->attributes['fine'] * $gold_rate;
    }
  }

  public function create_rate_cut_issue_voucher($chitti_id) {
    $chitti = $this->chitti_model->find('', array('id' => $chitti_id));
    $this->rate_cut_issue_voucher_model->delete('', array('description' => 'Chitti '.$chitti['id'],
                                                          'voucher_type' => 'rate cut issue voucher'));
    $this->rate_cut_receipt_voucher_model->delete('', array('description' => 'Chitti '.$chitti['id'],
                                                          'voucher_type' => 'rate cut receipt voucher'));
    if ($chitti['rate'] == 0) return;
    $rate_cut_issue = array('company_id' => 1,
                            'account_name' => $chitti['account_name'],
                            'voucher_date' => $chitti['created_at'],
                            'debit_amount' => $chitti['debit_amount'],
                            'credit_amount' => 0,
                            'credit_weight' => $chitti['credit_weight'],
                            'debit_weight' => 0,
                            'purity' => $chitti['purity'],
                            'gold_rate' => $chitti['rate'],
                            'gold_rate_purity' => 100,
                            'description' => 'Chitti '.$chitti['id'],
                            'receipt_type' => 'Chitti');
    $rate_cut_issue_voucher_obj = new rate_cut_issue_voucher_model($rate_cut_issue);
    $rate_cut_issue_voucher_obj->before_validate();
    $rate_cut_issue_voucher_obj->store();

    $rate_cut_receipt = $rate_cut_issue;
    $rate_cut_receipt['account_name'] = 'Sales Account';
    $rate_cut_receipt['credit_amount'] = $rate_cut_receipt['debit_amount'];
    $rate_cut_receipt['debit_amount'] = 0;
    $rate_cut_receipt['debit_weight'] = $rate_cut_receipt['credit_weight'];
    $rate_cut_receipt['credit_weight'] = 0;
    $rate_cut_receipt_voucher_obj = new rate_cut_receipt_voucher_model($rate_cut_receipt);
    $rate_cut_receipt_voucher_obj->before_validate();
    $rate_cut_receipt_voucher_obj->store();
  }
}
