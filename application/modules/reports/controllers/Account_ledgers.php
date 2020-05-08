<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_ledgers extends BaseController {  
  public function __construct(){
    $this->_model='Account_ledger_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('reports/account_ledger_model'));
  } 

  public function index() { 
    $this->start_date = (!empty($_GET['start_date'])) ? date('Y-m-d',strtotime($_GET['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['end_date'])) ? date('Y-m-d',strtotime($_GET['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['start_date'])) {
            $where['created_at>='] = $this->start_date;
        }
        if (!empty($_GET['end_date'])) {
            $where['created_at<'] = $this->end_date;
        }
        if (!empty($_GET['account_name'])) {
            $where['account_name'] = $_GET['account_name'];
        }
    
    if(isset($_GET['return']) && $_GET['return'] == 'json')
      echo json_encode($this->data);
    else
    $this->data['account_ledgers'] = $this->account_ledger_model->get('',$where);
    $this->load->render('reports/account_ledgers/index',$this->data); 
  } 

  public function _get_form_data() {
  }

  public function _after_save($formdata, $action){
  }


}
