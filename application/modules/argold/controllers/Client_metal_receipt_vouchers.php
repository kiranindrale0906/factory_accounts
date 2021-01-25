<?php  //AR Gold
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/ac_vouchers/controllers/Core_metal_receipt_vouchers.php";
class Client_metal_receipt_vouchers extends Core_metal_receipt_vouchers {

  public function __construct() {
    parent::__construct();
  }

  public function _get_form_data() {
    $company_id=!empty($_SESSION['company_id'])?$_SESSION['company_id']:1;
    $company_name = $this->company_model->find('name', array('id' => $company_id))['name'];
    $re = $this->company_model->find('name', array('id' => $company_id))['name'];
    $this->data['record']['parent_id']=!empty($_GET['parent_id'])?$_GET['parent_id']:0;
  	$this->data['account_names_for_metal_issue'] = array(array('id' => '', 'name' => ''));
    $this->data['record']['receipt_type']=!empty($_GET['receipt_type'])?$_GET['receipt_type']:"";

    $this->data['account_names_for_metal_issue'][] = array('id' => 'AR Gold Software', 'name' => 'AR Gold Software');
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARC Software', 'name' => 'ARC Software');
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARF Software', 'name' => 'ARF Software'); 
    if($this->data['record']['receipt_type']=='Metal'){
    $this->data['account_names_for_metal_issue'][] = array('id' => 'AR Gold Nov 2020', 'name' => 'AR Gold Nov 2020');
    $this->data['account_names_for_metal_issue'][] = array('id' => 'AR Gold JAN 2021', 'name' => 'AR Gold JAN 2021');
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARC Nov 2020', 'name' => 'ARC Nov 2020');
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARC JAN 2021', 'name' => 'ARC JAN 2021');
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARF Nov 2020', 'name' => 'ARF Nov 2020'); 
    $this->data['account_names_for_metal_issue'][] = array('id' => 'ARF JAN 2021', 'name' => 'ARF JAN 2021'); 
    }

    $this->data['refresh_id']=!empty($_GET['refresh_id'])?$_GET['refresh_id']:"";
    if(!empty($this->data['refresh_id'])){
      $refresh_data=$this->refresh_model->find('', array('id' => $this->data['refresh_id']));
      $this->data['record']['debit_weight']=!empty($refresh_data['weight'])?$refresh_data['weight']:"";
      $this->data['record']['factory_purity']=!empty($refresh_data['factory_purity'])?$refresh_data['factory_purity']:"";
      $this->data['record']['fine']=!empty($refresh_data['fine'])?$refresh_data['fine']:"";
      $this->data['record']['purity']=!empty($refresh_data['purity'])?$refresh_data['purity']:"";
      $this->data['record']['factory_fine']=!empty($refresh_data['factory_fine'])?$refresh_data['factory_fine']:"";
    }
    parent::_get_form_data(); 
  }

  public function _after_save($formdata, $action) {
    $this->data['ajax_success_function'] = 'window.location.replace("'.ADMIN_PATH.'transactions/metal_receipt_vouchers'.'")';
    return $formdata;
  }
}