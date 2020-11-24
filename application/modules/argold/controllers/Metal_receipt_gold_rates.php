<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Metal_receipt_gold_rates extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('transactions/metal_receipt_voucher_model'));
  }

  public function view($id) {
    redirect(ADMIN_PATH.'transactions/metal_receipt_vouchers');
  }
}