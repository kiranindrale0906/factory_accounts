<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qr_api extends BaseController { 
  public function __construct(){
    $this->_model='qr_api_model';
    parent::__construct();
    // $this->redirect_after_save = 'view';
    $this->load->model(array('qr_codes/qr_code_detail_model','qr_codes/qr_code_model'));
    $this->data['file_data'] = array(array('file_field_name'=>'image',
                                           'file_controller'=>'qr_code_details'));
  } 


   
  public function view($id) { 
    $this->data['qr_code_details']=$this->qr_code_detail_model->get('',array('id'=>$id));  
    $this->load->view('qr_codes/qr_codes/qr_code', $this->data);
  }
}
