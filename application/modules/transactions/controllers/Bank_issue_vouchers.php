<?php

// defined('BASEPATH') OR exit('No direct script access allowed');
// require APPPATH . "modules/ac_vouchers/controllers/Vouchers.php";
// class Bank_issue_voucher extends Vouchers {

//   // protected $suffix = 'BI';
//   // protected $voucher_type = 'bank issue voucher';
//   // protected $account_type = 'account';
//   public function __construct() {
//     parent::__construct();
//     $this->load->model(array(
//                           'masters/Account_model',
//                           'transactions/Ledger_model',
//                           'masters/group_model',
//                           'masters/company_model',
//                           'masters/purity_model'));
//     $this->date_fields=array(array('bank_issue_voucher',
//                                 'voucher_date'));
//   }

//   public function _get_form_data() {
//     parent::_get_form_data();
//   }
// }


defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "modules/ac_vouchers/controllers/Vouchers.php";
class Bank_issue_vouchers extends Vouchers {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('bank_issue_vouchers', 'voucher_date'));
  }

  
}