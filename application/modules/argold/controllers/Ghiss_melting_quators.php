<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ghiss_melting_quators extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model'));
    $this->redirect_after_save = 'view';
  }
  
  public function _after_save($formdata, $action){
    $this->data['redirect_url']= $_SERVER['HTTP_REFERER'];
    return $formdata;
  }
  public function _get_form_data(){
    $this->data['quators']= $this->get_quarter_from_accounts();
  }
}