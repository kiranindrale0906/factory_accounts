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
    $packet_no=array_column($this->data['metal_voucher_details'],'packet_no');
    $this->data['packet_nos']=array_unique($packet_no);


    $this->data['chittis_details'] = $this->chitti_model->find('account_name,date',array('id'=>$this->data['record']['id']));

    // foreach ($this->data['metal_voucher_details'] as $index => $metal_voucher_detail) {
    //   $narration = $this->narration_model->find('chitti_purity', array('name' => $metal_voucher_detail['narration'],
    //                                                                    'chain_purity' => $metal_voucher_detail['purity']));
    //   if (!empty($narration))
    //     $this->data['metal_voucher_details'][$index]['chitti_purity'] = $narration['chitti_purity'];
    //   else
    //     $this->data['metal_voucher_details'][$index]['chitti_purity'] = 0;
    // }
  }

  public function _get_form_data() {
    if (!empty($_GET['account_name']))
      $this->data['record']['account_name'] = $_GET['account_name'];
    if (!empty($_GET['purity']))
      $this->data['record']['purity'] = $_GET['purity'];

    $where=array('voucher_type'=>'metal issue voucher','chitti_id'=>'','packet_no!='=>0);

    if (!empty($_GET['purity']))
    $where['purity']=$_GET['purity'];

    if(!empty($this->data['record']['account_name'])){
      $where['account_name']=$this->data['record']['account_name'];
      $this->data['metal_vouchers'] = $this->voucher_model->get('sum(credit_weight) as credit_weight,
                                           (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                                           (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,"" as voucher_number,packet_no,voucher_date,group_concat(narration) as narration',$where,array(),array('group_by'=>'packet_no,voucher_date'));
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