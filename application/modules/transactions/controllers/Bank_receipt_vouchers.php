<?php

// defined('BASEPATH') OR exit('No direct script access allowed');
// require APPPATH . "modules/ac_Vouchers/controllers/Vouchers.php";
// class Bank_receipt_voucher extends Vouchers {

//   // protected $suffix = 'BR';
//   // protected $voucher_type = 'bank receipt voucher';
//   // protected $account_type = 'account';
//   public function __construct() {
//     parent::__construct();
//     $this->load->model(array(
//                           'master/Account_model',
//                           'transaction/Ledger_model',
//                           'master/group_model',
//                           'master/company_model',
//                           'master/purity_model'));
//     $this->date_fields=array(
//                           array('bank_receipt_voucher',
//                                 'voucher_date'));
//   }

//   public function _get_dependent_associations() {
//     parent::_get_dependent_associations();
//   }
// }
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "modules/ac_vouchers/controllers/Vouchers.php";
class Bank_receipt_vouchers extends Vouchers {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('bank_receipt_vouchers', 'voucher_date'));
  }

  
}
