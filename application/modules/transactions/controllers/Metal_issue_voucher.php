<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "modules/transaction/controllers/Accounts_voucher.php";
class Metal_issue_voucher extends Accounts_voucher {

  protected $suffix = 'MI';
  protected $voucher_type = 'metal issue voucher';
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
                          array('metal_issue_voucher',
                                'voucher_date'));
  }

  public function _get_dependent_associations() {
    parent::_get_dependent_associations();
  }
}
