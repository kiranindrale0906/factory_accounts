<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Opening_balance extends BaseController {
  public $company_id=1;
  private $suffix = 'OB';
  private $_voucher_type = 'outstanding voucher';
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model','masters/group_model','masters/cash_bill_model'));
    $this->date_fields=array(array('opening_balance','date'));
  }
  public function _get_form_data() {
    $company_id=!empty($_SESSION['company_id'])?$_SESSION['company_id']:1;
    }
}
