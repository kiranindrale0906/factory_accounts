<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Change_account_names extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('argold/chitti_model', 'ac_vouchers/voucher_model'));
  }

  public function index() {
    $chitti_no = isset($_GET['chitti_no']) ? $_GET['chitti_no'] : '';
    if (empty($chitti_no)) return false;

    $chitti = $this->chitti_model->find('', array('id' => $chitti_no));
    if (!empty($chitti) && $chitti['rate'] == 0) {
      $vouchers = $this->voucher_model->get('', array('chitti_id' => $chitti_no));
      foreach ($vouchers as $voucher) {
        $voucher_obj = new voucher_model($voucher);
        $voucher_obj->attributes['account_name'] = 'SWARN SHILP 1';
        $voucher_obj->attributes['account_id'] = 130;
        $voucher_obj->save();
      }

      $chitti_obj = new chitti_model($chitti);
      $chitti_obj->attributes['account_name'] = 'SWARN SHILP 1';
      $chitti_obj->save();

      redirect(base_url().'/argold/chittis/view/'.$chitti_no);
    }

    echo 'Cannot change account name';
  }
}