<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chitti_actual_weights extends BaseController {
  public function __construct() {
    parent::__construct();
    //$this->redirect_after_save = 'view';
    $this->load->model(array('transactions/metal_issue_voucher_model'));
  }

  public function _after_save($formdata, $action) {
    //pd($formdata);
    if ($formdata['actual_weight_factory'] == 'chitti_exports')
      $this->data['redirect_url']= ADMIN_PATH.'argold/chitti_exports';
    elseif ($formdata['actual_weight_factory'] == 'chitti_erps')
      $this->data['redirect_url']= ADMIN_PATH.'argold/chitti_erps';
    elseif ($formdata['actual_weight_factory'] == 'chitti_domestics')
      $this->data['redirect_url']= ADMIN_PATH.'argold/chitti_domestics';
    else
      $this->data['redirect_url']= ADMIN_PATH.'argold/chittis';
    
    return $formdata;
  }
}