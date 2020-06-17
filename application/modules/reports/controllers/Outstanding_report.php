<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outstanding_report extends BaseController {  
  public function __construct(){
    $this->_model='outstanding_report_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('reports/account_ledger_model'));
  } 

  public function index() { 
    $this->data['outstanding_report'] = $this->account_ledger_model->get('',array(),array(),array('group_by'=>''));
    $this->load->render('reports/outstanding_report/index',$this->data); 
  } 

  public function _get_form_data() {
  }

  public function _after_save($formdata, $action){
  }


}
