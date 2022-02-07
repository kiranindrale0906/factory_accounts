<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'modules/argold/controllers/Chittis.php';

class Api_chittis extends Chittis {
  public function __construct() {
    parent::__construct();
  }
  public function index() {
    if(!empty($_POST['access_token']) && $_POST['access_token']==API_ACCESS_TOKEN){
    $chitti_details = []; 
    $chitti_details['chittis']=$this->api_chitti_model->find('',array('id'=>$_POST['chitti_id']));
    $chitti_details['chitti_details']=$this->voucher_model->get('',array('chitti_id'=>$_POST['chitti_id'],'voucher_type'=>"metal issue voucher"));
    
    echo json_encode(array('data'    =>$chitti_details,
                         'status'      => 'success',
                         'open_modal'  => FALSE));die;
  }else{
    echo json_encode(array('status'      => 'error',
                         'open_modal'  => FALSE));die;
  }
}
}