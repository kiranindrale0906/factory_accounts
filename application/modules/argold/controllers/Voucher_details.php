<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_details extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model','masters/narration_model'));
  }

  public function _get_view_data() {
    // pd($this->data['record']['id']);
    $this->data['account_id']='';
    $this->data['metal_vouchers'] = $this->voucher_model->get('',array('id'=>$this->data['record']['id']));
    $this->data['metal_voucher_details'] = $this->voucher_model->get('',array('metal_receipt_voucher_reference_id'=>$this->data['record']['id']));
  }
}