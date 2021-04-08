<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unrecovarable_account_records extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','transactions/metal_issue_voucher_model','transactions/metal_receipt_voucher_model','masters/account_model'));
  }
  public function store() {
    if(isset($_GET['from']) && $_GET['from']=='view') {
      $process=array(
        'account_name'=>$_GET['account_name'],
        'narration'=>$_GET['narration'],
        'receipt_type'=>$_GET['account_name'],
        'purity'=>100,
        'company_id'=>1,
        'parent_id'=>$_GET['parent_id'],
        'voucher_date'=>date('Y-m-d'),
        'factory_purity'=>100,
        'factory_fine'=>$_GET['credit_weight'],
        'credit_weight'=>$_GET['credit_weight']);
      $issue_obj = new metal_issue_voucher_model($process);
      $issue_obj->before_validate();
      $issue_obj->save(true);

        $process=array(
        'account_name'=>'Loss Account',
        'narration'=>$_GET['narration'],
        'receipt_type'=>$_GET['account_name'],
        'debit_weight'=>$_GET['credit_weight'],
        'purity'=>100,
        'factory_purity'=>100,
        'factory_fine'=>$_GET['credit_weight'],
        // 'description'=>$_GET['description'],
        'company_id'=>1,
        // 'parent_id'=>$_GET['parent_id'],
        'voucher_date'=>date('Y-m-d'));
      $receipt_obj = new metal_receipt_voucher_model($process);
      $receipt_obj->before_validate();
      $receipt_obj->save(true);

      redirect($_SERVER['HTTP_REFERER']);
    } else {
      parent::store();
    }
  }
  public function _after_save($formdata, $action){
    $this->data['redirect_url']= $_SERVER['HTTP_REFERER'];
    return $formdata;
  }
}