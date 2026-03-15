<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bw_accounts extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function _get_form_data() {

  }
}
