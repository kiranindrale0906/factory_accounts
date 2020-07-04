<?php  //AR Gold
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/controllers/Core_metal_receipt_vouchers.php";
class Client_metal_receipt_vouchers extends Core_metal_receipt_vouchers {

  public function __construct() {
    parent::__construct();
  }

  public function _get_form_data() {
    $company_name = $this->company_model->find('name', array('id' => $_SESSION['company_id']))['name'];
  	$this->data['account_names_for_metal_issue'] = array(array('id' => '', 'name' => ''));

    //if ($company_name != 'AR Gold')
    //  $this->data['account_names_for_metal_issue'][] = array('id' => 'AR Gold', 'name' => 'AR Gold');

    //if ($company_name != 'ARC')
      $this->data['account_names_for_metal_issue'][] = array('id' => 'ARC', 'name' => 'ARC');

    //if ($company_name != 'ARF')
      $this->data['account_names_for_metal_issue'][] = array('id' => 'ARF', 'name' => 'ARF'); 
      $this->data['account_names_for_metal_issue'][] = array('id' => 'ARF Software', 'name' => 'ARF Software'); 
    
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARC Finished Goods', 'name' => 'ARC Finished Goods');
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARF Finished Goods', 'name' => 'ARF Finished Goods');   

    $this->data['record']['receipt_type']=!empty($_GET['receipt_type'])?$_GET['receipt_type']:"";
    parent::_get_form_data(); 
  }
}