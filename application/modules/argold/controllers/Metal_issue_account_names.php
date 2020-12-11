<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Metal_issue_account_names extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('transactions/metal_issue_voucher_model'));
  }

  public function view($id) {
    redirect(ADMIN_PATH.'argold/voucher_details/view/'.$id);
  }
}