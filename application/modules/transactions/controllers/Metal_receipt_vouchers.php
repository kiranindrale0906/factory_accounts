<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "modules/".CLIENT_NAME."/controllers/Metal_receipt_voucher_clients.php";
class Metal_receipt_vouchers extends Metal_receipt_voucher_clients {
  public function __construct() {
    parent::__construct();
    $this->date_fields=array(array('metal_receipt_vouchers','voucher_date'));
    $this->load->model(array('masters/department_category_model','masters/purity_model','masters/setting_model'));
  }

  public function _get_form_data() {
    $company_name = $this->company_model->find('name', array('id' => $_SESSION['company_id']))['name'];
  	$this->data['account_names_for_metal_issue'] = array(array('id' => '', 'name' => ''));

    if ($company_name != 'AR Gold')
      $this->data['account_names_for_metal_issue'][] = array('id' => 'AR Gold', 'name' => 'AR Gold');

    if ($company_name != 'ARC')
      $this->data['account_names_for_metal_issue'][] = array('id' => 'ARC', 'name' => 'ARC');

    if ($company_name != 'ARF')
      $this->data['account_names_for_metal_issue'][] = array('id' => 'ARF', 'name' => 'ARF');   

    parent::_get_form_data(); 
  }
}