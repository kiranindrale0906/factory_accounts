<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Change_account_names extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('argold/chitti_model', 'ac_vouchers/voucher_model'));
  }

  public function index() {
    $chitti_no = isset($_GET['chitti_no']) ? $_GET['chitti_no'] : '';

    $chitti = $this->chitti_model->find('', array('id' => $chitti_no));
    $metal_receipt_voucher = $this->voucher_model->find('', array('voucher_type' => 'metal receipt voucher',
                                                                  'id' => $chitti_no));
    $metal_issue_voucher = $this->voucher_model->find('', array('voucher_type' => 'metal issue voucher',
                                                                'id' => $chitti_no));
    
    if (empty($chitti) && empty($metal_receipt_voucher) && empty($metal_issue_voucher)) return false;
    if (!empty($chitti) && $chitti['rate'] > 0) return false;
    if (!empty($metal_receipt_voucher) && $metal_receipt_voucher['gold_rate'] > 0) return false;
    if (!empty($metal_issue_voucher) && $metal_issue_voucher['gold_rate'] > 0) return false;

    if (!empty($chitti))
      $vouchers = $this->voucher_model->get('', array('chitti_id' => $chitti_no));
    elseif (!empty($metal_receipt_voucher) || !empty($metal_issue_voucher))
      $vouchers = $this->voucher_model->get('', array('id' => $chitti_no));

    foreach ($vouchers as $voucher) {
      $voucher_obj = new voucher_model($voucher);
      $voucher_obj->attributes['account_name'] = 'SWARN SHILP 1';
      $voucher_obj->attributes['account_id'] = 130;
      $voucher_obj->save();
    }

    if (!empty($chitti)) {
      $chitti_obj = new chitti_model($chitti);
      $chitti_obj->attributes['account_name'] = 'SWARN SHILP 1';
      $chitti_obj->save();

      redirect(base_url().'/argold/chittis/view/'.$chitti_no);
    } elseif (!empty($metal_receipt_voucher) || !empty($metal_issue_voucher))
      redirect(base_url().'argold/voucher_details/view/'.$chitti_no);

    echo 'Cannot change account name';
  }
}