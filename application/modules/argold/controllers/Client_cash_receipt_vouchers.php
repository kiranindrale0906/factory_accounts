<?php  //AR Gold
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/controllers/Core_cash_receipt_vouchers.php";
class Client_cash_receipt_vouchers extends Core_cash_receipt_vouchers {

  public function __construct() {
    parent::__construct();
  }

  public function _get_form_data() {

    //$company_name = $this->company_model->find('name', array('id' => $_SESSION['company_id']))['name'];
    $this->data['account_names_for_cash_issue'] = array(array('id' => '', 'name' => ''));

    $this->data['account_names_for_cash_issue'][] = array('id' => 'AR Gold Software', 'name' => 'AR Gold Software');
    $this->data['account_names_for_cash_issue'][] = array('id' => 'ARF Software', 'name' => 'ARF Software'); 
    $this->data['account_names_for_cash_issue'][] = array('id' => 'ARC Software', 'name' => 'ARC Software'); 
    
    $this->data['record']['receipt_type']=!empty($_GET['receipt_type'])?$_GET['receipt_type']:"";
    parent::_get_form_data(); 
  }
}