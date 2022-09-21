<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/argold/controllers/Chittis.php";
class Chitti_domestics extends Chittis {
  public function __construct() {
    parent::__construct();
    $this->_model = array('chitti_model' => 'chitti_domestic_model'); 
    $this->date_fields = array(array('chittis', 'date'));
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model','argold/chitti_model','masters/narration_model'));
  }
 
  public function index() {
    if (isset($_GET['id'])) {
      $this->load->model(array('transactions/cash_issue_voucher_model'));
      $this->cash_issue_voucher_model->create_cash_vouchers_for_chitti($_GET['id']);
    }
    parent::index();
  } 
}