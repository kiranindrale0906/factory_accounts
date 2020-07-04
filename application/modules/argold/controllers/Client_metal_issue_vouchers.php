<?php  //AR Gold
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "modules/ac_vouchers/controllers/Core_metal_issue_vouchers.php";
class Client_metal_issue_vouchers extends Core_metal_issue_vouchers {
  
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model'));
  }

  public function index() {

    if(!empty($_GET['alloy_gpc_records'])){
      $url=API_BASE_PATH."issue_and_receipts/alloy_gpc_vodator_ledger/index";
      $records=json_decode(curl_post_request($url));
      if($_GET['alloy_gpc_records']==1){
        $this->metal_issue_voucher_model->create_alloy_vodator_records($records);
      }else{
        $this->metal_issue_voucher_model->create_gpc_vodator_records($records);
      }
      $this->data['redirect_url'] = base_url().'reports/trial_balances';
      redirect( $this->data['redirect_url']);
      die;
    }
    parent::index(); 
   }

  public function _get_form_data() {
    $this->data['record']['receipt_type'] = !empty($_GET['receipt_type'])?$_GET['receipt_type']:"";

    if (isset($_GET['add_more_id'])) {
      $metal_issue_voucher = $this->model->find('', array('id' => $_GET['add_more_id']));
      if (!empty($metal_issue_voucher)) {
        $this->data['record']['account_name'] = $metal_issue_voucher['account_name'];
        $this->data['record']['receipt_type'] = $metal_issue_voucher['receipt_type'];
        $this->data['record']['purity'] = $metal_issue_voucher['purity'];
        $this->data['add_more'] = 'checked';
      }
    }

    parent::_get_form_data(); 
  }

  public function _after_save($formdata, $action) {
    if ($action == 'store') {
      if (isset($formdata['add_more']) && $formdata['add_more'] == 1)
        $this->data['ajax_success_function'] = 'window.location.replace("'.ADMIN_PATH.'transactions/metal_issue_vouchers?add_more_id='.$formdata['metal_issue_vouchers']['id'].'")';
      else
        $this->data['ajax_success_function'] = 'window.location.replace("'.ADMIN_PATH.'transactions/metal_issue_vouchers'.'")';
    }
    return $formdata;
  }
}
