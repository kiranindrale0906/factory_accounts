<?php  //AR Gold
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/controllers/Core_metal_issue_vouchers.php";
class Client_metal_issue_vouchers extends Core_metal_issue_vouchers {

  public function __construct() {
    parent::__construct();
  }
  public function _get_form_data() {
    $this->data['record']['receipt_type']=!empty($_GET['receipt_type'])?$_GET['receipt_type']:"";
    parent::_get_form_data(); 
  }
}
