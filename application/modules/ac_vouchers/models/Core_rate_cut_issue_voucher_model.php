<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/models/Voucher_model.php";
class Core_rate_cut_issue_voucher_model extends Voucher_model {

  protected $prefix = 'RCIV';
  protected $voucher_type = 'rate cut issue voucher'; //weight OUT, amount IN
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
    if($this->attributes['do_not_calculate_tax']==1){

    }
    parent::before_validate();
  }

  // private function set_debit_amount() {
  //   if ($this->attributes['gold_rate_purity'] == 0) 
  //     $this->attributes['debit_amount'] = 0;
  //   else {
  //     $gold_rate = $this->attributes['gold_rate'] / $this->attributes['gold_rate_purity'] * 100;
  //     $this->attributes['debit_amount'] = $this->attributes['fine'] * $gold_rate;
  //   }
  // }

  public function create_rate_cut_vouchers_for_chitti($chitti_id) {

    $chitti = $this->chitti_model->find('', array('id' => $chitti_id));
    $this->rate_cut_issue_voucher_model->delete('', array('description' => 'Chitti '.$chitti['id'],
                                                          'voucher_type' => 'rate cut issue voucher'));
    $this->rate_cut_receipt_voucher_model->delete('', array('description' => 'Chitti '.$chitti['id'],
                                                            'voucher_type' => 'rate cut receipt voucher'));
     $tax_fields = get_tax_fields($chitti['factory_fine'], $chitti['fine'], $chitti['sale_type'], $chitti['rate'], $chitti['purity'],$chitti['created_at']);

    if ($chitti['rate'] == 0 && $chitti['ounce_rate'] == 0) return;

    $is_export = 0;
    if ($chitti['ounce_rate'] > 0) {
      $chitti['rate'] = (!empty($chitti['credit_weight'])&&$chitti['credit_weight']!=0)?$chitti['debit_amount'] / $chitti['credit_weight']:0;
      $is_export = 1;
      $tax_fields['taxable_amount'] = $chitti['debit_amount'];
    }

    $rate_cut_receipt = array('company_id' => 1,
                              'account_name' => $chitti['account_name'],
                              'voucher_date' => $chitti['created_at'],
                              'credit_amount' => $chitti['debit_amount'],
                              'debit_amount' => 0,
                              'debit_weight' => $chitti['credit_weight'],
                              'credit_weight' => 0,
                              'purity' => 100,
                              'sale_type' => $chitti['sale_type'],
                              'taxable_amount' => $tax_fields['taxable_amount'],
                              'usd_credit_amount' => ($chitti['premium_usd_amount']+$chitti['labour_usd_amount']+$chitti['freight_usd_amount']+$chitti['taxable_usd_amount']),
                              'cgst_amount'=>$tax_fields['cgst_amount'],
                              'sgst_amount'=>$tax_fields['sgst_amount'],
                              'tcs_amount'=>$tax_fields['tcs_amount'],
                              'hallmark_amount'=>$chitti['hallmark_amount'],
                              'hallmark_rate'=>$chitti['hallmark_rate'],
                              'hallmark_quantity'=>$chitti['hallmark_quantity'],
                              'gold_rate' => $chitti['rate'],
                              'gold_rate_purity' => 100,
                              'description' => 'Chitti '.$chitti['id'],
                              'receipt_type' => 'Chitti',
                              'is_export'  => $is_export,
                              'chitti_id' => $chitti_id);
    $rate_cut_receipt_voucher_obj = new rate_cut_receipt_voucher_model($rate_cut_receipt);
    $rate_cut_receipt_voucher_obj->before_validate();
    $rate_cut_receipt_voucher_obj->store();

    $rate_cut_issue = $rate_cut_receipt;
    $rate_cut_issue['account_name'] = 'SALES ACCOUNT';
    $rate_cut_issue['debit_amount'] = $chitti['debit_amount'];
    $rate_cut_issue['credit_amount'] = 0;
    $rate_cut_issue['credit_weight'] = $chitti['credit_weight'];
    $rate_cut_issue['debit_weight'] = 0;
    $rate_cut_issue['sale_type'] =  $chitti['sale_type'];
    $rate_cut_issue['taxable_amount'] =  $tax_fields['taxable_amount'];
    $rate_cut_issue['usd_debit_amount'] = ($chitti['premium_usd_amount']+$chitti['labour_usd_amount']+$chitti['freight_usd_amount']+$chitti['taxable_usd_amount']);
    
    $rate_cut_issue['cgst_amount'] = $tax_fields['cgst_amount'];
    $rate_cut_issue['sgst_amount'] = $tax_fields['sgst_amount'];
    $rate_cut_issue['tcs_amount'] = $tax_fields['tcs_amount'];
    $rate_cut_issue['hallmark_amount'] = $chitti['hallmark_amount'];
    $rate_cut_issue['hallmark_rate'] = $chitti['hallmark_rate'];
    $rate_cut_issue['hallmark_quantity'] = $chitti['hallmark_quantity'];
    $rate_cut_issue['gold_rate'] =  $chitti['rate'];
    $rate_cut_issue['gold_rate_purity'] = 100;
    $rate_cut_issue['description'] = 'Chitti '.$chitti['id'];
    $rate_cut_issue['is_export'] = $is_export;
    $rate_cut_issue_voucher_obj = new rate_cut_issue_voucher_model($rate_cut_issue);
    $rate_cut_issue_voucher_obj->before_validate();
    $rate_cut_issue_voucher_obj->store();
  }

  public function create_rate_cut_vouchers_for_metal_and_refresh($metal_receipt_voucher_id, $receipt_type) {
    $metal_receipt_voucher = $this->metal_receipt_voucher_model->find('', array('id' => $metal_receipt_voucher_id));
    $this->rate_cut_issue_voucher_model->delete('', array('description' => $receipt_type.' '.$metal_receipt_voucher['voucher_number'],
                                                          'voucher_type' => 'rate cut issue voucher'));
    $this->rate_cut_receipt_voucher_model->delete('', array('description' => $receipt_type.' '.$metal_receipt_voucher['voucher_number'],
                                                            'voucher_type' => 'rate cut receipt voucher'));

    if ($metal_receipt_voucher['gold_rate'] == 0 && $metal_receipt_voucher['hallmark_rate'] == 0) return;

    if (   $metal_receipt_voucher['account_name'] == 'Dip R/d' 
        || $metal_receipt_voucher['account_name'] == 'Pen R/d') {
      $metal_receipt_voucher['is_export'] = 1;
    }

    $tax_fields = get_tax_fields($metal_receipt_voucher['factory_fine'], $metal_receipt_voucher['fine'], $metal_receipt_voucher['sale_type'], $metal_receipt_voucher['gold_rate'], $metal_receipt_voucher['gold_rate_purity'],$metal_receipt_voucher['created_at'], $metal_receipt_voucher['is_export'], $metal_receipt_voucher['do_not_calculate_tax'], $metal_receipt_voucher['hallmark_rate'], $metal_receipt_voucher['hallmark_quantity']);

    $rate_cut_issue = array('company_id'    => 1,
                            'account_name'  => $metal_receipt_voucher['account_name'],
                            'voucher_date'  => $metal_receipt_voucher['created_at'],
                            'debit_amount'  => $tax_fields['grand_total'],
                            'credit_amount' => 0,
                            'credit_weight' => $tax_fields['weight'],
                            'debit_weight'  => 0,
                            'purity'        => 100,
                            'sale_type'     => $metal_receipt_voucher['sale_type'],
                            'taxable_amount' => $tax_fields['taxable_amount'],
                            'cgst_amount'   => $tax_fields['cgst_amount'],
                            'sgst_amount'   => $tax_fields['sgst_amount'],
                            'tcs_amount'    => $tax_fields['tcs_amount'],
                            'gold_rate'     => $tax_fields['gold_rate'],
                            'gold_rate_purity' => $tax_fields['gold_rate_purity'],
                            'description'   => $receipt_type.' '.$metal_receipt_voucher['voucher_number'],
                            'receipt_type'  => $receipt_type,
                            'is_export'  => $metal_receipt_voucher['is_export'],
                            'metal_receipt_voucher_reference_id' => $metal_receipt_voucher['id'],
                            'site_name'     => $metal_receipt_voucher['site_name']);
    $rate_cut_issue_voucher_obj = new rate_cut_issue_voucher_model($rate_cut_issue);
    $rate_cut_issue_voucher_obj->before_validate();
    $rate_cut_issue_voucher_obj->store();

    $rate_cut_receipt = $rate_cut_issue;
    $purchase_acccount_name = 'PURCHASE ACCOUNT';
    if ($metal_receipt_voucher['account_name'] == 'Dip R/d' || $metal_receipt_voucher['account_name'] == 'Pen R/d' || $metal_receipt_voucher['account_name'] == 'RODIUM')
      $purchase_acccount_name = 'R/D PURCHASE ACCOUNT';
    $rate_cut_receipt['account_name']  = $purchase_acccount_name;
    $rate_cut_receipt['credit_amount'] = $tax_fields['grand_total'];
    $rate_cut_receipt['debit_amount']  = 0;
    $rate_cut_receipt['debit_weight']  = $tax_fields['weight'];
    $rate_cut_receipt['credit_weight'] = 0;
    $rate_cut_receipt['sale_type'] = $metal_receipt_voucher['sale_type'];
    $rate_cut_receipt['taxable_amount'] = $tax_fields['taxable_amount'];
    $rate_cut_receipt['cgst_amount'] = $tax_fields['cgst_amount'];
    $rate_cut_receipt['sgst_amount'] = $tax_fields['sgst_amount'];
    $rate_cut_receipt['tcs_amount'] = $tax_fields['tcs_amount'];
    $rate_cut_receipt['gold_rate'] = $tax_fields['gold_rate'];
    $rate_cut_receipt['gold_rate_purity'] = $tax_fields['gold_rate_purity'];
    
    $rate_cut_receipt_voucher_obj = new rate_cut_receipt_voucher_model($rate_cut_receipt);
    $rate_cut_receipt_voucher_obj->before_validate();
    $rate_cut_receipt_voucher_obj->store();
  }
}
