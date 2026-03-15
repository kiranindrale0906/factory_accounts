<?php  //AR Gold
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/controllers/Core_cash_issue_vouchers.php";
class Client_cash_issue_vouchers extends Core_cash_issue_vouchers {
  
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));
  }

  public function _get_form_data() {
    $this->data['record']['receipt_type'] = !empty($_GET['receipt_type'])?$_GET['receipt_type']:"";

    if (isset($_GET['add_more_id'])) {
      $cash_issue_voucher = $this->model->find('', array('id' => $_GET['add_more_id']));
      if (!empty($cash_issue_voucher)) {
        $this->data['record']['account_name'] = $cash_issue_voucher['account_name'];
        $this->data['record']['receipt_type'] = $cash_issue_voucher['receipt_type'];
        $this->data['record']['purity'] = $cash_issue_voucher['purity'];
        $this->data['add_more'] = 'checked';
      }
    }

    parent::_get_form_data(); 
  }

  public function _after_save($formdata, $action) {
    if ($action == 'store') {
      if (isset($formdata['add_more']) && $formdata['add_more'] == 1)
        $this->data['ajax_success_function'] = 'window.location.replace("'.ADMIN_PATH.'transactions/cash_issue_vouchers?add_more_id='.$formdata['cash_issue_vouchers']['id'].'")';
      else
        $this->data['ajax_success_function'] = 'window.location.replace("'.ADMIN_PATH.'transactions/cash_issue_vouchers'.'")';
    }
    return $formdata;
  }
}
