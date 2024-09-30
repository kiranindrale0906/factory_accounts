<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chitti_actual_weights extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('transactions/metal_issue_voucher_model'));
  }

  public function view($id) {
    if ($this->router->class == 'chitti_erps')
      redirect(ADMIN_PATH.'argold/chitti_erps');
    else
      redirect(ADMIN_PATH.'argold/chittis');
  }
}