<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chittis extends BaseController {
  public function __construct() {
    parent::__construct();
    //$this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model'));
  }
  
  public function view($id) {
    $this->data['layout'] = 'plain';
    parent::view($id);
  }

  public function _get_view_data() {
    $this->data['account_id']='';
    $this->data['metal_vouchers'] = $this->voucher_model->get('', array('voucher_type'=>'metal issue voucher',
                                                                        'chitti_id'=>$this->data['record']['id']));
    $this->data['metal_voucher_details'] = $this->voucher_model->find('voucher_number,narration,account_name', 
                                                                            array('voucher_type'=>'metal issue voucher',
                                                                                  'chitti_id'=>$this->data['record']['id']));
    if(!empty($this->data['metal_voucher_details']['account_name']))
      $this->data['account_id'] = $this->account_model->find('id',array('name'=>$this->data['metal_voucher_details']['account_name']))['id'];
  }

  public function _get_form_data() {
    if (!empty($_GET['account_name']))
      $this->data['record']['account_name'] = $_GET['account_name'];

    $where=array('voucher_type'=>'metal issue voucher','chitti_id'=>'');
    if(!empty($this->data['record']['account_name'])){
      $where['account_name']=$this->data['record']['account_name'];
      $this->data['metal_vouchers'] = $this->voucher_model->get('',$where);
    } else {
      $this->data['metal_vouchers'] = array();
    }
    
    if ($this->router->method == 'store' || $this->router->method == 'update') {
      $this->data['record']['chittis'] = $_POST['chittis'];
      $this->data['chittis_details'] = @$_POST['chittis_details'];
    }
  }
}