<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer_vouchers extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }
}