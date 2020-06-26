<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chittis extends BaseController {
  public function __construct() {
    parent::__construct();
     $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model'));
  }
  

   public function _get_form_data() {
     $this->data['record']['account_name']=!empty($_GET['account_name'])?$_GET['account_name']:"";
      $where=array('voucher_type'=>'metal issue voucher','chitti_id'=>'');
     if(!empty($this->data['record']['account_name'])){
      $where['account_name']=$this->data['record']['account_name'];
     }
   
    $this->data['metal_vouchers'] = $this->voucher_model->get('',$where);
    if ($this->router->method == 'store' || $this->router->method == 'update') {
      $this->data['record']['chittis'] = $_POST['chittis'];
      $this->data['chittis_details'] = @$_POST['chittis_details'];
    }
  }
   public function _get_view_data() {
    $this->data['metal_vouchers'] = $this->voucher_model->get('',array('voucher_type'=>'metal issue voucher','chitti_id'=>$this->data['record']['id']));
    $this->data['metal_voucher_details'] = $this->voucher_model->find('voucher_number,narration',array('voucher_type'=>'metal issue voucher','chitti_id'=>$this->data['record']['id']));

  }
}