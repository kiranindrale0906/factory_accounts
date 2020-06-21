<?php  //AR Gold
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/controllers/Core_metal_issue_vouchers.php";
class Client_metal_issue_vouchers extends Core_metal_issue_vouchers {

  public function __construct() {
    parent::__construct();
  }
}
