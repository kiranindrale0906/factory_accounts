<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "modules/transaction/controllers/Accounts_voucher.php";
class Contra_voucher extends Accounts_voucher {

  protected $suffix = 'CV';
  protected $voucher_type = 'contra voucher';
  protected $account_type = 'account';
  public function __construct() {
    parent::__construct();
    $this->load->model(array(
                          'master/Account_model',
                          'transaction/Ledger_model',
                          'master/group_model',
                          'master/company_model',
                          'master/purity_model'));
    $this->date_fields=array(
                          array('contra_voucher',
                                'voucher_date'));
  }

  public function _get_dependent_associations() {
    parent::_get_dependent_associations();
  }
}
