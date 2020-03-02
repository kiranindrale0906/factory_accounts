<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Design extends BaseController {

  public function __construct() {
      parent::__construct();
      // if (!$this->authentication->is_user_logged_in()) {
      //     redirect('auth');
      // }

      // if (!$this->authentication->is_user_role_map('cash_issue_voucher')) {
      //     redirect($_SERVER['HTTP_REFERER']);
      //     exit();
      // }
      //$this->load->model('master/groups_model');
  }

}
