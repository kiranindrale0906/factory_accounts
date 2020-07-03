<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chittis extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model','masters/narration_model'));
  }
  
  public function view($id) {
    $this->data['layout'] = 'plain';
    parent::view($id);
  }

  public function _get_view_data() {
    // pd($this->data['record']['id']);
    $this->data['account_id']='';
    $this->data['metal_vouchers'] = $this->voucher_model->get('', array('voucher_type'=>'metal issue voucher',
                                                                        'chitti_id'=>$this->data['record']['id']));
    $this->data['metal_voucher_details'] = $this->voucher_model->get('', array('voucher_type'=>'metal issue voucher',
                                                                               'chitti_id'=>$this->data['record']['id']));
    if(!empty($this->data['metal_voucher_details']['account_name']))
      $this->data['account_id'] = $this->account_model->find('id',array('name'=>$this->data['metal_voucher_details']['account_name']))['id'];

    foreach ($this->data['metal_voucher_details'] as $index => $metal_voucher_detail) {
      $narration = $this->narration_model->find('chitti_purity', array('name' => $metal_voucher_detail['narration'],
                                                                       'chain_purity' => $metal_voucher_detail['purity']));
      if (!empty($narration))
        $this->data['metal_voucher_details'][$index]['chitti_purity'] = $narration['chitti_purity'];
      else
        $this->data['metal_voucher_details'][$index]['chitti_purity'] = 0;
    }
  }

  public function _get_form_data() {
    if (!empty($_GET['account_name']))
      $this->data['record']['account_name'] = $_GET['account_name'];
    if (!empty($_GET['purity']))
      $this->data['record']['purity'] = $_GET['purity'];

    $where=array('voucher_type'=>'metal issue voucher','chitti_id'=>'');

    if (!empty($_GET['purity']))
    $where['purity']=$_GET['purity'];

    if(!empty($this->data['record']['account_name'])){
      $where['account_name']=$this->data['record']['account_name'];
      $this->data['metal_vouchers'] = $this->voucher_model->get('',$where);
    } else {
      $this->data['metal_vouchers'] = array();
    }

     $this->data['purity'] = $this->narration_model->get('distinct(chain_purity) as name,chain_purity as  id', array() ,array(), array('order_by'=>'id asc'));
    
    if ($this->router->method == 'store' || $this->router->method == 'update') {
      $this->data['record']['chittis'] = $_POST['chittis'];
      $this->data['chittis_details'] = @$_POST['chittis_details'];
    }
  }

  public function store() {
    $this->data['redirect_url'] = '/argold/chittis';
    parent::store();
  }
}